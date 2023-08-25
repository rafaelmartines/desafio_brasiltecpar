<?php

namespace App\Controller;

use App\Service\BatchService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use App\Dto\HashDto;
use App\Entity\Batch;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

/**
 * HashController
 * @Route("/api", name="api_")
 */
class HashController extends AbstractController {

    private BatchService $batchService;
    
    /**
     * __construct
     *
     * @param  mixed $batchService
     * @return void
     */
    public function __construct(BatchService $batchService)
    {
        $this->batchService = $batchService;
    }
        
    /**
     * encontrarHash
     *
     * @Route("/hash", name="hash", methods={"POST"})
     * @OA\RequestBody(@Model(type=HashDto::class)))
     * @param  mixed $request
     * @param  mixed $anonymousApiLimiter
     * @return JsonResponse
     */
    public function criarHash(Request $request, RateLimiterFactory $anonymousApiLimiter): JsonResponse
    {
        $limiter = $anonymousApiLimiter->create($request->getClientIp());
        $limit = $limiter->consume(10);
        
        if (false === $limit->isAccepted()) {
            throw new TooManyRequestsHttpException();
        }

        $data = json_decode($request->getContent(), true);

        $batch = $this->batchService->transformar($data['valor']);

        return new JsonResponse($batch);
    }
    
    /**
     * encontrarHash
     *
     * @Route("/encontrar", name="encontrar", methods={"GET"})
     * @OA\Parameter(
     *     name="numeroTentativas",
     *     in="query",
     *     description="Filtrar por até um número de tentativas",
     *     @OA\Schema(type="string")
     * )
     * @param  mixed $request
     * @param  mixed $em
     * @return void
     */
    public function encontrarHash(Request $request, EntityManagerInterface $em)
    {
        $numeroTentativas = $request->query->get('numeroTentativas');

        if (!is_numeric($numeroTentativas)) {
            throw new BadRequestException();
        }

        $resultado = $em->createQuery('select b.batch, b.numeroBloco, b.stringEntrada, b.chaveEncontrada from App\Entity\Batch b')
            ->getResult();
        
        $query = $em->createQueryBuilder()->select('b.batch, b.numeroBloco, b.stringEntrada, b.chaveEncontrada')
            ->from('App\Entity\Batch', 'b');
        
        if (null !== $numeroTentativas) {
            $query = $query->where($query->expr()->lte('b.numeroTentativas', $numeroTentativas));
        }
        
        $resultado = $query->getQuery()->getResult();
        
        return new JsonResponse($resultado);
    }
}

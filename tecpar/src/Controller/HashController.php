<?php

namespace App\Controller;

use App\Service\BatchService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\RateLimiter\RateLimiterFactory;

class HashController extends AbstractController {

    private BatchService $batchService;

    public function __construct(BatchService $batchService)
    {
        $this->batchService = $batchService;
    }

    /**
     * @Route("/hash", name="hash", methods={"POST"})
     */
    public function encontrarHash(Request $request, RateLimiterFactory $anonymousApiLimiter): JsonResponse {

        $limiter = $anonymousApiLimiter->create($request->getClientIp());
        $limit = $limiter->consume(10);
        
        if (false === $limit->isAccepted()) {
            throw new TooManyRequestsHttpException();
        }

        $data = json_decode($request->getContent(), true);

        $batch = $this->batchService->transformar($data['valor']);

        return new JsonResponse($batch);
    }
}

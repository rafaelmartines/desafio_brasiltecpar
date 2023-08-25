<?php

namespace App\Service;

use App\Entity\Batch;
use App\Helper\BatchHelper;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class BatchService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function transformar(string $valor, int $numeroBloco = 0): array
    {
        $numeroTentativas = 0;
        do {
            $chaveEncontrada = BatchHelper::generateRandomString();
            $hashGerado = BatchHelper::gerarHash($valor, $chaveEncontrada);
            $validarHash = BatchHelper::validarPrefixo($hashGerado);
            $numeroTentativas++;
        } while(false == $validarHash);

        $batch = new Batch();
        $batch->setNumeroBloco($numeroBloco);
        $batch->setBatch(new DateTime());
        $batch->setStringEntrada($valor);
        $batch->setChaveEncontrada($chaveEncontrada);
        $batch->setHashGerado($hashGerado);
        $batch->setNumeroTentativas($numeroTentativas);
        $this->entityManager->persist($batch);
        $this->entityManager->flush();
        
        return [
            'hashGerado' => $hashGerado, 
            'chaveEncontrada' => $chaveEncontrada, 
            'numeroTentativas' => $numeroTentativas
        ];
    }
}

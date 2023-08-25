<?php

namespace App\Command;

use App\Service\BatchService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BatchCommand extends Command {
    protected static $defaultName = "avato:test";
    protected static $defaultDescription 
        = "Cria um batch de hashs em looping de acordo com os parametros de requests";

    private BatchService $batchService;

    public function __construct(BatchService $batchService)
    {
        $this->batchService = $batchService;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('string', InputArgument::REQUIRED, 'String a ser transformado em hash')
            ->addOption('requests', 'rs', InputOption::VALUE_REQUIRED, 'Número de Requests')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $string = $input->getArgument('string');
        $requests = $input->getOption('requests');

        $batch = $this->batchService->transformar($string, 1);
        $hashGerado = $batch['hashGerado'];
        $output
            ->writeln("<info>Hash Gerado: ".$hashGerado.", Chave Encontrada: ".$batch['chaveEncontrada'].", Número de tentativas: ". $batch['numeroTentativas'] ."</info>"
        );

        
        for ($i=1; $i <= (int) $requests; $i++) {
            $batch = $this->batchService->transformar($hashGerado, $i);
            $output
                ->writeln("<info>Hash Gerado: ".$hashGerado.", Chave Encontrada: ".$batch['chaveEncontrada'].", Número de tentativas: ". $batch['numeroTentativas'] ."</info>"
            );
            $hashGerado = $batch['hashGerado'];
        }

        return Command::SUCCESS;
    }
}
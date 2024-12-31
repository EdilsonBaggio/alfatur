<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OneCodeController extends Command
{
    /**
     * Nome e assinatura do comando Artisan.
     *
     * @var string
     */
    protected $signature = 'onecode:run';

    /**
     * Descrição do comando Artisan.
     *
     * @var string
     */
    protected $description = 'Executa a funcionalidade do OneCodeController';

    /**
     * Cria uma nova instância do comando.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Lógica para executar o comando.
     */
    public function handle()
    {
        $this->info('Executando o comando OneCodeController!');
        // Adicione a lógica específica aqui
    }
}

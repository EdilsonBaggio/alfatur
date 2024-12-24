<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class updateGroups extends Command
{
    private $onecode;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:groups';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(OneCodeController $onecode) {
        parent::__construct();
        $this->onecode = $onecode;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->onecode->getGruposToSave();
        $this->info('Os grupos foram processados, caso não estejam atualizados no banco de dados verifiquem o arquivo de log.');
    }
}

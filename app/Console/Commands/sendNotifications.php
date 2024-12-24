<?php

namespace App\Console\Commands;

use App\Http\Controllers\NotificationsController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class sendNotifications extends Command
{
    protected $notification;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(NotificationsController $notification) {
        parent::__construct();
        $this->notification = $notification;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $result = $this->notification->sendNotification();

        $this->info($result);
    }
}

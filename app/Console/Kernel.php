<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
       $schedule->command('app:send-domain-renew-reminder')->daily();
    }

    // protected $commands = [
    //     Commands\SendDomainRenewReminder::class,
    // ];

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {

        $this->load(__DIR__.'/Commands');
        // $this->load(__DIR__.'/Commands/DomainRenewReminder.php'); // Uncomment if you have a specific command file
        require base_path('routes/console.php');


    }
}

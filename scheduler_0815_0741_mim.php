<?php
// 代码生成时间: 2025-08-15 07:41:18
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Scheduler extends ConsoleKernel
{
    protected $commands = [
        // Register tasks here
    ];

    protected function schedule(Schedule \$schedule)
    {
        // Define scheduled tasks here
        \$schedule->command('your:command')->daily()->at('00:00');
    }
}

// Usage of Scheduler
// php artisan schedule:run

// Register the custom scheduler in app/Console/Kernel.php
// protected \$commands = [
//     Scheduler::class,
// ];

// Define the command in app/Console/Commands
// namespace App\Console\Commands;
// use Illuminate\Console\Command;
// use App\Jobs\YourJob;

// class YourCommand extends Command
// {
//     protected \$signature = 'your:command';
//     protected \$description = 'Description of your command';

//     public function handle()
//     {
//         // Logic for your command
//         \$job = new YourJob(/* arguments */);
//         \$this->dispatch(\$job);
//     }
// }

// Define the job in app/Jobs
// namespace App\Jobs;
// use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Queue\InteractsWithQueue;
// use Illuminate\Queue\SerializesModels;

// class YourJob implements ShouldQueue
// {
//     use InteractsWithQueue, Queueable, SerializesModels;

//     public function __construct(/* arguments */)
//     {
//         //
//     }

//     public function handle()
//     {
//         // Logic for your job
//     }

//     public function failed(/* arguments */)
//     {
//         // Logic for handling job failure
//     }
// }

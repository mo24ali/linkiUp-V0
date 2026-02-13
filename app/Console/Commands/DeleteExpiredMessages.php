<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Message;
class DeleteExpiredMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'messages:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $toDeleteMessages = Message::where(
            'created_at',
            '<',
            now()->subHours(24)
            )->delete();
    }
}

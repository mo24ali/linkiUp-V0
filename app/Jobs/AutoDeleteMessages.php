<?php

namespace App\Jobs;

use App\Models\Message;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AutoDeleteMessages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Starting auto-deletion of messages.');

        // Find users with auto-delete enabled
        $users = User::where('auto_delete_enabled', true)->get();

        foreach ($users as $user) {
            // Logic: Delete messages where sender is this user AND created_at < 24 hours ago
            // OR should it be messages *in* their conversations?
            // "The job queries and deletes messages where created_at < NOW() - INTERVAL 24 HOUR AND the user has auto-deletion enabled"
            // Usually this means messages *sent by* the user.

            $cutoff = Carbon::now()->subHours(24);

            // Delete messages sent by this user
            $deletedCount = Message::where('sender_id', $user->id)
                ->where('created_at', '<', $cutoff)
                ->delete();

            if ($deletedCount > 0) {
                Log::info("Deleted {$deletedCount} messages for user {$user->id}");
            }
        }

        Log::info('Auto-deletion complete.');
    }
}

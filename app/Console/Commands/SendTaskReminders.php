<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Notifications\TaskReminder;
use Illuminate\Console\Command;

class SendTaskReminders extends Command
{
    protected $signature = 'tasks:send-reminders';
    protected $description = 'Send reminders for upcoming tasks';

    public function handle(): void
    {
        $tasks = Task::where('due_date', '<=', now()->addDay())
            ->where('due_date', '>', now())
            ->where('status', '!=', 'completed')
            ->with('assignee')
            ->get();

        foreach ($tasks as $task) {
            if ($task->assignee) {
                $task->assignee->notify(new TaskReminder($task));
            }
        }

        $this->info("Sent {$tasks->count()} task reminders.");
    }
}
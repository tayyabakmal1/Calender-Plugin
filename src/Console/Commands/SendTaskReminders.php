<?php

namespace Platform\Plugins\Calendar\Console\Commands;

use Illuminate\Console\Command;
use Platform\Plugins\Calendar\Models\Task;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendTaskReminders extends Command
{
    protected $signature = 'calendar:send-reminders';
    protected $description = 'Send reminder emails for tasks due tomorrow.';

    public function handle()
    {
        $tomorrow = Carbon::tomorrow();
        $tasks = Task::where('reminder_sent', false)
            ->whereDate('start_date', $tomorrow)
            ->get();

        foreach ($tasks as $task) {
            // Send email (implement your mail logic here)
            Mail::send('calendar::emails.reminder', ['task' => $task], function ($message) use ($task) {
                $message->to(config('mail.from.address'));
                $message->subject('Task Reminder: ' . $task->task_name);
            });
            $task->reminder_sent = true;
            $task->save();
        }

        $this->info('Reminders sent for ' . $tasks->count() . ' tasks.');
    }
} 
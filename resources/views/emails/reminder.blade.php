<p>Hello,</p>
<p>This is a reminder that the following task is due tomorrow:</p>
<ul>
    <li><strong>Task Name:</strong> {{ $task->task_name }}</li>
    <li><strong>Task Type:</strong> {{ $task->task_type }}</li>
    <li><strong>Start Date:</strong> {{ $task->start_date->format('Y-m-d') }}</li>
    <li><strong>End Date:</strong> {{ $task->end_date ? $task->end_date->format('Y-m-d') : '-' }}</li>
    <li><strong>Repetition:</strong> {{ __('calendar::calendar.repetition_' . $task->repetition) }}</li>
    <li><strong>Phone Number:</strong> {{ $task->phone_number }}</li>
</ul>
<p>Please make sure to complete it on time.</p>
<p>Thank you!</p> 
<?php

namespace Platform\Plugins\Calendar\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'calendar_tasks';

    protected $fillable = [
        'task_type',
        'repetition',
        'start_date',
        'end_date',
        'task_name',
        'phone_number',
        'reminder_sent',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'reminder_sent' => 'boolean',
    ];
} 
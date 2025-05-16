<?php

return [
    [
        'name' => 'calendar.index',
        'flag' => 'calendar.index',
        'parent_flag' => 'core.admin',
    ],
    [
        'name' => 'calendar.create',
        'flag' => 'calendar.create',
        'parent_flag' => 'calendar.index',
    ],
    [
        'name' => 'calendar.edit',
        'flag' => 'calendar.edit',
        'parent_flag' => 'calendar.index',
    ],
    [
        'name' => 'calendar.delete',
        'flag' => 'calendar.delete',
        'parent_flag' => 'calendar.index',
    ],
]; 
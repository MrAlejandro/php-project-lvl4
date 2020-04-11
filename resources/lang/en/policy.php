<?php

return [
    'task_status' => [
        'destroy' => [
            'not_authenticated' => 'Only authenticated users can remove tast statuses',
            'cannot_remove_assigned' => 'Cannot remove task status that is associated with a task',
        ],
    ],
    'label' => [
        'destroy' => [
            'not_authenticated' => 'Only authenticated users can remove labels',
            'cannot_remove_assigned' => 'Cannot remove label that is associated with a task',
        ],
    ],
];

<?php

$tasks = [
    [
        'classname' => 'plagiarism_plagscan\tasks\plagscan_check_automatically_pending_assign_task',
        'blocking' => 0,
        'minute' => '*/2',
        'hour' => '*',
        'day' => '*',
        'month' => '*',
        'dayofweek' => '*',
    ],
    [
        'classname' => 'plagiarism_plagscan\tasks\plagscan_check_deadline_pending_assign_task',
        'blocking' => 0,
        'minute' => '*/5',
        'hour' => '*',
        'day' => '*',
        'month' => '*',
        'dayofweek' => '*',
    ],
    [
        'classname' => 'plagiarism_plagscan\tasks\plagscan_update_frozen_checking_files_task',
        'blocking' => 0,
        'minute' => '*/5',
        'hour' => '*',
        'day' => '*',
        'month' => '*',
        'dayofweek' => '*',
    ],
    [
        'classname' => 'plagiarism_plagscan\tasks\plagscan_submit_rejected_files_task',
        'blocking' => 0,
        'minute' => '*/5',
        'hour' => '*',
        'day' => '*',
        'month' => '*',
        'dayofweek' => '*',
    ]
];

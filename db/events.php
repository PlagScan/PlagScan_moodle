<?php

$observers = array (
    array(
        'eventname' => '\assignsubmission_file\event\assessable_uploaded',
        'callback' => 'plagiarism_plagscan_observer::assignsubmission_file_uploaded'
    )
);
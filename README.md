# PlagScan Moodle Plugin 3.1.15 Release Notes

The advanced plagiarism checker plugin for moodle.

-------------

System requirements:
--------------------

    - moodle >= 2.4
    - PlagScan organisation account

Installation instruction:
-------------------------

http://www.plagscan.com/system-integration-moodle

User manual:
------------

https://api.plagscan.com/PlagScan_Moodle_Manual-Admin_EN.pdf

Bug Fix:
--------

- Add error message for files failed due to an error in the creation of the user or the user already was existing within another institution
- Add error message for files that failed during the status refresh of the file if the Client ID was changed on plugin settings
- Add status update for files that failed during the status refresh due to not have a plagiarism level result
- Add scheduled task to check frozen files from assignment with the option to check on deadline
- Add scheduled task to check frozen files from assignment with the option to check automatically

Special thanks:
---------------

    - Jesus and Kirupa for the time dedicate

Rubén Olmedo © PlagScan.com

Jesús Prieto © PlagScan.com

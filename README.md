# PlagScan Moodle Plugin 3.1.22 Release Notes

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

- Improve Deutsch translation strings
- Improve ajax calls when updating the file status
- Fix a bug that was showing plaintext data from ajax call in the interface output instead of returning to the previous page or refreshing it properly
- Improve the file status update, changing the status of the file in case of problems found during the conversion/check process
- Fix a bug that was showing the disclosure of the PlagScan Plugin even in other Moodle Activies that are not assignments, and also in assignments where PlagScan was not activated
- Improve the redirect from action to return to previous page with proper pagination

Special thanks:
---------------

    - Jesus and Kirupa for the time dedicate

Rubén Olmedo © PlagScan.com

Jesús Prieto © PlagScan.com

### Version: 3.1.24 Build: 2020031702

- Added defaults PlagScan settings for Assignments on the admin settings
- Added option to upload to PlagScan after final submission
  - Changed option for enable PlagScan for files submission: "Start check manually" for "Start check manually (Upload to PlagScan when students save a draft)"
  - Added new option for enable PlagScan for files submission: "Start check manually (Upload to PlagScan when students click on Submit button)"
- Fixed problem were report level class (icon color) was always red

### Version: 3.1.23 Build: 2020011000

- Add a button on admin settings to wipe the PlagScan User Cache table. This could be used to fix some inconsistency
- Add more checks and info messages in case there was some inconsistency between the Moodle Plugin data and PlagScan
- Add a retry when creates user in PlagScan in case it fails once
- Add and update strings

### Version: 3.1.22 Build: 2019110500

- Improve Deutsch translation strings
- Improve ajax calls when updating the file status
- Fix a bug that was showing plaintext data from ajax call in the interface output instead of returning to the previous page or refreshing it properly
- Improve the file status update, changing the status of the file in case of problems found during the conversion/check process
- Fix a bug that was showing the disclosure of the PlagScan Plugin even in other Moodle Activies that are not assignments, and also in assignments where PlagScan was not activated
- Improve the redirect from action to return to previous page with proper pagination

### Version: 3.1.21 Build: 2019101700

- Use trim to avoid problem setting the PlagScan server URL when adding extra trailing slash
- Remove log output that were shown during the resubmission of files

### Version: 3.1.20 Build: 2019101501

- Improve submit file process to avoid problems from assignments created with the old plugin version (<2.x.x)

### Version: 3.1.19 Build: 2019101005

- Improve submit file process to avoid problems when the files are associated to the Admin account

### Version: 3.1.18 Build: 2019101000

- Improve scheduled tasks in general and identify more problems in the process, updating the status of the file
- Add more status for files that failed during submission
- Update file status of frozen files

### Version: 3.1.17 Build: 2019100904

- Add scheduled task to resubmit files on resubmission state

### Version: 3.1.16 Build: 2019100902

- Add scheduled task to update status of files got frozen during checking progress
- Fix a problem when trying to refresh the status of the file it was not receiving the information in case the file was broken or rejected by PlagScan
- Fix support for files with extension on uppercase

### Version: 3.1.15 Build: 2019092503

- Add error message for files failed due to an error in the creation of the user or the user already was existing within another institution
- Add error message for files that failed during the status refresh of the file if the Client ID was changed on plugin settings
- Add status update for files that failed during the status refresh due to not have a plagiarism level result
- Add scheduled task to check frozen files from assignment with the option to check on deadline
- Add scheduled task to check frozen files from assignment with the option to check automatically

### Version: 3.1.14 Build: 2019090501

- Add resubmit button for file submission that were not able to be sent to PlagScan due an error (including API/server unreachable)
- Improve the submission to PlagScan workflow to detect errors during the process and show it afterwards
- Improve the assignment creation in PlagScan workflow to detec errors during the process and show it afterwards
- Added new error control and event for error creating the user in PlagScan

### Version: 3.1.13 Build: 2019090304

- Add option inside the assignment settings to enable PlagScan for files submission: submit files manually, with this option the files are send manually and not automatically by the plugin
- Change lang strings to update options

### Version: 3.1.12 Build: 2019082805

- Remove the assignment exclude options in the edit menu for assignments created from the old versions of the plugin (2.x)

### Version: 3.1.11 Build: 2019082804

- Add the assignment option to exclude assignment submissions from the institution repository
- Add the assignment option to ignore self-matches from the same participant's content across multiple submission attempts

### Version: 3.1.10 Build: 2019082700

- Add the submit option for files within old assignments created from old versions of the plugin (2.x) that were not submitted to PlagScan before
- Fix Ajax behaviour updating the status of the report

### Version: 3.1.9 Build: 2019082201

- Improve the access to report from sources matched for old versions using 'Internal Link URL' in PlagScan configuration
- Fix bugs with upgraded version of plugin from old versions (2.x) to see the report but also for involving teacher in the assignment

### Version: 3.1.8 Build: 2019081900

- Fix the problem that showed 'Not Submitted to PlagScan' message in files already submitted from previous versions (2.x)
- Allows the access to report from sources matched for old versions using 'Internal Link URL' in PlagScan configuration

### Version: 3.1.7 Build: 2019061700

- Add more Moodle Event 2 system for log general errors

### Version: 3.1.6 Build: 2019061101

    - Improve callback to receive information when a file check fails due to run out of Plagpoint credit
    - Add a warning icon in case a file check fails due to run out of Plagpoint credit
    - Add a check for connection to PlagScan server
    - Add a input to change PlagScan server (used for PlagScan-in-a-Box)

### Version: 3.1.5 Build: 2019051400

- Fix a bug where a task was showing an error when trying to get a file to upload that did not exist no longer during the process

### Version: 3.1.4 Build: 2019051008

 - Delete unused code and files
 - Better organization
 - Code review following Moodle standars and code styling guidelines
 - Added Moodle Event 2 system for logs
 - Added metadata provider using Moodle Privacy API for GDPR

### Version: 3.1.2 Build: 2019042900

- Fix a bug in the plugin table creation
- Add more logs

### Version: 3.1.1 Build: 2019040300

- Fix bug on upgrade process from previous versions
- Fix bug updating file status when it file during the upload process
- Removed unneeded code and files

### Version: 3.1.0 Build: 2019031300

- Stable Release

### Version: 3.0.0 

- Alpha Release

Jesús Prieto © PlagScan.com

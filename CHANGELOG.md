### Version: 2.4.4 Build: 2018021901

- Fix bug with individual teachers accounts and single account that makes the cron stop to working.

### Version: 2.4.3 Build: 2017120601

- Fix bug setting the plaglevel red and yellow on the individual user settings.

### Version: 2.4.2 Build: 2017041901

- Fix bug with the new images (now should work in subfolders).
- Adding the posibility to download the pdf report on shadowing urls.

### Version: 2.4.1 Build: 2017032101

- Fix bug with the new images (now should work in subfolders).
- Adding the posibility to download the pdf report on shadowing urls.

### Version: 2.4.0 Build: 2017030601

- New reports are avatible on Moodle.
- Change plain text links for a new beautifull icons (Thanks Koray)

### Version: 2.3.2 Build: 2017030401

- Control queries to avoid duplicate uploads in large cron process
- Fixed a problem with RFC HTTP 1.1 (now all customers can connect without problems)

### Version: 2.3.1 Build: 2016061401

- Changed some SQL queries for PostgreSQL compatibility

### Version: 2.3.0 Build: 2016052502

- added new global settings
    - Allow Categories
- added new submission setting
    - Students options

### Version: 2.2.7 Build: 2016051301

- Minor bugs with PlagScan url and users data.

### Version: 2.2.6 Build: 2016051101

- Fixed a bug where the user firstname and lastname was not shown on the welcome email.

### Version: 2.2.5 Build: 2016042701

- Minor bugs with PlagScan url and users data.

### Version: 2.2.4 Build: 2016042700

- Minor bugs with PlagScan url and users data.

### Version: 2.2.3 Build: 2016031000

-PlagScan is now disable by default when you create a submission (this prevent use credits without knowledge).

### Version: 2.2.2 Build: 2016010600

-Small fixes on how the plugin get and store the report.

### Version: 2.2.1 Build: 2015112700

- text highlighting script fix
!--new apache configuration needed for this release and all above | more info in the moodle manuals https://api.plagscan.com/PlagScan_Moodle_Manual-Admin_EN.pdf--!

### Version: 2.2 Build: 2015112400

- added restricted access to plugin >>> more capabilities
	- plagiarism/plagscan:enable
	- plagiarism/plagscan:control
	- plagiarism/plagscan:viewfullreport
- download report, view and source
- text highlighting in moodle
!--new apache configuration needed for this release and all above | more info in the moodle manuals https://api.plagscan.com/PlagScan_Moodle_Manual-Admin_EN.pdf--!

### Version: 2.1 Build: 2015110700

- added nondisclosure documents support
- added sharing reports with participants
- added enable/disable confirmation email with account credentials is now configurable on PlagScan settings page
- added more help boxes
- removed the field for disabling PlagScan autocheck is not necessary anymore (just raises trouble)
- chaged lots of strings were changed to get the plugin more self-explanatory
- chaged design improvements
- chaged higher input boxes to display all letters
- chaged ordering of PlagScan settings page
- chaged style for plag-level field
- fixed support for individual teacher accounts option
- fixed access on undefined properties
- fixed setType() error messages
- fixed get_context_instances error messages

### Version 2015071501

- Added more debugging text to see the files updated
- Fixed a bug in the cron job that cause some troubles in manual execution.

---
### Version 2015052701

- Added the proxy configuration to connect to plagscan server.
- Now if you have your proxy configured on moodle the plagscan plugin will connect to PlagScan servers via the proxy.
    (thanks to Joshua Westerway)

---
### Version 2015052601

- Some usability bug has been solved.

---
### Version 2015051201

- The new user email is send again (I don't know why disabled it in first place).
- Fix a little problem with the check scope. Now you always search in the whole web.

---
### Version 2015042004

- Added option to auto-start check after the due date:
Once the due date is reached all documents are being submitted to PlagScan at 
once and further documents prior to the cut-off date are submitted to PlagScan immediately.
- The upload delay depends on the moodle cron configuration.

---
### Version 2015010201

- Added option to check inmediately in submissions.
- The upload delay depends on the moodle cron configuration.


Daniel Gockel © PlagScan.com
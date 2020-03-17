<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * plagiarism_plagscan.php - All Strings
 *
 * @package     plagiarism_plagscan
 * @subpackage  plagiarism
 * @author      Ruben Olmedo <rolmedo@plagscan.com>
 * @copyright   2018 PlagScan GmbH {@link https://www.plagscan.com/}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
$string['allfileschecked'] = 'Check status of all documents on PlagScan’s server';
$string['always'] = 'Always';
$string['check'] = 'Check';
$string['api_language'] = 'Report language';
$string['api_language_help'] = 'All PlagScan reports will be downloaded in this language.';
$string['assignments'] = 'Assignments';
$string['autodel'] = 'Auto save document';
$string['autodescription'] = 'Check documents automatically when the deadline has approached';
$string['autodescriptionsubmitted'] = 'The files were automatically uploaded to PlagScan on {$a} - switch to the \'manual\' mode to resubmit individual documents';
$string['autostart'] = 'Autostart Plagiarism checks';
$string['badcredentials'] = 'PlagScan did not recognize the account details - please check if the "Client ID" and "API Key" are correct';
$string['checkallfilestatus'] = 'Update status of all submitted files';
$string['checkalltextstatus'] = 'Update status of all submitted text contents';
$string['checkstatus'] = 'Refresh status';
$string['checkthis'] = 'Submit content (online text) to PlagScan';
$string['checkthis2'] = 'Resubmit content (online text) to PlagScan';
$string['checkthis3'] = 'Check status of online content';
$string['check_automatically_pending_assign_task'] = 'Check frozen files from assignment with the option to check automatically';
$string['check_deadline_pending_assign_task'] = 'Check frozen files from assignment with the option to check on deadline';
$string['compareinternet'] = 'Data policy';
$string['connectionfailed'] = 'Failed to connect to PlagScan server';
$string['data_policy'] = 'Data policy';
$string['datapolicyhelp'] = 'Share my documents for analysis with (compare to)';
$string['datapolicyhelp_help'] = 'Share my documents for analysis with (compare to)';
$string['docxemail'] = 'Generate and email .docx report';
$string['docxgenerate'] = 'Generate only .docx report';
$string['docxnone'] = 'Do not generate .docx report';
$string['donotgenerate'] = 'Do not generate';
$string['downloadreport'] = 'Download .docx report';
$string['email_policy'] = 'Email policy';
$string['email_policy_always'] = 'Email all reports';
$string['email_policy_ifred'] = 'Email only if a red level is indicated';
$string['email_policy_never'] = 'Don’t email reports';
$string['email_policy_notification_account'] = 'Notification for new credentials';
$string['email_policy_notification_account_help'] = 'By <b>activating the checkbox</b>, all new generated <b>account credentials</b> will be immediately sent to you.';
$string['english'] = 'English';
$string['error_involving_assistant'] = 'Error involving the assistant into the assignment.';
$string['error_assignment_creation'] = 'Error creating assignment';
$string['error_user_creation'] = 'Error creating user';
$string['error_user_does_not_belong_to_the_institution'] = 'User in PlagScan does not belong to the institution';
$string['error_document_does_not_belong_to_the_institution'] = 'Document in PlagScan does not belong to the institution';
$string['error_submit'] = 'Problem submitting to PlagScan.';
$string['error_refresh_status'] = 'Problem getting the status of the file from PlagScan';
$string['exclude_from_repository'] = 'Exclude from repository';
$string['exclude_from_repository_help'] = 'Exclude all documents submitted for this assignment from the repository';
$string['exclude_self_matches'] = 'Ignore self-matches';
$string['exclude_self_matches_help'] = 'Do not flag the same participant\'s content across multiple submission attempts';
$string['filechecked'] = 'Document status checked on PlagScan server';
$string['filesassociated'] = 'Document will be uploaded to account \'{$a}\'';
$string['filesubmitted'] = 'Document \'{$a}\' is submitted to PlagScan';
$string['filetypeunsupported'] = 'The document type \'{$a}\' is an unsupported file by the PlagScan server';
$string['textunsupported'] = 'Unknown error in the text submission';
$string['textsubmitted'] = 'Text submission successfully done!';
$string['french'] = 'French';
$string['generaldatabase'] = 'Compare with general database';
$string['generateemail'] = 'Generate and email';
$string['generateonly'] = 'Generate only';
$string['german'] = 'German';
$string['handledocx'] = 'Docx option';
$string['if_plagiarism_level'] = 'Only red PlagLevel';
$string['individualaccounts'] = 'Individual teacher accounts';
$string['invalidupload'] = 'The PlagScan server did not accept the file {$a->filename}. The response was: {$a->content}';
$string['max_file_size'] = 'Maximum file size';
$string['maxfilesize'] = 'Maximum file size';
$string['maxfilesize_help'] = 'The file size is too big and can not be uploaded. Recommended value is 1000000.';
$string['months'] = 'After six months';
$string['myinstitution'] = 'Compare to institution database';
$string['never'] = 'Never';
$string['neverdelete'] = 'Never Delete';
$string['newexplain'] = 'For more information on this plugin see: ';
$string['nodeadlinewarning'] = 'Warning: An automatic submission to PlagScan was selected without indicating a deadline for this assignment';
$string['nomultipleaccounts'] = 'The use of individual teacher accounts for PlagScan is not possible on this server';
$string['nondisclosure_notice_desc'] = 'All non-disclosure documents will be submitted in "{$a}".<br /><br />';
$string['noone'] = 'Compare to web sources only';
$string['noonedocs'] = 'Compare to web and my documents';
$string['notprocessed'] = 'PlagScan has not checked this file yet';
$string['notprocessedcontent'] = 'PlagScan has not checked this text yet';
$string['notsubmitted'] = 'Not submitted to PlagScan';
$string['online_submission'] = 'Enable PlagScan for Online text submission';
$string['online_submission_help'] = 'Enables PlagScan for the Assignments that the students submit in plain text';
$string['online_text_yes'] = 'Yes';
$string['online_text_no'] = 'No';
$string['onlyassignmentwarning'] = 'Warning: An automatic submission to PlagScan only functions while using assignment activities';
$string['optin'] = 'Plagiarism opt-in';
$string['optin_explanation'] = 'You chose to opt-in to plagiarism detection. From now on, any assignments you submit will be uploaded to the PlagScan server to be compared with other documents';
$string['optout'] = 'Plagiarism opt-out';
$string['optout_explanation'] = 'You chose to opt-out of plagiarism detection. Your submitted assignments will <b>not</b> be compared with other documents submitted to the PlagScan server';
$string['plagscan'] = 'PlagScan';
$string['plagscan:control'] = 'Submit/Resubmit PlagScan Submissions';
$string['plagscan:enable'] = 'Enable/Disable PlagScan inside an acivity';
$string['plagscan:viewfullreport'] = 'View/Download PlagScan Reports';
$string['pluginname'] = 'PlagScan';
$string['plagscan_API_key'] = 'API Key';
$string['plagscan_API_key_help'] = 'You can see your API key on <a href="https://www.plagscan.com/apisetup" target="_blank">https://www.plagscan.com/apisetup</a>';
$string['plagscan_API_method'] = 'method';
$string['plagscan_client_id'] = 'Client ID';
$string['plagscan_client_username'] = 'Client Username';
$string['plagscan_client_username_help'] = 'Your PlagScan account name/registered email ID';
$string['plagscan_admin_email'] = 'Admin Email';
$string['plagscan_admin_email_help'] = 'Your PlagScan admin account registered email. This is necessary if you associate uploaded files with the main PlagScan account';
$string['plagscan_API_version'] = 'API Version';
$string['plagscan_API_version_help'] = 'Your latest API version is <b>3.0</b>';
$string['plagscan_call_back_script'] = 'Call back script URL';
$string['plagscan_multipleaccounts'] = 'Associate uploaded files with';
$string['plagscan_nondisclosure_notice_email'] = 'Non-disclosure documents';
$string['plagscan_nondisclosure_notice_email_desc'] = 'name@example.com';
$string['plagscan_nondisclosure_notice_email_help'] = 'All documents with blocking notice will be delivered to a separated PlagScan account. All documents located in account will <b>not be shared</b> with other organization users. The entered <b>email can not be part of another PlagScan account</b>.';
$string['plagscan_studentpermission'] = 'Students can refuse permission to upload to PlagScan';
$string['plagscan_web_policy'] = "Compare with Web sources";
$string['plagscan_own_workspace_policy'] = "Check against my documents";
$string['plagscan_own_repository_policy'] = "Check against my documents in the repository";
$string['plagscan_orga_repository_policy'] = "Check against my organization repository";
$string['plagscan_ppp_policy'] = "Check against the Plagiarism Prevention Tool";
$string['plagscanerror'] = ' PlagScan Error';
$string['plagscanexplain'] = 'PlagScan is a plagiarism checker. <br />The software compares documents within your own institution and external web sources. <br/>To take advantage of this plugin, you will need to create an <a href="https://www.plagscan.com" target="_blank">organization account</a>. <br /><br />You can find a guideline at <a href="https://www.plagscan.com/system-integration-moodle" target="_blank">www.plagscan.com/system-integration-moodle</a>. <br />Ask us for a free trial <a href="mailto:pro@plagscan.com">pro@plagscan.com</a> and read about our latest news on <a href="https://twitter.com/plagscan" target="_blank">Twitter</a>. <br /><br />General information can be found at <a href="https://www.plagscan.com" target="_blank">www.PlagScan.com</a><hr />';
$string['plagscanmethod'] = 'Submit';
$string['plagscanserver'] = 'PlagScan server';
$string['plagscanserver_help'] = 'The standard configuration is "<b>ssl://api.plagscan.com/v3</b>" or "<b>https://api.plagscan.com/v3</b>" if Moodle uses a proxy-server.';
$string['plagscanversion'] = '2.3';
$string['psreport'] = 'PS Report';
$string['process_checking'] = "The file is being checked...";
$string['process_uploading'] = "Uploading file to PlagScan...";
$string['red'] = 'The red PlagLevel starts at';
$string['report'] = 'Report';
$string['report_retrieve_error'] = 'Error retrieving the report. Could be the user does not have access to this report';
$string['report_check_error_cred'] = 'It is not possible to check the document right now due to insufficient PlagPoint credit';
$string['resubmit'] = 'Resubmit to PlagScan';
$string['runalways'] = "Start check immediately";
$string['runautomatic'] = 'Start check immediately after the first due date';
$string['runduedate'] = 'Start check immediately after all due dates';
$string['runmanual'] = 'Start check manually (Upload to PlagScan when students save a draft)';
$string['runsubmitmanual'] = 'Submit files manually';
$string['runsubmitonclosedsubmission'] = 'Start check manually (Upload to PlagScan when students click on Submit button)';
$string['save'] = 'Save';
$string['savedapiconfigerror'] = 'An error occurred updating your PlagScan settings';
$string['savedconfigsuccess'] = 'PlagScan settings saved successfully';
$string['savedapiconfigerror_admin_email'] = 'Make sure you entered a valid user email as "Admin Email"';
$string['serverconnectionproblem'] = 'Problem connecting to PlagScan server';
$string['serverrejected'] = 'The PlagScan server rejected this file - the file is broken, protected or contains few characters (min. 50 characters).';
$string['settings_cancelled'] = 'Antiplagiarism settings have been canceled';
$string['settings_saved'] = 'Antiplagiarism Settings Saved Successfully';
$string['settingsfor'] = 'Update account settings \'{$a}\'';
$string['settingsreset'] = 'Formular l&ouml;schen';
$string['show_to_students'] = 'Share results with students';
$string['show_to_students_actclosed'] = 'After due date';
$string['show_to_students_always'] = 'Always';
$string['show_to_students_help'] = 'All participants can see the PlagScan analysis results.';
$string['show_to_students_never'] = 'Never';
$string['singleaccount'] = 'The main PlagScan account';
$string['source_percentage_display'] = 'Hide plagiarism sources below (%)';
$string['source_percentage_default'] = '20';
$string['source_percentage_display_help'] = 'Hides the plagiarised content less than the mentioned percentage!';
$string['spanish'] = 'Spanish';
$string['ssty'] = 'Sensitivity';
$string['sstyhigh'] = 'High';
$string['sstylow'] = 'Low';
$string['sstymedium'] = 'Medium';
$string['studentdisclosure'] = 'Student Disclosure';
$string['studentdisclosure_help'] = 'This text will be displayed to all students on the file upload page.';
$string['studentdisclosuredefault'] = 'All files uploaded will be submitted to a plagiarism detection service';
$string['studentdisclosureoptedout'] = 'You have opted-out from plagiarism detection';
$string['studentdisclosureoptin'] = 'Click here to opt-in to plagiarism detection';
$string['studentdisclosureoptout'] = 'Click here to opt-out from plagiarism detection';
$string['submit'] = 'Submit file to PlagScan';
$string['submituseroptedout'] = 'File \'{$a}\' not submitted - the user has opted-out of plagiarism detection';
$string['submit_rejected_files_task'] = 'Resubmit files on resubmision state';
$string['testconnection'] = 'Test Connection';
$string['testconnection_fail'] = 'Connection failed!';
$string['testconnection_success'] = 'Connection was successful!';
$string['unsupportedfiletype'] = 'This file type is not supported by PlagScan';
$string['updateyoursettings'] = 'To your PlagScan settings';
$string['update_frozen_checking_files_task'] = "Update the status of files frozen as checking or in progress";
$string['useplagscan'] = 'Enable PlagScan';
$string['useplagscan_filessubmission'] = "Enable PlagScan for files submission";
$string['useplagscan_filessubmission_help'] = '<ul><li><b>Submit files manually</b>: you can choose when to send the file to Plagscan manually by pressing the submit button.</li>'
        . '<li><b>Start check manually (Upload to PlagScan when students save a draft)</b>: you will have to check each document manually. Files are sent to PlagScan every time students save a draft.</li>'
        . '<li><b>Start check manually (Upload to PlagScan when students click on Submit button)</b>: you will have to check each document manually. Files are sent to PlagScan only when students click on Submit button.'
        . ' This option is valid when the option "Require students click submit button" is enabled. </li>'
        . '<li><b>Start check immediately</b>: the PlagScan plugin will start analyzing documents automatically and immediately after uploading.</li>'
        . '<li><b>Start check immediately after the first due date</b>: the PlagScan plugin only starts when the first due date has passed. </li>'
        . '<li><b>Start check immediately after all due dates</b>: the plugin will begin analyzing the documents right after every deadline.</li></ul>';
$string['useroptedout'] = 'Opted-out of plagiarism detection';
$string['viewmatches'] = 'View matches';
$string['viewreport'] = 'View report';
$string['wasoptedout'] = 'User had opted-out of plagiarism detection';
$string['webonly'] = 'Search the web';
$string['week'] = 'After one week';
$string['weeks'] = 'After three months';
$string['windowsize'] = 'Window size';
$string['windowsize_help'] = 'Window size represents how granular the tech search will be. Recommended value is 60.';
$string['yellow'] = 'The yellow PlagLevel starts at';
$string['report_type'] = 'Report Type:';
$string['newrp_wait'] = 'Please wait, we are generating the link';
$string['newrp_redirect'] = 'You would be redirect automaticaly';
$string['sendqueuedsubmissions'] = 'Send Queued Files to PlagScan for the Plagiarism checking';
$string['show_to_students_opt2'] = "Share these results";
$string['show_to_students_opt2_help'] = "This allows the student to see only the PlagLevel or the full reports";
$string['show_to_students_plvl'] = "PlagLevel";
$string['show_to_students_links'] = "PlagLevel and Reports";
$string['allowgroups'] = "Allow Categories";
$string['allowgroups_help'] = "Type the category name that allows you to use PlagScan ( Ex: category1, category2, ... ). Leave the field blank to allow all categories";
$string['callback_setup'] = "The callback has been set up";
$string['callback_working'] = "The callback configuration is accepted";
$string['callback_notchecked'] = "The callback configuration has not been checked";
$string['callback_check'] = "Check the callback configuration";
$string['callback_help'] = "The callback configuration is important for getting the reports results when generated and syncronizing them with the Moodle Database";
$string['cron_reset_link'] = "RESET CRON";
$string['cron_reset'] = "The cron job has been reset";
$string['cron_normal'] = "The cronjob configuration is accepted";
$string['cron_running1'] = "Cron job is running since";
$string['cron_running2'] = " To reset click ";
$string['cron_help'] = "If you reset cron job duplicate files could be send to PlagScan";
$string['wipe_plagscan_user_cache_link'] = 'Wipe PlagScan User Cache';
$string['wipe_plagscan_user_cache_done'] = 'PlagScan User Cache wiped';
$string['wipe_plagscan_user_cache_error'] = 'Error wiping PlagScan User Cache';
$string['wipe_plagscan_user_cache_help'] = 'Clicking in this link will wipe the PlagScan Plugin User cache table.';
$string['wipe_plagscan_user_cache_alert'] = 'This function should only be used in case you have problems with the PlagScan plugin and it is user related, PlagScan support may require you to use this in case you need to solve some problems.';
$string['plagscan_user_id'] = 'PlagScan User ID';
$string['plagscan_assingment_id'] = 'PlagScan Assignment ID';
$string['error_assignment_or_owner_does_not_exist_or_belong'] = 'Could be that the assigment or the owner (the user who activated PlagScan for the assignment) does not exist anymore in PlagScan, or they belong to another institution';
$string['plagscan_assignment_defaults_header'] = 'PlagScan default settings for Assignments';
$string['plagscan_assignment_defaults_explain'] = 'These settings are set as default settings when an assignment is created. Users creating assignments will be able to change the settings according to their needs.';

$string['privacy:metadata:core_plagiarism'] = 'Plugin used by Moodle plagiarism system.';
$string['privacy:metadata:core_files'] = 'Files and online text that has been submitted using PlagScan plugin.';

$string['privacy:metadata:plagiarism_plagscan'] = 'Stores PlagScan files data.';
$string['privacy:metadata:plagiarism_plagscan:id'] = 'ID for each entry in the plagiarism_plagscan table.';
$string['privacy:metadata:plagiarism_plagscan:userid'] = 'The ID of the student.';
$string['privacy:metadata:plagiarism_plagscan:pid'] = 'The ID of the file in the PlagScan system.';
$string['privacy:metadata:plagiarism_plagscan:pstatus'] = 'The percentage of plagiarism in the file after it is checked.';
$string['privacy:metadata:plagiarism_plagscan:status'] = 'The state of the file in the PlagScan system.';
$string['privacy:metadata:plagiarism_plagscan:cmid'] = 'The ID of the context where the file was submitted.';
$string['privacy:metadata:plagiarism_plagscan:filehash'] = 'The hash of the file.';
$string['privacy:metadata:plagiarism_plagscan:updatestatus'] = 'Indicates if the files needs to be updated.';
$string['privacy:metadata:plagiarism_plagscan:submissiontype'] = 'Identicates what kind of submission has been done.';

$string['privacy:metadata:plagiarism_plagscan_config'] = 'Stores PlagScan Assignment data.';
$string['privacy:metadata:plagiarism_plagscan_config:id'] = 'ID for each entry in the plagiarism_plagscan_config table.';
$string['privacy:metadata:plagiarism_plagscan_config:cm'] = 'The ID of the context where the assignment was created.';
$string['privacy:metadata:plagiarism_plagscan_config:upload'] = 'Indicates what kind of upload process will be used for the files.';
$string['privacy:metadata:plagiarism_plagscan_config:complete'] = 'Identify if the assignment is complete.';
$string['privacy:metadata:plagiarism_plagscan_config:username'] = 'The username of the teacher who created the assignment.';
$string['privacy:metadata:plagiarism_plagscan_config:nondisclosure'] = 'Indicates if disclosure must be displayed.';
$string['privacy:metadata:plagiarism_plagscan_config:show_report_to_students'] = 'Indicates if students have access to the check result.';
$string['privacy:metadata:plagiarism_plagscan_config:show_students_links'] = 'Indicates if students have access to the report link.';
$string['privacy:metadata:plagiarism_plagscan_config:ownerid'] = 'The ID of the teacher who created the assignment.';
$string['privacy:metadata:plagiarism_plagscan_config:submissionid'] = 'The ID of the assignment in the PlagScan system.';
$string['privacy:metadata:plagiarism_plagscan_config:enable_online_text'] = 'Indicates if Online Text submission will be enabled.';
$string['privacy:metadata:plagiarism_plagscan_config:exclude_self_matches'] = 'Indicates if should flag the submissions from the same user across multiple submission attempts';
$string['privacy:metadata:plagiarism_plagscan_config:exclude_from_repository'] = 'Flag to exclude submissions from the repository.';


$string['privacy:metadata:plagiarism_plagscan_user'] = 'Stores PlagScan user data.';
$string['privacy:metadata:plagiarism_plagscan_user:id'] = 'ID for each entry in the plagiarism_plagscan_user table.';
$string['privacy:metadata:plagiarism_plagscan_user:userid'] = 'The ID of the user in Moodle.';
$string['privacy:metadata:plagiarism_plagscan_user:psuserid'] = 'The ID of the user in the PlagScan system.';


$string['privacy:metadata:plagiarism_external_plagscan_api'] = 'PlagScan API is the service this plugin use to integrate with PlagScan, exchanging data with Moodle.';
$string['privacy:metadata:plagiarism_external_plagscan_api:useremail'] = 'The email of the user.';
$string['privacy:metadata:plagiarism_external_plagscan_api:userfirstname'] = 'The firstname of the user.';
$string['privacy:metadata:plagiarism_external_plagscan_api:userlastname'] = 'The lastname of the user.';
$string['privacy:metadata:plagiarism_external_plagscan_api:fileformat'] = 'The format of the file.';
$string['privacy:metadata:plagiarism_external_plagscan_api:filedata'] = 'The data from the file.';
$string['privacy:metadata:plagiarism_external_plagscan_api:filename'] = 'The name of the file.';

$string['privacy:export:plagiarism_plagscan:filerecordcontentdescription'] = 'PlagScan report result for checked files.';


$string['event_file_upload_completed'] = 'The file upload to PlagScan is completed.';
$string['event_file_upload_started'] = 'The file upload to PlagScan is started.';
$string['event_file_upload_failed'] = 'The file upload to PlagScan failed.';
$string['event_user_creation_completed'] = 'User creation in PlagScan completed.';
$string['event_user_creation_started'] = 'User creation in PlagScan started.';
$string['event_user_creation_failed'] = 'User creation in PlagScan failed.';
$string['event_user_search_started'] = 'User search in PlagScan started.';
$string['event_user_search_completed'] = 'User search in PlagScan completed.';
$string['event_assign_creation_completed'] = 'Assignment creation in PlagScan completed.';
$string['event_assign_creation_started'] = 'Assignment creation in PlagScan started.';
$string['event_assign_update_completed'] = 'Assignment update in PlagScan completed.';
$string['event_callback_received'] = 'Callback from PlagScan received.';
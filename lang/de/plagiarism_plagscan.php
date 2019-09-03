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
 * @author      Ruben Olmedo  <rolmedo@plagscan.com>
 * @copyright   2018 PlagScan GmbH {@link https://www.plagscan.com/}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
$string['allfileschecked'] = 'Status aller Dokumente auf PlagScan Server gepr&uuml;ft';
$string['always'] = 'immer';
$string['check'] = 'Analisieren';
$string['api_language'] = 'Sprache der Berichte';
$string['api_language_help'] = 'Ihre PlagScan Berichte mit den Ergebnissen der PlagiatsprÃ¼fung werden in dieser Sprache vom Server heruntergeladen.';
$string['assignments'] = 'Aufgaben';
$string['autodel'] = 'Dokument automatisch speichern';
$string['autodescription'] = 'Dokumente werden zum Abgabetermin automatisch analysiert';
$string['autodescriptionsubmitted'] = 'Die Dokumente wurden automatisch bei PlagScan hochgeladen am {$a} - wechsele zum \'manuellen\' Modus, um einzelne Dokumente erneut einzureichen';
$string['autostart'] = 'Pr&uuml;fung automatisch starten';
$string['badcredentials'] = 'PlagScan hat die Zugangsdaten nicht erkannt, bitte prÃ¼fen Sie "Client ID" und "API Key" korrekt sind';
$string['checkallstatus'] = 'Aktualisiere den Status aller eingereichten Dokumente';
$string['checkstatus'] = 'Status pr&uuml;fen';
$string['compareinternet'] = 'Datenrichtlinie';
$string['connectionfailed'] = 'Verbindung zum PlagScan Server ist fehlgeschlagen';
$string['data_policy'] = 'Datenrichtlinie';
$string['datapolicyhelp'] = 'Datenrichtlinie';
$string['datapolicyhelp_help'] = 'Entscheiden Sie wem Ihre Dokumente zum Vergleich zur Verf&uuml;gung stehen und womit Sie Ihre Dokumente abgleichen m&ouml;chten.';
$string['docxemail'] = '.docx Bericht generieren and mailen';
$string['docxgenerate'] = '.docx Bericht nur generieren';
$string['docxnone'] = '.docx Bericht nicht generieren';
$string['donotgenerate'] = 'nicht erstellen';
$string['downloadreport'] = '.docx Bericht herunterladen';
$string['email_policy'] = 'Email Richtlinie';
$string['email_policy_always'] = 'Alle Berichte mailen';
$string['email_policy_ifred'] = 'Nur bei rotem Level mailen';
$string['email_policy_never'] = 'Keine Berichte mailen';
$string['email_policy_notification_account'] = 'Benachrichtigung fÃ¼r neue Zugangsdaten';
$string['email_policy_notification_account_help'] = 'Bei <b>aktivierter Checkbox</b> wird Ihnen bei der Erstellung eines neuen PlagScan-Accounts <b>das Passwort und der Nutzername per E-Mail zugeschickt</b>.';
$string['english'] = 'Englisch';
$string['error_involving_assistant'] = 'Error trying to involving the assistant into the submission';
$string['error_assignment_creation'] = 'Fehler beim Anlegen der Zuordnung';
$string['error_user_creation'] = 'Fehler beim Anlegen des Benutzers';
$string['exclude_from_repository'] = 'Aus dem Archiv ausschlie&szlig;en';
$string['exclude_from_repository_help'] = 'Alle Dokumente, die f&uuml;r diese Einreichung hochgeladen werden, aus dem Archiv ausschlie&szlig;en.';
$string['exclude_self_matches'] = 'Eigenplagiate ignorieren';
$string['exclude_self_matches_help'] = 'Texte desselben Teilnehmers (bei mehreren Einreichungsversuchen) nicht als Plagiat markieren';
$string['filechecked'] = 'Status des Dokuments auf PlagScan Server gepr&uuml;ft';
$string['filesassociated'] = 'Dokumente werden hochgeladen in das Konto \'{$a}\'';
$string['filesubmitted'] = 'Dokument \'{$a}\' ist bei PlagScan eingereicht';
$string['filetypeunsupported'] = 'Dokument \'{$a}\' hat einen Dateityp, der nicht von PlagScan unterst&uuml;tzt wird';
$string['french'] = 'FranzÃ¶sisch';
$string['generaldatabase'] = 'Abgleich mit allgemeiner Datenbank';
$string['generateemail'] = 'Generieren und Mailen';
$string['generateonly'] = 'Nur Generieren';
$string['german'] = 'Deutsch';
$string['handledocx'] = 'Docx Option';
$string['if_plagiarism_level'] = 'bei rotem PlagLevel';
$string['individualaccounts'] = 'Individuelle Lehrerkonten';
$string['invalidupload'] = 'Der PlagScan Server hat die Datei {$a->filename} nicht akzeptiert. Die Antwort war: {$a->content}';
$string['max_file_size'] = 'Maximale Dateigr&ouml;&szlig;e';
$string['maxfilesize'] = 'Maximale Dateigr&ouml;&szlig;e';
$string['maxfilesize_help'] = 'Gr&ouml;&szlig;ere Dateien werden nicht transferiert. Empfohlener Wert ist 1000000.';
$string['months'] = 'nach sechs Monaten';
$string['myinstitution'] = 'Abgleich mit Organisationsdatenbank';
$string['never'] = 'nie';
$string['neverdelete'] = 'nie l&ouml;schen';
$string['newexplain'] = 'F&uuml;r weitergehende Informationen zum PlugIn siehe: ';
$string['nodeadlinewarning'] = 'Warnung: automatisches Einreichen f&uuml;r PlagScan ist ausgew&auml;hlt, aber keine Abgabefrist wurde gesetzt';
$string['nomultipleaccounts'] = 'Das Nutzen individueller Nutzerkonten ist auf dem Server nicht aktiviert.';
$string['nondisclosure_notice_desc'] = 'Sperrvermerkdokumente werden im Account "{$a}" abgelegt.<br /><br />';
$string['noone'] = 'Abgleich mit Web';
$string['noonedocs'] = 'Abgleich mit Web und meinen Dokumenten';
$string['notprocessed'] = 'PlagScan hat diese Datei noch nicht analysiert';
$string['notsubmitted'] = 'Nicht bei PlagScan eingereicht';
$string['online_submission'] = 'Aktiviere PlagScan f&uuml;r die online Texteingabe';
$string['online_submission_help'] = 'Aktiviert das Texteingabefeld mit Editor f&uuml;r PlagScan Einreichungen.';
$string['online_text_yes'] = 'Ja';
$string['online_text_no'] = 'Nein';
$string['onlyassignmentwarning'] = 'Warnung: automatisches Einreichen funktioniert nur mit assignment activities';
$string['optin'] = 'Plagiatpr&uuml;fung zulassen';
$string['optin_explanation'] = 'Sie haben sich entschieden die Plagiatpr&uuml;fung zuzulassen. Von nun an werden alle Ihre Arbeiten auf dem PlagScan Server hochgeladen und gepr&uuml;ft';
$string['optout'] = 'Plagiatpr&uuml;fung verweigern';
$string['optout_explanation'] = 'Sie haben sich entschieden die Plagiatpr&uuml;fung zu verweigern. Von nun an werden keine Arbeiten mehr auf dem PlagScan Server hochgeladen und gepr&uuml;ft';
$string['plagscan'] = 'PlagScan';
$string['plagscan:control'] = 'Einreichung von Dokumenten f&ouml;r PlagScan';
$string['plagscan:enable'] = 'PlagScan in einer Aufgabe aktivieren/deaktivieren';
$string['plagscan:viewfullreport'] = 'PlagScan berichte lesen und herunterladen';
$string['pluginname'] = 'PlagScan';
$string['plagscan_admin_email'] = 'Admin Email';
$string['plagscan_admin_email_help'] = 'Your PlagScan admin account registered email. This is necessary if you associate uploaded files with the main PlagScan account';
$string['plagscan_API_key'] = 'API Key';
$string['plagscan_API_key_help'] = 'Ihren API Key finden Sie auf der Seite <a href="https://www.plagscan.com/apisetup" target="_blank">https://www.plagscan.com/apisetup</a>';
$string['plagscan_API_method'] = 'Methode';
$string['plagscan_API_username'] = 'API Nutzername';
$string['plagscan_API_version'] = 'API Version';
$string['plagscan_API_version_help'] = 'Die aktuelle API Version ist <b>2.1</b>';
$string['plagscan_call_back_script'] = 'Call Back Script URL';
$string['plagscan_multipleaccounts'] = 'Verkn&uuml;pfe hochgeladenen Dateien mit';
$string['plagscan_nondisclosure_notice_email'] = 'Sperrvermerkdokumente';
$string['plagscan_nondisclosure_notice_email_desc'] = 'name@example.com';
$string['plagscan_nondisclosure_notice_email_help'] = 'Sperrvermerkdokumente werden in einem gesonderten Account abgelegt. Alle Dokumente im gesonderten Account werden fÃ¼r andere Nutzer der Organisation <b>nicht freigegeben</b>. Die <b>E-Mail sollte zu keinem anderen PlagScan-Account gehÃ¶ren</b>.';
$string['plagscan_studentpermission'] = 'Studenten k&ouml;nnen den Einsatz von PlagScan verweigern';
$string['plagscan_web_policy'] = "Mit Webquellen abgleichen";
$string['plagscan_own_workspace_policy'] = "Mit eigenen Dokumenten abgleichen";
$string['plagscan_own_repository_policy'] = "Mit meinen Dokumenten aus dem Organisationsarchiv vergleichen";
$string['plagscan_orga_repository_policy'] = "Mit dem gesamten Organisationsarchiv vergleichen";
$string['plagscan_ppp_policy'] = "Mit dem Plagiat-PrÃ¤ventions-Pool vergleichen";
$string['plagscanerror'] = 'Fehler von PlagScan Server: {$a}';
$string['plagscanexplain'] = 'PlagScan ist ein Werkzeug zur Plagiatpr&uuml;fung. <br />Es vergleicht Arbeiten innerhalb einer Organisation sowie m&ouml;gliches Kopieren aus dem Internet und Verlagsdatenbanken. <br> F&uuml;r die Nutzung des Plugins ist ein <a href="https://www.plagscan.com" target="_blank">Organisations-Account</a> erforderlich.<br /><br />Eine Erkl&auml;rung zum PlagScan Moodle Plugin finden Sie unter <a href="https://www.plagscan.com/system-integration-moodle" target="_blank">www.plagscan.com/system-integration-moodle</a>.<br>Kontaktieren Sie uns f&uuml;r einen kostenlosen Test <a href="mailto:pro@plagscan.com">pro@plagscan.com</a><br>und verpassen Sie keine Neuigkeiten auf <a href="https://twitter.com/plagscan" target="_blank">Twitter</a><br /><br />Generelle Informationen finden Sie auf unserer Website: <a href="https://www.plagscan.com" target="_blank">www.PlagScan.com</a><hr />';
$string['plagscanmethod'] = 'Einreichen';
$string['plagscanserver'] = 'PlagScan API Server';
$string['plagscanserver_help'] = 'Der Standard Server ist "<b>ssl://api.plagscan.com/v3/</b>" oder "<b>https://api.plagscan.com/v3/</b>" bei Verwendung eines Proxies';
$string['plagscanversion'] = '2.3';
$string['pluginname'] = 'PlagScan';
$string['psreport'] = 'PS Bericht';
$string['process_checking'] = "Die Datei wird gerade analysiert...";
$string['process_uploading'] = "Hochladen der Datei in PlagScan...";
$string['red'] = 'PlagLevel rot startet bei';
$string['report'] = 'Bericht';
$string['report_retrieve_error'] = 'Error retrieving the report. Could be the user does not have access to this report';
$string['report_check_error_cred'] = 'Eine &Uuml;berpr&uuml;fung des Dokuments ist derzeit aufgrund unzureichender PlagPoint Guthaben nicht m&ouml;glich.';
$string['resubmit'] = 'Nochmal bei PlagScan einreichen';
$string['runalways'] = "Analyse sofort bei Abgabe starten";
$string['runautomatic'] = 'Analyse sofort nach dem ersten Abgabetermin starten';
$string['runduedate'] = 'Analyse bei allen Abgabeterminen starten';
$string['runmanual'] = 'Analyse manuell starten';
$string['runsubmitmanual'] = 'Datei manuell einreichen';
$string['save'] = 'Speichern';
$string['savedapiconfigerror'] = 'Es gab einen Fehler beim Speichern der PlagScan Einstellungen';
$string['savedconfigsuccess'] = 'PlagScan Einstellungen gespeichert';
$string['savedapiconfigerror_admin_email'] = 'Make sure you entered a valid user email as "Admin Email"';
$string['serverconnectionproblem'] = 'Problem mit der Verbindung zum PlagScan Server';
$string['serverrejected'] = 'Der PlagScan Server hat diese Datei abgelehnt - sie ist besch&auml;digt, gesch&uuml;tzt oder enthÃ¤lt wenige Zeichen (Mindestens 50 Zeichen verwenden).';
$string['settings_cancelled'] = 'Einstellungen nicht gespeichert';
$string['settings_saved'] = 'Einstellungen erfolgreich gespeichert';
$string['settingsfor'] = 'Aktualisiere Einstellungen f&uuml;r PlagScan Konto \'{$a}\'';
$string['settingsreset'] = 'Formular l&ouml;schen';
$string['show_to_students'] = 'Ergebnisse mit Teilnehmern teilen';
$string['show_to_students_actclosed'] = 'Nach Abgabetermin';
$string['show_to_students_always'] = 'Immer';
$string['show_to_students_help'] = 'Teilnehmer k&ouml;nnen nach der PlagScan-Analyse Ihre Ergebnisse sehen. ';
$string['show_to_students_never'] = 'Nie';
$string['singleaccount'] = 'Das PlagScan-Admin Konto';

$string['spanish'] = 'Spanisch';
$string['ssty'] = 'Sensitivit&auml;t';
$string['sstyhigh'] = 'hoch';
$string['sstylow'] = 'niedrig';
$string['sstymedium'] = 'mittel';
$string['studentdisclosure'] = 'Studentenmitteilung';
$string['studentdisclosure_help'] = 'Dieser Text wird allen Studenten beim Hochladen Ihrer Datei angezeigt.';
$string['studentdisclosuredefault'] = 'Alle hochgeladenen Dokumente, werden bei PlagScan eingereicht';
$string['studentdisclosureoptedout'] = 'Sie haben die Plagiatpr&uuml;fung verweigert';
$string['studentdisclosureoptin'] = 'Klicke hier um die Plagiatpr&uuml;fung zu bewilligen';
$string['studentdisclosureoptout'] = 'Klicke hier um die Plagiatpr&uuml;fung zu verweigern';
$string['submit'] = 'Einreichen bei PlagScan';
$string['submituseroptedout'] = 'Datei \'{$a}\' nicht eingereicht - der Nutzer hat eine Plagiatpr&uuml;fung verweigert';
$string['testconnection'] = 'Teste Verbindung';
$string['testconnection_fail'] = 'Verbindung fehlgeschlagen!';
$string['testconnection_success'] = 'Verbindung war erfolgreich!';
$string['unsupportedfiletype'] = 'Dieses Dateiformat wird nicht von PlagScan unterst&uuml;tzt';
$string['updateyoursettings'] = 'Zu Ihren PlagScan Einstellungen';
$string['useplagscan'] = 'Aktiviere PlagScan';
$string['useplagscan_filessubmission'] = "Aktiviere PlagScan f&uuml;r Einreichung von Dateien";
$string['useplagscan_filessubmission_help'] = '<ul><li><b>Datei manuell einreichen</b>: Sie k&ouml;nnen die Datei jederzeit manuell an Plagscan senden, indem Sie auf den Button Einreichen bei PlagScan klicken. </li>'
        . '<li><b>Analyse manuell starten</b>: Sie m&uuml;ssen jedes Dokument einzeln f&uuml;r die Pr&uuml;fung anw&auml;hlen. </li>'
        . '<li><b>Analyse sofort bei Abgabe starten</b>: PlagScan analysiert das Dokument automatisch und sofort nach dem Hochladen. </li>'
        . '<li><b>Analyse sofort nach dem ersten Abgabetermin starten</b>: PlagScan startet nachdem die letzte Abgabem&ouml;glichkeit abgelaufen ist. </li>'
        . '<li><b>Analyse bei allen Abgabeterminen starten: </b>Analyse sofort nachdem alle F&auml;lligkeiten abgelaufen sind.</li></ul>';
$string['useroptedout'] = 'Plagiatpr&uuml;fung verweigert';
$string['viewmatches'] = 'Zeige Liste';
$string['viewreport'] = 'Zeige Textbericht';
$string['wasoptedout'] = 'Nutzer hat eine Plagiatpr&uuml;fung verweigert';
$string['webonly'] = 'Im Web suchen';
$string['week'] = 'nach 1 Woche';
$string['weeks'] = 'nach drei Monaten';
$string['windowsize'] = 'Suchfenstergr&ouml;&szlig;';
$string['windowsize_help'] = 'Fenstergr&ouml;&szlig;e bestimmt wie genau die Textsuche sein wird. Empfohlener Wert 6.';
$string['yellow'] = 'PlagLevel gelb startet bei';
$string['report_type'] = 'Report Art:';
$string['newrp_wait'] = 'Bitte warten, wir generieren den Link';
$string['newrp_redirect'] = 'Sie werden automatisch weitergeleitet';

$string['show_to_students_opt2'] = "Teile die Ergebnisse";
$string['show_to_students_opt2_help'] = "Hier k&ouml;nnen Sie ausw&auml;hlen, welche Ergbnisse mit den Studenten geteilt werden. ";
$string['show_to_students_plvl'] = "PlagLevel";
$string['show_to_students_links'] = "PlagLevel und Berichte";
$string['allowgroups'] = "Kategorien erlauben";
$string['allowgroups_help'] = "Geben Sie den Namen Ihrer Kategorie ein, f&uuml;r die PlagScan verf&uuml;gbar sein soll (z.B.: Kategorie1, Kategorie2, ... ). Wenn Sie das Feld leer lassen, d&uuml;rfen alle Aufgabenersteller PlagScan nutzen.";
$string['callback_setup'] = "The callback has been set up";
$string['callback_working'] = "The callback configuration is accepted";
$string['callback_notchecked'] = "The callback configuration has not been checked";
$string['callback_check'] = "Check the callback configuration";
$string['callback_help'] = "The callback configuration is important for getting the reports results when generated and syncronizing them with the Moodle Database";
$string['cron_reset_link'] = "CRON ZUR&Uuml;CKSETZEN";
$string['cron_reset'] = "Der Cron Job wurde zur&uuml;ckgesetzt";
$string['cron_normal'] = "Die Cron Job Einstellung wurde akzeptiert";
$string['cron_running1'] = "Der Cron Job l&auml;ft seit";
$string['cron_running2'] = " Zum Zur&uuml;cksetzen klicken ";
$string['cron_help'] = "Wenn Sie den Cron Job zur&uuml;cksetzen kann es vorkommen, dass Dateien doppelt zu PlagScan geschickt werden.";

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
$string['event_user_search_started'] = 'User search in PlagScan started.';
$string['event_user_search_completed'] = 'User search in PlagScan completed.';
$string['event_assign_creation_completed'] = 'Assignment creation in PlagScan completed.';
$string['event_assign_creation_started'] = 'Assignment creation in PlagScan started.';
$string['event_assign_update_completed'] = 'Assignment update in PlagScan completed.';
$string['event_callback_received'] = 'Callback from PlagScan received.';
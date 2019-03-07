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
$string['api_language']='Sprache der Berichte';
$string['api_language_help']='Ihre PlagScan Berichte mit den Ergebnissen der Plagiatsprüfung werden in dieser Sprache vom Server heruntergeladen.';
$string['assignments']='Aufgaben';
$string['autodel']='Dokument automatisch speichern';
$string['autodescription'] = 'Dokumente werden zum Abgabetermin automatisch analysiert';
$string['autodescriptionsubmitted'] = 'Die Dokumente wurden automatisch bei PlagScan hochgeladen am {$a} - wechsele zum \'manuellen\' Modus, um einzelne Dokumente erneut einzureichen';
$string['autostart'] = 'Pr&uuml;fung automatisch starten';
$string['badcredentials'] = 'PlagScan hat die Zugangsdaten nicht erkannt, bitte prüfen Sie "Client ID" und "API Key" korrekt sind';
$string['checkallstatus'] = 'Aktualisiere den Status aller eingereichten Dokumente';
$string['checkstatus'] = 'Status pr&uuml;fen';
$string['compareinternet'] = 'Datenrichtlinie';
$string['connectionfailed'] = 'Verbindung zum PlagScan Server ist fehlgeschlagen';
$string['data_policy']='Datenrichtlinie';
$string['datapolicyhelp']='Datenrichtlinie';
$string['datapolicyhelp_help']='Entscheiden Sie wem Ihre Dokumente zum Vergleich zur Verf&uuml;gung stehen und womit Sie Ihre Dokumente abgleichen m&ouml;chten.';
$string['docxemail'] = '.docx Bericht generieren and mailen';
$string['docxgenerate'] = '.docx Bericht nur generieren';
$string['docxnone'] = '.docx Bericht nicht generieren';
$string['donotgenerate'] = 'nicht erstellen';
$string['downloadreport'] = '.docx Bericht herunterladen';
$string['email_policy'] = 'Email Richtlinie';
$string['email_policy_always'] = 'Alle Berichte mailen';
$string['email_policy_ifred'] = 'Nur bei rotem Level mailen';
$string['email_policy_never'] = 'Keine Berichte mailen';
$string['email_policy_notification_account'] = 'Benachrichtigung für neue Zugangsdaten';
$string['email_policy_notification_account_help'] = 'Bei <b>aktivierter Checkbox</b> wird Ihnen bei der Erstellung eines neuen PlagScan-Accounts <b>das Passwort und der Nutzername per E-Mail zugeschickt</b>.';
$string['english'] = 'Englisch';
$string['error_involving_assistant'] = "Error trying to involving the assistant into the submission";
$string['filechecked'] = 'Status des Dokuments auf PlagScan Server gepr&uuml;ft';
$string['filesassociated'] = 'Dokumente werden hochgeladen in das Konto \'{$a}\'';
$string['filesubmitted'] = 'Dokument \'{$a}\' ist bei PlagScan eingereicht';
$string['filetypeunsupported'] = 'Dokument \'{$a}\' hat einen Dateityp, der nicht von PlagScan unterst&uuml;tzt wird';
$string['french'] = 'Französisch';
$string['generaldatabase']='Abgleich mit allgemeiner Datenbank';
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
$string['myinstitution']='Abgleich mit Organisationsdatenbank';
$string['never'] = 'nie';
$string['neverdelete'] = 'nie l&ouml;schen';
$string['newexplain'] = 'F&uuml;r weitergehende Informationen zum PlugIn siehe: ';
$string['nodeadlinewarning'] = 'Warnung: automatisches Einreichen f&uuml;r PlagScan ist ausgew&auml;hlt, aber keine Abgabefrist wurde gesetzt';
$string['nomultipleaccounts'] = 'Das Nutzen individueller Nutzerkonten ist auf dem Server nicht aktiviert.';
$string['nondisclosure_notice_desc'] = 'Sperrvermerkdokumente werden im Account "{$a}" abgelegt.<br /><br />';
$string['noone']='Abgleich mit Web';
$string['noonedocs']='Abgleich mit Web und meinen Dokumenten';
$string['notprocessed'] = 'PlagScan hat diese Datei noch nicht analysiert';
$string['notsubmitted'] = 'Nicht bei PlagScan eingereicht';
$string['onlyassignmentwarning'] = 'Warnung: automatisches Einreichen funktioniert nur mit assignment activities';
$string['optin'] = 'Plagiatpr&uuml;fung zulassen';
$string['optin_explanation'] = 'Sie haben sich entschieden die Plagiatpr&uuml;fung zuzulassen. Von nun an werden alle Ihre Arbeiten auf dem PlagScan Server hochgeladen und gepr&uuml;ft';
$string['optout'] = 'Plagiatpr&uuml;fung verweigern';
$string['optout_explanation'] = 'Sie haben sich entschieden die Plagiatpr&uuml;fung zu verweigern. Von nun an werden keine Arbeiten mehr auf dem PlagScan Server hochgeladen und gepr&uuml;ft';
$string['plagscan']  ='PlagScan';
$string['plagscan:control'] = 'Einreichung von Dokumenten f&ouml;r PlagScan';
$string['plagscan:enable'] = 'PlagScan in einer Aufgabe aktivieren/deaktivieren';
$string['plagscan:viewfullreport'] = 'PlagScan berichte lesen und herunterladen';
$string['pluginname'] = 'PlagScan';
$string['plagscan_admin_email']='Admin Email';
$string['plagscan_admin_email_help']='Your PlagScan admin account registered email. This is necessary if you associate uploaded files with the main PlagScan account';
$string['plagscan_API_key'] = 'API Key';
$string['plagscan_API_key_help'] = 'Ihren API Key finden Sie auf der Seite <a href="https://www.plagscan.com/apisetup" target="_blank">https://www.plagscan.com/apisetup</a>';
$string['plagscan_API_method'] = 'Methode';
$string['plagscan_API_username']='API Nutzername';
$string['plagscan_API_version'] = 'API Version';
$string['plagscan_API_version_help'] = 'Die aktuelle API Version ist <b>2.1</b>';
$string['plagscan_call_back_script'] = 'Call Back Script URL';
$string['plagscan_multipleaccounts'] = 'Verkn&uuml;pfe hochgeladenen Dateien mit';
$string['plagscan_nondisclosure_notice_email'] = 'Sperrvermerkdokumente';
$string['plagscan_nondisclosure_notice_email_desc'] = 'name@example.com';
$string['plagscan_nondisclosure_notice_email_help'] = 'Sperrvermerkdokumente werden in einem gesonderten Account abgelegt. Alle Dokumente im gesonderten Account werden für andere Nutzer der Organisation <b>nicht freigegeben</b>. Die <b>E-Mail sollte zu keinem anderen PlagScan-Account gehören</b>.';
$string['plagscan_studentpermission'] = 'Studenten k&ouml;nnen den Einsatz von PlagScan verweigern';
$string['plagscan_web_policy'] = "Compare with Web sources";
$string['plagscan_own_workspace_policy'] = "Check againts my documents";
$string['plagscan_own_repository_policy'] = "Check againts my documents in the repository";
$string['plagscan_orga_repository_policy'] = "Check againts my organization repository";
$string['plagscan_ppp_policy'] = "Check againts the Plagiarism Prevention Tool";
$string['plagscanerror'] = 'Fehler von PlagScan Server: {$a}';
$string['plagscanexplain'] = 'PlagScan ist ein Werkzeug zur Plagiatpr&uuml;fung. <br />Es vergleicht Arbeiten innerhalb einer Organisation sowie m&ouml;gliches Kopieren aus dem Internet und Verlagsdatenbanken. <br> F&uuml;r die Nutzung des Plugins ist ein <a href="https://www.plagscan.com" target="_blank">Organisations-Account</a> erforderlich.<br /><br />Eine Erkl&auml;rung zum PlagScan Moodle Plugin finden Sie unter <a href="https://www.plagscan.com/system-integration-moodle" target="_blank">www.plagscan.com/system-integration-moodle</a>.<br>Kontaktieren Sie uns f&uuml;r einen kostenlosen Test <a href="mailto:pro@plagscan.com">pro@plagscan.com</a><br>und verpassen Sie keine Neuigkeiten auf <a href="https://twitter.com/plagscan" target="_blank">Twitter</a><br /><br />Generelle Informationen finden Sie auf unserer Website: <a href="https://www.plagscan.com" target="_blank">www.PlagScan.com</a><hr />';
$string['plagscanmethod']  ='Einreichen';
$string['plagscanserver'] = 'PlagScan API Server';
$string['plagscanserver_help'] = 'Der Standard Server ist "<b>ssl://api.plagscan.com/v3/</b>" oder "<b>https://api.plagscan.com/v3/</b>" bei Verwendung eines Proxies';
$string['plagscanversion']  ='2.3';
$string['pluginname'] = 'PlagScan';
$string['psreport'] = 'PS Bericht';
$string['process_checking'] = "Die Datei wird gerade analysiert...";
$string['process_uploading'] = "Hochladen der Datei in PlagScan...";
$string['red']='PlagLevel rot startet bei';
$string['report'] = 'Bericht';
$string['report_retrieve_error'] = 'Error retrieving the report. Could be the user does not have access to this report';
$string['resubmit'] = 'Nochmal bei PlagScan einreichen';
$string['runalways']= "Starte sofort bei Abgabe";
$string['runautomatic'] = 'Starte sofort nach dem ersten Abgabetermin';
$string['runduedate'] = 'Starte bei allen Abgabeterminen';
$string['runmanual'] = 'Starte manuell';
$string['save']='Speichern';
$string['savedapiconfigerror'] = 'Es gab einen Fehler beim Speichern der PlagScan Einstellungen';
$string['savedconfigsuccess'] = 'PlagScan Einstellungen gespeichert';
$string['savedapiconfigerror_admin_email'] = 'Make sure you entered a valid user email as "Admin Email"';
$string['serverconnectionproblem'] = 'Problem mit der Verbindung zum PlagScan Server';
$string['serverrejected'] = 'Der PlagScan Server hat diese Datei abgelehnt - sie ist besch&auml;digt oder gesch&uuml;tzt.';
$string['settings_cancelled'] = 'Einstellungen nicht gespeichert';
$string['settings_saved'] = 'Einstellungen erfolgreich gespeichert';
$string['settingsfor'] = 'Aktualisiere Einstellungen f&uuml;r PlagScan Konto \'{$a}\'';
$string['settingsreset']='Formular l&ouml;schen';
$string['show_to_students'] = 'Ergebnisse mit Teilnehmern teilen';
$string['show_to_students_actclosed'] = 'Nach Abgabetermin';
$string['show_to_students_always'] = 'Immer';
$string['show_to_students_help'] = 'Teilnehmer k&ouml;nnen nach der PlagScan-Analyse Ihre Ergebnisse sehen.';
$string['show_to_students_never'] = 'Nie';
$string['singleaccount'] = 'Das PlagScan-Admin Konto';

$string['spanish'] = 'Spanisch';
$string['ssty']='Sensitivit&auml;t';
$string['sstyhigh']='hoch';
$string['sstylow']='niedrig';
$string['sstymedium']='mittel';
$string['studentdisclosure'] = 'Studentenmitteilung';
$string['studentdisclosure_help'] = 'Dieser Text wird allen Studenten beim Hochladen Ihrer Datei angezeigt.';
$string['studentdisclosuredefault']  ='Alle hochgeladenen Dokumente, werden bei PlagScan eingereicht';
$string['studentdisclosureoptedout'] = 'Sie haben die Plagiatpr&uuml;fung verweigert';
$string['studentdisclosureoptin'] = 'Klicke hier um die Plagiatpr&uuml;fung zu bewilligen';
$string['studentdisclosureoptout'] = 'Klicke hier um die Plagiatpr&uuml;fung zu verweigern';
$string['submit'] = 'Einreichen bei PlagScan';
$string['submituseroptedout'] = 'Datei \'{$a}\' nicht eingereicht - der Nutzer hat eine Plagiatpr&uuml;fung verweigert';
$string['testconnection']='Teste Verbindung';
$string['testconnection_fail']='Verbindung fehlgeschlagen!';
$string['testconnection_success']='Verbindung war erfolgreich!';
$string['unsupportedfiletype'] = 'Dieses Dateiformat wird nicht von PlagScan unterst&uuml;tzt';
$string['updateyoursettings'] = 'Zu Ihren PlagScan Einstellungen';
$string['useplagscan'] = 'Aktiviere PlagScan';
$string['useplagscan_help'] = 'Verarbeitung <b>kann</b> bei der automatischen Abgabe bis zu <b>15 Minuten</b> dauern (Cronjob-Zyklus)';
$string['useroptedout'] = 'Plagiatpr&uuml;fung verweigert';
$string['viewmatches'] = 'Zeige Liste';
$string['viewreport'] = 'Zeige Textbericht';
$string['wasoptedout'] = 'Nutzer hat eine Plagiatpr&uuml;fung verweigert';
$string['webonly']='Im Web suchen';
$string['week'] = 'nach 1 Woche';
$string['weeks'] = 'nach drei Monaten';
$string['windowsize'] = 'Suchfenstergr&ouml;&szlig;';
$string['windowsize_help'] = 'Fenstergr&ouml;&szlig;e bestimmt wie genau die Textsuche sein wird. Empfohlener Wert 6.';
$string['yellow']='PlagLevel gelb startet bei';
$string['report_type']='Report Art:';
$string['newrp_wait']='Bitte warten, wir generieren den Link';
$string['newrp_redirect']='Sie werden automatisch weitergeleitet';

$string['show_to_students_opt2']="Teile diese Ergebnisse";
$string['show_to_students_opt2_help']="Hier k&ouml;nnen Sie ausw&auml;hlen ";
$string['show_to_students_plvl']="PlagLevel";
$string['show_to_students_links']="PlagLevel und Berichte";
$string['allowgroups']="Kategorien erlauben";
$string['allowgroups_help']="Geben Sie den Namen Ihrer Kategorie ein, f&uuml;r die PlagScan verf&uuml;gbar sein soll (z.B.: Kategorie1, Kategorie2, ... ). Wenn Sie das Feld leer lassen, d&uuml;rfen alle Aufgabenersteller PlagScan nutzen.";
$string['callback_setup']="The callback has been set up";
$string['callback_working']="The callback configuration is accepted";
$string['callback_notchecked']="The callback configuration has not been checked";
$string['callback_check']="Check the callback configuration";
$string['callback_help']="The callback configuration is important for getting the reports results when generated and syncronizing them with the Moodle Database";
$string['cron_reset_link']="CRON ZUR&Uuml;CKSETZEN";
$string['cron_reset']="Der Cron Job wurde zur&uuml;ckgesetzt";
$string['cron_normal']="Die Cron Job Einstellung wurde akzeptiert";
$string['cron_running1']="Der Cron Job l&auml;ft seit";
$string['cron_running2']=" Zum Zur&uuml;cksetzen klicken ";
$string['cron_help']="Wenn Sie den Cron Job zur&uuml;cksetzen kann es vorkommen, dass Dateien doppelt zu PlagScan geschickt werden.";
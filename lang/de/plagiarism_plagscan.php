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
 * @copyright   2019 PlagScan GmbH {@link https://www.plagscan.com/}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
$string['allfileschecked'] = 'Status aller Dokumente auf dem PlagScan-Server gepr&uuml;ft';
$string['always'] = 'immer';
$string['check'] = 'Analysieren';
$string['api_language'] = 'Sprache der Berichte';
$string['api_language_help'] = 'Ihre PlagScan-Berichte mit den Ergebnissen der Plagiatspr&uuml;fung werden in dieser Sprache vom Server heruntergeladen.';
$string['assignments'] = 'Aufgaben';
$string['autodel'] = 'Dokument automatisch speichern';
$string['autodescription'] = 'Dokumente werden zum Abgabetermin automatisch analysiert';
$string['autodescriptionsubmitted'] = 'Die Dokumente wurden automatisch bei PlagScan hochgeladen am {$a} - wechsle zum \'manuellen\' Modus, um einzelne Dokumente erneut einzureichen';
$string['autostart'] = 'Pr&uuml;fung automatisch starten';
$string['badcredentials'] = 'PlagScan hat die Zugangsdaten nicht erkannt. Bitte pr&uuml;fen Sie, ob „Client ID“ und „API Key“ korrekt sind';
$string['checkallstatus'] = 'Aktualisiere den Status aller eingereichten Dokumente';
$string['checkstatus'] = 'Status pr&uuml;fen';
$string['check_automatically_pending_assign_task'] = 'Analysiere noch nicht gepr&uuml;fte Dokumente einer Aufgabe, die automatisch h&auml;tten analysiert werden sollen';
$string['check_deadline_pending_assign_task'] = 'Analysiere noch nicht gepr&uuml;fte Dokumente einer Aufgabe, die am Ende einer Abgabefrist h&auml;tten analysiert werden sollen';
$string['compareinternet'] = 'Datenrichtlinie';
$string['connectionfailed'] = 'Verbindung zum PlagScan-Server ist fehlgeschlagen';
$string['data_policy'] = 'Datenrichtlinie';
$string['datapolicyhelp'] = 'Datenrichtlinie';
$string['datapolicyhelp_help'] = 'Entscheiden Sie, wem Ihre Dokumente zum Vergleich zur Verf&uuml;gung stehen und womit Sie Ihre Dokumente abgleichen m&ouml;chten.';
$string['docxemail'] = '.docx-Bericht generieren and mailen';
$string['docxgenerate'] = '.docx-Bericht nur generieren';
$string['docxnone'] = '.docx-Bericht nicht generieren';
$string['donotgenerate'] = 'nicht erstellen';
$string['downloadreport'] = '.docx-Bericht herunterladen';
$string['email_policy'] = 'E-Mail-Richtlinie';
$string['email_policy_always'] = 'Alle Berichte mailen';
$string['email_policy_ifred'] = 'Nur bei rotem PlagLevel mailen';
$string['email_policy_never'] = 'Keine Berichte mailen';
$string['email_policy_notification_account'] = 'Benachrichtigung f&uuml;r neue Zugangsdaten';
$string['email_policy_notification_account_help'] = 'Bei <b>aktivierter Checkbox</b> wird Ihnen bei der Erstellung eines neuen PlagScan-Accounts <b>das Passwort und der Nutzername per E-Mail zugeschickt</b>.';
$string['english'] = 'Englisch';
$string['error_involving_assistant'] = 'Fehler bei der Einbindung des Assistenten in die Aufgabe';
$string['error_assignment_creation'] = 'Fehler beim Anlegen der Zuordnung';
$string['error_user_creation'] = 'Fehler beim Anlegen des Benutzers';
$string['error_user_does_not_belong_to_the_institution'] = 'Der Nutzer ist in PlagScan einer anderen Organisation zugeordnet';
$string['error_document_does_not_belong_to_the_institution'] = 'Das Dokument ist in PlagScan einer anderen Organisation zugeordnet';
$string['error_submit'] = 'Problem beim Übertragen an PlagScan.';
$string['error_refresh_status'] = 'Problem beim Abruf des Dokumentenstatus von PlagScan';
$string['exclude_from_repository'] = 'Aus dem Archiv ausschlie&szlig;en';
$string['exclude_from_repository_help'] = 'Alle Dokumente, die f&uuml;r diese Einreichung hochgeladen werden, aus dem Archiv ausschlie&szlig;en.';
$string['exclude_self_matches'] = 'Eigenplagiate ignorieren';
$string['exclude_self_matches_help'] = 'Texte desselben Teilnehmers (bei mehreren Einreichungsversuchen) nicht als Plagiat markieren';
$string['filechecked'] = 'Status des Dokuments auf PlagScan-Server gepr&uuml;ft';
$string['filesassociated'] = 'Dokumente werden hochgeladen in das Konto \'{$a}\'';
$string['filesubmitted'] = 'Dokument \'{$a}\' wurde bei PlagScan eingereicht';
$string['filetypeunsupported'] = 'Dokument \'{$a}\' hat einen Dateityp, der nicht von PlagScan unterst&uuml;tzt wird';
$string['french'] = 'Franz&ouml;sisch';
$string['generaldatabase'] = 'Abgleich mit allgemeiner Datenbank';
$string['generateemail'] = 'Generieren und Mailen';
$string['generateonly'] = 'Nur Generieren';
$string['german'] = 'Deutsch';
$string['handledocx'] = '.docx-Option';
$string['if_plagiarism_level'] = 'bei rotem PlagLevel';
$string['individualaccounts'] = 'Individuelle Lehrerkonten';
$string['invalidupload'] = 'Der PlagScan-Server hat die Datei {$a->filename} nicht akzeptiert. Die Antwort war: {$a->content}';
$string['max_file_size'] = 'Maximale Dateigr&ouml;&szlig;e';
$string['maxfilesize'] = 'Maximale Dateigr&ouml;&szlig;e';
$string['maxfilesize_help'] = 'Gr&ouml;&szlig;ere Dateien werden nicht transferiert. Empfohlener Wert ist 1000000.';
$string['months'] = 'nach sechs Monaten';
$string['myinstitution'] = 'Abgleich mit Organisationsdatenbank';
$string['never'] = 'nie';
$string['neverdelete'] = 'nie l&ouml;schen';
$string['newexplain'] = 'F&uuml;r weitergehende Informationen zum Plugin siehe: ';
$string['nodeadlinewarning'] = 'Warnung: Automatisches Einreichen f&uuml;r PlagScan ist ausgew&auml;hlt, aber es wurde keine Abgabefrist gesetzt';
$string['nomultipleaccounts'] = 'Das Nutzen individueller Nutzerkonten ist auf dem Server nicht aktiviert.';
$string['nondisclosure_notice_desc'] = 'Sperrvermerkdokumente werden im Account "{$a}" abgelegt.<br /><br />';
$string['noone'] = 'Abgleich mit Webquellen';
$string['noonedocs'] = 'Abgleich mit Webquellen und meinen Dokumenten';
$string['notprocessed'] = 'PlagScan hat diese Datei noch nicht analysiert';
$string['notsubmitted'] = 'Nicht bei PlagScan eingereicht';
$string['online_submission'] = 'Aktiviere PlagScan f&uuml;r die online Texteingabe';
$string['online_submission_help'] = 'Aktiviert das Texteingabefeld mit Editor f&uuml;r PlagScan-Einreichungen.';
$string['online_text_yes'] = 'Ja';
$string['online_text_no'] = 'Nein';
$string['onlyassignmentwarning'] = 'Warnung: Automatisches Einreichen funktioniert nur mit der Aktivit&auml;t „Aufgabe“';
$string['optin'] = 'Plagiatspr&uuml;fung zulassen';
$string['optin_explanation'] = 'Sie haben sich entschieden, die Plagiatspr&uuml;fung zuzulassen. Von nun an werden alle Ihre Arbeiten auf den PlagScan-Server hochgeladen und gepr&uuml;ft';
$string['optout'] = 'Plagiatspr&uuml;fung verweigern';
$string['optout_explanation'] = 'Sie haben sich entschieden, die Plagiatspr&uuml;fung zu verweigern. Von nun an werden keine Arbeiten mehr auf den PlagScan-Server hochgeladen und gepr&uuml;ft';
$string['plagscan'] = 'PlagScan';
$string['plagscan:control'] = 'Einreichung an PlagScan &uuml;bermitteln';
$string['plagscan:enable'] = 'PlagScan in einer Aufgabe aktivieren/deaktivieren';
$string['plagscan:viewfullreport'] = 'PlagScan-Berichte ansehen/herunterladen';
$string['pluginname'] = 'PlagScan';
$string['plagscan_admin_email'] = 'Admin-E-Mail';
$string['plagscan_admin_email_help'] = 'Die E-Mail-Adresse Ihres PlagScan-Administratoren-Kontos. Diese ist n&ouml;tig, wenn Sie hochgeladene Dokumente zentral in Ihrem PlagScan-Admin-Konto ablegen m&ouml;chten.';
$string['plagscan_API_key'] = 'API Key';
$string['plagscan_API_key_help'] = 'Ihren API Key finden Sie auf der Seite <a href="https://www.plagscan.com/apisetup" target="_blank">https://www.plagscan.com/apisetup</a>';
$string['plagscan_API_method'] = 'Methode';
$string['plagscan_API_username'] = 'API-Nutzername';
$string['plagscan_API_version'] = 'API-Version';
$string['plagscan_API_version_help'] = 'Die aktuelle API-Version ist <b>2.1</b>';
$string['plagscan_call_back_script'] = 'Call-back Script URL';
$string['plagscan_multipleaccounts'] = 'Verkn&uuml;pfe hochgeladene Dateien mit';
$string['plagscan_nondisclosure_notice_email'] = 'Sperrvermerkdokumente';
$string['plagscan_nondisclosure_notice_email_desc'] = 'name@example.com';
$string['plagscan_nondisclosure_notice_email_help'] = 'Sperrvermerkdokumente werden in einem gesonderten Account abgelegt. Alle Dokumente im gesonderten Account werden f&uuml;r andere Nutzer der Organisation <b>nicht freigegeben</b>. Die <b>E-Mail sollte zu keinem anderen PlagScan-Account geh&ouml;ren</b>.';
$string['plagscan_studentpermission'] = 'Studierende k&ouml;nnen den Einsatz von PlagScan verweigern';
$string['plagscan_web_policy'] = "Mit Webquellen abgleichen";
$string['plagscan_own_workspace_policy'] = "Mit eigenen Dokumenten abgleichen";
$string['plagscan_own_repository_policy'] = "Mit meinen Dokumenten aus dem Organisationsarchiv abgleichen";
$string['plagscan_orga_repository_policy'] = "Mit dem gesamten Organisationsarchiv abgleichen";
$string['plagscan_ppp_policy'] = "Mit dem Plagiat-Pr&auml;ventions-Pool abgleichen";
$string['plagscanerror'] = 'Fehler von PlagScan-Server: {$a}';
$string['plagscanexplain'] = 'PlagScan ist ein Werkzeug zur Plagiatspr&uuml;fung. <br />Es vergleicht Arbeiten mit Dokumenten innerhalb einer Organisation, mit Internetquellen und Verlagsdatenbanken. <br />F&uuml;r die Nutzung des Plugins ist ein <a href="https://www.plagscan.com" target="_blank">Organisations-Account</a> erforderlich.<br /><br />Ein Handbuch zum PlagScan-Moodle-Plugin finden Sie unter <a href="https://www.plagscan.com/de/plagscan-integration-moodle" target="_blank">https://www.plagscan.com/de/plagscan-integration-moodle</a>.<br>Kontaktieren Sie uns f&uuml;r einen kostenlosen Test <a href="mailto:pro@plagscan.com">pro@plagscan.com</a><br>und verpassen Sie keine Neuigkeiten auf <a href="https://twitter.com/plagscan" target="_blank">Twitter</a><br /><br />Generelle Informationen finden Sie auf unserer Website: <a href="https://www.plagscan.com" target="_blank">www.PlagScan.com</a><hr />';
$string['plagscanmethod'] = 'Einreichen';
$string['plagscanserver'] = 'PlagScan-API-Server';
$string['plagscanserver_help'] = 'Der Standard-Server ist „<b>ssl://api.plagscan.com/v3/</b>“ oder „<b>https://api.plagscan.com/v3/</b>“ bei Verwendung eines Proxies';
$string['plagscanversion'] = '2.3';
$string['pluginname'] = 'PlagScan';
$string['psreport'] = 'PS-Bericht';
$string['process_checking'] = "Die Datei wird gerade analysiert ...";
$string['process_uploading'] = "Hochladen der Datei in PlagScan ...";
$string['red'] = 'PlagLevel rot startet bei';
$string['report'] = 'Bericht';
$string['report_retrieve_error'] = 'Fehler beim Abrufen des Berichts. Es kann sein, dass der Nutzer keinen Zugriff auf diesen Bericht hat';
$string['report_check_error_cred'] = 'Eine &Uuml;berpr&uuml;fung des Dokuments ist derzeit aufgrund unzureichenden PlagPoint-Guthabens nicht m&ouml;glich.';
$string['resubmit'] = 'Nochmal bei PlagScan einreichen';
$string['runalways'] = "Analyse sofort bei Abgabe starten";
$string['runautomatic'] = 'Analyse sofort nach dem ersten Abgabetermin starten';
$string['runduedate'] = 'Analyse bei allen Abgabeterminen starten';
$string['runmanual'] = 'Analyse manuell starten (bei PlagScan einreichen wenn Studenten einen Entwurf speichern)';
$string['runsubmitmanual'] = 'Datei manuell einreichen';
$string['runsubmitonclosedsubmission'] = 'Analyse manuell starten (bei PlagScan einreichen wenn Studenten auf abgeben klicken)';
$string['save'] = 'Speichern';
$string['savedapiconfigerror'] = 'Es gab einen Fehler beim Speichern der PlagScan-Einstellungen';
$string['savedconfigsuccess'] = 'PlagScan-Einstellungen gespeichert';
$string['savedapiconfigerror_admin_email'] = 'Bitte stellen Sie sicher, dass Sie eine g&uuml;ltige E-Mail-Adresse als „Admin-E-Mail“ angegeben haben';
$string['serverconnectionproblem'] = 'Problem mit der Verbindung zum PlagScan-Server';
$string['serverrejected'] = 'Der PlagScan-Server hat diese Datei abgelehnt – sie ist besch&auml;digt, gesch&uuml;tzt oder enth&auml;lt zu wenige Zeichen (mindestens 50 Zeichen verwenden).';
$string['settings_cancelled'] = 'Einstellungen nicht gespeichert';
$string['settings_saved'] = 'Einstellungen erfolgreich gespeichert';
$string['settingsfor'] = 'Aktualisiere Einstellungen f&uuml;r PlagScan-Konto \'{$a}\'';
$string['settingsreset'] = 'Formular l&ouml;schen';
$string['show_to_students'] = 'Ergebnisse mit Teilnehmern teilen';
$string['show_to_students_actclosed'] = 'Nach Abgabetermin';
$string['show_to_students_always'] = 'Immer';
$string['show_to_students_help'] = 'Teilnehmer k&ouml;nnen nach der PlagScan-Analyse Ihre Ergebnisse sehen. ';
$string['show_to_students_never'] = 'Nie';
$string['singleaccount'] = 'Das PlagScan-Admin-Konto';

$string['spanish'] = 'Spanisch';
$string['ssty'] = 'Sensitivit&auml;t';
$string['sstyhigh'] = 'hoch';
$string['sstylow'] = 'niedrig';
$string['sstymedium'] = 'mittel';
$string['studentdisclosure'] = 'Studierendenmitteilung';
$string['studentdisclosure_help'] = 'Dieser Text wird allen Studierenden beim Hochladen Ihrer Datei angezeigt.';
$string['studentdisclosuredefault'] = 'Alle hochgeladenen Dokumente werden bei PlagScan eingereicht';
$string['studentdisclosureoptedout'] = 'Sie haben die Plagiatspr&uuml;fung verweigert';
$string['studentdisclosureoptin'] = 'Klicke hier, um die Plagiatspr&uuml;fung zu bewilligen';
$string['studentdisclosureoptout'] = 'Klicke hier, um die Plagiatspr&uuml;fung zu verweigern';
$string['submit'] = 'Einreichen bei PlagScan';
$string['submituseroptedout'] = 'Datei \'{$a}\' nicht eingereicht – der Nutzer hat eine Plagiatspr&uuml;fung verweigert';
$string['submit_rejected_files_task'] = 'Dateien erneut einreichen';
$string['testconnection'] = 'Teste Verbindung';
$string['testconnection_fail'] = 'Verbindung fehlgeschlagen!';
$string['testconnection_success'] = 'Verbindung war erfolgreich!';
$string['unsupportedfiletype'] = 'Dieses Dateiformat wird nicht von PlagScan unterst&uuml;tzt';
$string['updateyoursettings'] = 'Zu Ihren PlagScan-Einstellungen';
$string['update_frozen_checking_files_task'] = "Datei-Status aktualisieren";
$string['useplagscan'] = 'Aktiviere PlagScan';
$string['useplagscan_filessubmission'] = "Aktiviere PlagScan f&uuml;r Einreichung von Dateien";
$string['useplagscan_filessubmission_help'] = '<ul><li><b>Datei manuell einreichen</b>: Sie k&ouml;nnen die Datei jederzeit manuell an Plagscan senden, indem Sie auf den Button „Einreichen bei PlagScan“ klicken. </li>'
        . '<li><b>Analyse manuell starten (bei PlagScan einreichen wenn Studenten einen Entwurf speichern)</b>: Sie m&uuml;ssen jedes Dokument einzeln f&uuml;r die Pr&uuml;fung ausw&auml;hlen. Bei PlagScan einreichen wenn Studenten eine Entwurf speichern.</li>'
        . '<li><b>Analyse manuell starten (bei PlagScan einreichen wenn Studenten auf abgeben klicken)</b>: Sie m&uuml;ssen jedes Dokument einzeln f&uuml;r die Pr&uuml;fung ausw&auml;hlen. Bei PlagScan einreichen wenn Studenten auf abgeben klicken.'
        . ' Diese Option ist g&uuml;ltig, wenn die Option "Abgabetaste muss gedr&uuml;ckt werden" aktiviert ist.</li>'
        . '<li><b>Analyse sofort bei Abgabe starten</b>: PlagScan analysiert das Dokument automatisch und sofort nach dem Hochladen. </li>'
        . '<li><b>Analyse sofort nach dem ersten Abgabetermin starten</b>: PlagScan startet nachdem die letzte Abgabem&ouml;glichkeit abgelaufen ist. </li>'
        . '<li><b>Analyse bei allen Abgabeterminen starten: </b>Analyse startet sofort, nachdem alle Abgabem&ouml;glichkeiten abgelaufen sind.</li></ul>';
$string['useroptedout'] = 'Plagiatspr&uuml;fung verweigert';
$string['viewmatches'] = 'Zeige Liste';
$string['viewreport'] = 'Zeige Textbericht';
$string['wasoptedout'] = 'Nutzer hat eine Plagiatspr&uuml;fung verweigert';
$string['webonly'] = 'Im Web suchen';
$string['week'] = 'nach 1 Woche';
$string['weeks'] = 'nach 3 Monaten';
$string['windowsize'] = 'Fenstergr&ouml;&szlig;e'; // DELETE
$string['windowsize_help'] = 'Fenstergr&ouml;&szlig;e bestimmt wie genau die Textsuche sein wird. Empfohlener Wert 6.'; // DELETE
$string['yellow'] = 'PlagLevel gelb startet bei';
$string['report_type'] = 'Art des Berichts:';
$string['newrp_wait'] = 'Bitte warten, wir generieren den Link';
$string['newrp_redirect'] = 'Sie werden automatisch weitergeleitet';

$string['show_to_students_opt2'] = "Ergebnisse teilen";
$string['show_to_students_opt2_help'] = "Hier k&ouml;nnen Sie ausw&auml;hlen, welche Ergbenisse mit den Studierenden geteilt werden.";
$string['show_to_students_plvl'] = "PlagLevel";
$string['show_to_students_links'] = "PlagLevel und Berichte";
$string['allowgroups'] = "Kategorien erlauben";
$string['allowgroups_help'] = "Geben Sie den Namen Ihrer Kategorie ein, f&uuml;r die PlagScan verf&uuml;gbar sein soll (z. B.: Kategorie1, Kategorie2, ... ). Wenn Sie das Feld leer lassen, d&uuml;rfen alle Aufgabenersteller PlagScan nutzen.";
$string['callback_setup'] = "Der Call-back wurde eingerichtet";
$string['callback_working'] = "Die Call-back-Konfiguration war erfolgreich";
$string['callback_notchecked'] = "Die Call-back-Konfiguration wurde noch nicht &uuml;berpr&uuml;ft";
$string['callback_check'] = "Call-back-Konfiguration &uuml;berpr&uuml;fen";
$string['callback_help'] = "Die Call-back-Konfiguration ist entscheidend, um Zugriff auf die Plagiatsberichte zu erhalten, sobald diese generiert und mit der Moodle-Datenbank synchronisiert wurden.";
$string['cron_reset_link'] = "CRON ZUR&Uuml;CKSETZEN";
$string['cron_reset'] = "Der Cron-Job wurde zur&uuml;ckgesetzt";
$string['cron_normal'] = "Die Cron-Job-Einstellung wurde akzeptiert";
$string['cron_running1'] = "Der Cron-Job l&auml;ft seit";
$string['cron_running2'] = " Zum Zur&uuml;cksetzen klicken ";
$string['cron_help'] = "Wenn Sie den Cron-Job zur&uuml;cksetzen, kann es vorkommen, dass Dateien doppelt zu PlagScan geschickt werden.";
$string['wipe_plagscan_user_cache_link'] = 'PlagScan-Nutzer-Cache leeren';
$string['wipe_plagscan_user_cache_done'] = 'PlagScan-Nutzer-Cache geleert';
$string['wipe_plagscan_user_cache_error'] = 'Fehler beim Leeren des PlagScan-Nutzer-Cache';
$string['wipe_plagscan_user_cache_help'] = 'Beim Klicken auf diesen Link wird der Cache des PlagScan-Plugin-Nutzers geleert.';
$string['wipe_plagscan_user_cache_alert'] = 'Diese Funktion sollte nur genutzt werden, wenn Sie Probleme bei der Benutzung des PlagScan-Plugins haben. Dies kann notwendig sein, um eventuell auftretende Fehler zu beheben.';
$string['plagscan_user_id'] = 'PlagScan-Nutzer-ID';
$string['plagscan_assingment_id'] = 'PlagScan-Einreichungs-ID';
$string['error_assignment_or_owner_does_not_exist_or_belong'] = 'M&ouml;glicherweise existiert die Aufgabe oder ihr Besitzer (der Nutzer, der PlagScan f&uuml;r diese Aufgabe aktiviert hat) nicht mehr in PlagScan, oder sie geh&ouml;ren zu einer anderen Institution';
$string['plagscan_assignment_defaults_header'] = 'PlagScan-Standardeinstellungen f&uuml;r Aufgaben';
$string['plagscan_assignment_defaults_explain'] = 'Diese Einstellungen werden als Standardeinstellungen f&uuml;r neu erstellte Aufgaben verwendet. Nutzer k&ouml;nnen bei der Erstellung von Aufgaben diese Einstellungen ihren W&uuml;nschen entsprechend anpassen.';

$string['privacy:metadata:core_plagiarism'] = 'Plugin wird vom Moodle-Plagiats-System verwendet.';
$string['privacy:metadata:core_files'] = 'Dateien und Online-Texte, die mit dem PlagScan-Plugin &uuml;bermittelt wurden.';

$string['privacy:metadata:plagiarism_plagscan'] = 'Speichert Daten von PlagScan-Dateien.';
$string['privacy:metadata:plagiarism_plagscan:id'] = 'Die ID f&uuml;r jeden Eintrag in der plagiarism_plagscan-Tabelle.';
$string['privacy:metadata:plagiarism_plagscan:userid'] = 'Die ID der/des Studierenden.';
$string['privacy:metadata:plagiarism_plagscan:pid'] = 'Die ID der Datei im PlagScan-System.';
$string['privacy:metadata:plagiarism_plagscan:pstatus'] = 'Der pontielle, prozentuale Plagiatsanteil in der Datei, nachdem sie gepr&uuml;ft wurde.';
$string['privacy:metadata:plagiarism_plagscan:status'] = 'Der Status der Datei im PlagScan-System.';
$string['privacy:metadata:plagiarism_plagscan:cmid'] = 'Die ID des Kontexts, in dem die Datei &uuml;bermittelt wurde.';
$string['privacy:metadata:plagiarism_plagscan:filehash'] = 'Der Hash der Datei.';
$string['privacy:metadata:plagiarism_plagscan:updatestatus'] = 'Zeigt an, ob die Datei aktualisiert werden muss.';
$string['privacy:metadata:plagiarism_plagscan:submissiontype'] = 'Zeigt an, welche Art der Einreichung get&auml;tigt wurde.';

$string['privacy:metadata:plagiarism_plagscan_config'] = 'Speichert Daten von PlagScan-Aufgaben.';
$string['privacy:metadata:plagiarism_plagscan_config:id'] = 'Die ID f&uuml;r jeden Eintrag in der plagiarism_plagscan_config-Tabelle.';
$string['privacy:metadata:plagiarism_plagscan_config:cm'] = 'Die ID des Kontexts, in dem die Aufgabe erstellt wurde.';
$string['privacy:metadata:plagiarism_plagscan_config:upload'] = 'Zeigt an, welcher Upload-Prozess f&uuml;r die Dateien verwendet wird.';
$string['privacy:metadata:plagiarism_plagscan_config:complete'] = 'Identifiziert, ob eine Aufgabe abgeschlossen ist.';
$string['privacy:metadata:plagiarism_plagscan_config:username'] = 'Benutzername des Lehrenden, der die Aufgabe erstellt hat..';
$string['privacy:metadata:plagiarism_plagscan_config:nondisclosure'] = 'Zeigt an, ob ein Sperrvermerk angezeigt wird.';
$string['privacy:metadata:plagiarism_plagscan_config:show_report_to_students'] = 'Zeigt an, ob Studierende Zugriff auf den Plagiatsbericht haben.';
$string['privacy:metadata:plagiarism_plagscan_config:show_students_links'] = 'Zeigt an, ob Studierende Zugriff auf den Bericht-Link haben.';
$string['privacy:metadata:plagiarism_plagscan_config:ownerid'] = 'Die ID des Lehrenden, der die Aufgabe erstellt hat.';
$string['privacy:metadata:plagiarism_plagscan_config:submissionid'] = 'Die ID der Aufgabe im PlagScan-System.';
$string['privacy:metadata:plagiarism_plagscan_config:enable_online_text'] = 'Zeigt an, ob die Einreichung von Online-Texten aktiviert ist.';
$string['privacy:metadata:plagiarism_plagscan_config:exclude_self_matches'] = 'Zeigt an, ob Einreichungen desselben Nutzers &uuml;ber mehrere Einreichungsversuche hinweg markiert werden.';
$string['privacy:metadata:plagiarism_plagscan_config:exclude_from_repository'] = 'Zeigt an, ob Einreichungen vom Archiv ausgeschlossen werden.';


$string['privacy:metadata:plagiarism_plagscan_user'] = 'Speichert PlagScan-Nutzerdaten.';
$string['privacy:metadata:plagiarism_plagscan_user:id'] = 'Die ID f&uuml;r jeden Eintrag in der plagiarism_plagscan_user-Tabelle.';
$string['privacy:metadata:plagiarism_plagscan_user:userid'] = 'Die ID des Benutzers in Moodle.';
$string['privacy:metadata:plagiarism_plagscan_user:psuserid'] = 'Die ID des Benuzters im PlagScan-System.';


$string['privacy:metadata:plagiarism_external_plagscan_api'] = 'Die PlagScan-API wird von diesem Plugin verwendet, um den Datenaustausch zwischen Moodle und PlagScan zu erm&ouml;glichen.';
$string['privacy:metadata:plagiarism_external_plagscan_api:useremail'] = 'Die E-Mail-Adresse des Benutzers.';
$string['privacy:metadata:plagiarism_external_plagscan_api:userfirstname'] = 'Der Vorname des Benutzers.';
$string['privacy:metadata:plagiarism_external_plagscan_api:userlastname'] = 'Der Nachname des Benutzers.';
$string['privacy:metadata:plagiarism_external_plagscan_api:fileformat'] = 'Das Format der Datei.';
$string['privacy:metadata:plagiarism_external_plagscan_api:filedata'] = 'Die Daten der Datei.';
$string['privacy:metadata:plagiarism_external_plagscan_api:filename'] = 'Der Name der Datei.';

$string['privacy:export:plagiarism_plagscan:filerecordcontentdescription'] = 'Das Ergebnis des PlagScan-Berichts f&uuml;r &uuml;berpr&uuml;fte Dateien.';


$string['event_file_upload_completed'] = 'Der Datei-Upload an PlagScan war erfolgreich.';
$string['event_file_upload_started'] = 'Der Datei-Upload an PlagScan wurde gestartet.';
$string['event_file_upload_failed'] = 'Der Datei-Upload an PlagScan ist fehlgeschlagen.';
$string['event_user_creation_completed'] = 'Benutzer-Erstellung bei PlagScan wurde abgeschlossen.';
$string['event_user_creation_started'] = 'Benutzer-Erstellung bei PlagScan wurde gestartet.';
$string['event_user_search_started'] = 'Benutzer-Suche bei PlagScan wurde gestartet.';
$string['event_user_search_completed'] = 'Benutzer-Suche bei PlagScan wurde abgeschlossen.';
$string['event_assign_creation_completed'] = 'Aufgaben-Erstellung bei PlagScan wurde abgeschlossen.';
$string['event_assign_creation_started'] = 'Aufgaben-Erstellung bei PlagScan wurde gestartet.';
$string['event_assign_update_completed'] = 'Aufgaben-Aktualisierung bei PlagScan wurde abgeschlossen.';
$string['event_callback_received'] = 'Call-back von PlagScan erhalten.';
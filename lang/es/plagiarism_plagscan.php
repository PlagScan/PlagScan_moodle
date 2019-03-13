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

$string['allfileschecked'] = 'Estado de todos los documentos analizados en PlagScan';
$string['always'] = 'Siempre';
$string['check'] = 'Analizar';
$string['api_language']='Idioma del informe';
$string['api_language_help']= 'Todos los informes de PlagScan seran en este idioma.';
$string['assignments']='Entregas';
$string['autodel']='Auto borrado de documento';
$string['autodescription'] = 'Los documentos ser&aacute;n analizados cuando se alcance la fecha l&iacute;mite';
$string['autodescriptionsubmitted'] = 'Los documentos ser&aacute;n enviados a PlagScan automaticamente el {$a} - cambia a \'manual\' para reenviar entregas individuales';
$string['autostart'] = 'Inicio autom&aacute;tico de an&aacute;lisis';
$string['badcredentials'] = 'PlagScan no reconoce los detalles de la cuenta - por favor, confirme que la "Client ID" y "API Key" son correctos';
$string['checkallstatus'] = 'Actualice el estado de todos los documentos enviados';
$string['checkstatus'] = 'Comprobar estado';
$string['compareinternet'] = 'Directiva de datos';
$string['connectionfailed'] = 'Fallo al conectar al servidor de PlagScan';
$string['data_policy']='Directiva de datos';
$string['datapolicyhelp']='Compartir mis documentos para analizarlos con (comparar con otros)';
$string['datapolicyhelp_help']='Compartir mis documentos para analizarlos con (comparar con otros)';
$string['docxemail'] = 'Generar y enviar informes .docx';
$string['docxgenerate'] = 'Solo generar informes .docx';
$string['docxnone'] = 'No generar informes .docx';
$string['donotgenerate'] = 'No generar';
$string['downloadreport'] = 'Descargar informe .docx';
$string['email_policy'] = 'Directiva de email';
$string['email_policy_always'] = 'Enviar los Informes';
$string['email_policy_ifred'] = 'Enviar solo con PlagLevel rojo';
$string['email_policy_never'] = 'No enviar informes';
$string['email_policy_notification_account'] = 'Notificaci&oacute;n para nueva credenciales';
$string['email_policy_notification_account_help'] = '<b>Activando esta casilla</b>, todas las <b>credenciales de cuentas</b> ser&aacute;n inmediatamente enviadas a ti.';
$string['english'] = 'Ingles';
$string['error_involving_assistant'] = "Error involucrar al asistente en la tarea";
$string['filechecked'] = 'Estado del documento analizado en PlagScan';
$string['filesassociated'] = 'Los documentos ser&aacute;n enviados a la cuenta de \'{$a}\'';
$string['filesubmitted'] = 'Documento: \'{$a}\' enviado a PlagScan';
$string['filetypeunsupported'] = 'Documento: \'{$a}\' no es un archivo soportado por PlagScan';
$string['french'] = 'Frances';
$string['generaldatabase']='Comparar con la base de datos general';
$string['generateemail'] = 'Generar y enviar';
$string['generateonly'] = 'Solo generar';
$string['german'] = 'Aleman';
$string['handledocx'] = 'Opcion Docx';
$string['if_plagiarism_level'] = 'Solo PlagLevel rojo';
$string['individualaccounts'] = 'Cuentas de profesores individuales';
$string['invalidupload'] = 'El servidor de PlagScan no acepto el archivo {$a->filename}. El servidor devolvio: {$a->content}';
$string['max_file_size'] = 'Tama&ntilde;o m&aacute;ximo del documento';
$string['maxfilesize'] = 'Tama&ntilde;o m&aacute;ximo del documento';
$string['maxfilesize_help'] = 'Documentos mas grandes que este valor no ser&aacute;n descargados de Internet. Valor recomendado 1000000.';
$string['months'] = 'Despues de 6 meses';
$string['myinstitution']='Comparar con la base de datos de la organizaci&oacute;n';
$string['never'] = 'nunca';
$string['neverdelete'] = 'no borrar nunca';
$string['newexplain'] = 'Para mas informacion sobre este plugin: ';
$string['nodeadlinewarning'] = 'Atenci&oacute;n: Se estableci&oacute; la entrega autom&aacute;tica pero no se estableci&oacute; una fecha limite';
$string['nomultipleaccounts'] = 'La opci&oacute;n de cuentas individuales para profesores para PlagScan en esta activada';
$string['nondisclosure_notice_desc'] = 'Todos los documentos confidenciales seran enviados a "{$a}".<br /><br />';
$string['noone']='Comparar solo con Internet';
$string['noonedocs']='Comparar en Internet y mis documentos';
$string['notprocessed'] = 'PlagScan no ha analizado este documento todav&iacute;a';
$string['notsubmitted'] = 'No se ha enviado a PlagScan';
$string['onlyassignmentwarning'] = 'Atenci&oacute;n: Entregas autom&aacute;ticas a PlagScan solo funciona con actividades de entregas';
$string['optin'] = 'Plagio por defecto';
$string['optin_explanation'] = 'Usted ha elegido detectar el plagio. Desde ahora, cualquier entrega enviara los documentos al servidor PlagScan para analizarlo';
$string['optout'] = 'Plagio desactivado';
$string['optout_explanation'] = 'Usted ha elegido desactivar el plagio. Desde ahora, ninguna entrega enviara los documentos al servidor PlagScan para analizarlo';
$string['plagscan']  ='PlagScan';
$string['plagscan:control'] = 'Enviar/Reenviar entregas PlagScan';
$string['plagscan:enable'] = 'Activar/Desactivar PlagScan en una actividad';
$string['plagscan:viewfullreport'] = 'Ver/Descargar reportes de PlagScan';
$string['pluginname'] = 'PlagScan';
$string['plagscan_admin_email']='Admin Email';
$string['plagscan_admin_email_help']='Email de la cuenta de administrador de PlagScan. Esto es necesario si quiere asociar los archivos subidos con su cuenta principal de PlagScan.';
$string['plagscan_API_key'] = 'Clave API';
$string['plagscan_API_key_help'] = 'Puede obtener su clave de API en <a href="https://www.plagscan.com/apisetup" target="_blank">https://www.plagscan.com/apisetup</a>';
$string['plagscan_API_method'] = 'm&eacute;todo';
$string['plagscan_API_username']='API Usuario';
$string['plagscan_API_version'] = 'API versi&oacute;n';
$string['plagscan_API_version_help'] = 'Tu versi&oacute;n de la API es <b>2.1</b>';
$string['plagscan_call_back_script'] = 'Call-back URL';
$string['plagscan_multipleaccounts'] = 'Asociar documentos enviados a';
$string['plagscan_nondisclosure_notice_email'] = 'Documentos confidenciales';
$string['plagscan_nondisclosure_notice_email_desc'] = 'nombre@ejemplo.com';
$string['plagscan_nondisclosure_notice_email_help'] = 'Todos los documentos con el bloqueo de notificaci&oacute;n ser&aacute;n entregados a una cuenta separada PlagScan. Todos los documentos que se encuentran en la cuenta <b>no se compartiran</b> con otros usuarios de la organizaci&oacute;. El <b>correo no puede ser parte de otra cuenta de PlagScan</b>.';
$string['plagscan_studentpermission'] = 'Los estudiantes pueden elegir no enviar documentos a PlagScan';
$string['plagscan_web_policy'] = "Comparar con fuentes de internet";
$string['plagscan_own_workspace_policy'] = "Comparar con documentos propios";
$string['plagscan_own_repository_policy'] = "Comparar con mis documentos en el repositorio de la organización";
$string['plagscan_orga_repository_policy'] = "Comparar con el repositorio de la organización";
$string['plagscan_ppp_policy'] = "Comparar con la Biblioteca Anti-plagio de PlagScan";
$string['plagscanerror'] = 'Error desde el servidor de PlagScan: {$a}';
$string['plagscanexplain'] = 'PlagScan es el detector de plagio: los documentos de su organizaci&oacute;n y el texto de Internet sera considerado para analizar.<br/><br/>Para registrarse en PlagScan puede hacerlo <a href="https://www.plagscan.com/">aqu&iacute;</a> y preg&uacute;ntenos por la prueba gratuita <a href="mailto:pro@plagscan.com">pro@plagscan.com</a><br><br>Informacion general puede ser encontrada en <a href="http://www.plagscan.com">www.PlagScan.com</a>';
$string['plagscanmethod']  ='enviar';
$string['plagscanserver'] = 'Servidor PlagScan';
$string['plagscanserver_help'] = 'La configuraci&oacute;n est&aacute;ndar es "<b>ssl://api.plagscan.com/v3/</b>" o "<b>https://api.plagscan.com/v3/</b>" si usas un proxy.';
$string['plagscanversion']  ='2.3';
$string['psreport'] = 'Informe PS';
$string['process_checking'] = "El archivo está siendo analizado...";
$string['process_uploading'] = "Cargando archivo en PlagScan...";
$string['red']='El PlagLevel rojo comienza en';
$string['report'] = 'Informe';
$string['report_retrieve_error'] = 'Error retrieving the report. Could be the user does not have access to this report';
$string['resubmit'] = 'Reenviar a PlagScan';
$string['runalways']= "Inmediatamente";
$string['runautomatic'] = 'Inmediatamente despu&eacute;s de la fecha de entrega';
$string['runduedate'] = 'Inmediatamente despu&eacute;s de la fecha limite';
$string['runmanual'] = 'Manualmente';
$string['save']='Guardar';
$string['savedapiconfigerror'] = 'Hubo un error mientras se actualiza la configuraci&oacute;n de PlagScan';
$string['savedconfigsuccess'] = 'Configuraci&oacute;n de PlagScan guardada!';
$string['savedapiconfigerror_admin_email'] = 'Make sure you entered a valid user email as "Admin Email"';
$string['serverconnectionproblem'] = 'Problema al conectar a PlagScan';
$string['serverrejected'] = 'El servidor de PlagScan rechaz&oacute; el archivo - Est&aacute; protegido, corrupto o puede que contenta poco texto (min. 50 caracteres)';
$string['settings_cancelled'] = 'Configuraci&oacute;n antiplagio ha sido cancelada';
$string['settings_saved'] = 'Configuraci&oacute;n antiplagio guardada correctamente';
$string['settingsfor'] = 'Actualizar configuraci&oacute;n de PlagScan para \'{$a}\'';
$string['settingsreset']='Formular l&ouml;schen';
$string['show_to_students'] = 'Compartir informes con los estudiantes';
$string['show_to_students_actclosed'] = 'Despu&eacute;s de la fecha de entrega';
$string['show_to_students_always'] = 'Siempre';
$string['show_to_students_help'] = 'Todos los estudiantes pueden ver el resultado de los an&aacute;lisis.';
$string['show_to_students_never'] = 'Nunca';
$string['singleaccount'] = 'La cuenta de administrado de PlagScan';
$string['spanish'] = 'Espa&ntilde;ol';
$string['ssty']='Sensitivity';
$string['sstyhigh']='High';
$string['sstylow']='Low';
$string['sstymedium']='Medium';
$string['studentdisclosure'] = 'Divulgaci&oacute;n de Estudiantes';
$string['studentdisclosure_help'] = 'Este texto ser&aacute;n mostrado a todos los estudiantes en la pagina de subida de documentos.';
$string['studentdisclosuredefault']  ='Todos los documentos ser&aacute;n enviados a PlagScan para detectar posible plagio';
$string['studentdisclosureoptedout'] = 'Usted tiene desactivado por defecto la detecci&oacute;n de plagio';
$string['studentdisclosureoptin'] = 'Haga clic aqu&iacute; para activar la detecci&oacute;n de plagio';
$string['studentdisclosureoptout'] = 'Haga clic aqu&iacute; para desactivar la detecci&oacute;n de plagio';
$string['submit'] = 'Enviar a PlagScan';
$string['submituseroptedout'] = 'Documento \'{$a}\' no enviado - El usuario ha desactivado la detecci&oacute;n de plagio';
$string['testconnection']='Test Connection';
$string['testconnection_fail']='Fallo al conectar';
$string['testconnection_success']='La conexi&oacute;n fue un exito';
$string['unsupportedfiletype'] = 'Este archivo no es soportado por PlagScan';
$string['updateyoursettings'] = 'Actualice su configuraci&oacute;n de PlagScan';
$string['useplagscan'] = 'Activar PlagScan';$string['useplagscan_help'] = '* <b>Start manually</b>: you will have to check each document manually.<br />'
        . '* <b>Start immediately</b>: the PlagScan plugin will start analyzing documents automatically and immediately after uploading. <br />'
        . '* <b>Start immediately after the first due date</b>: the PlagScan plugin only starts when the first due date has passed. <br />'
        . '* <b>Start immediately after all due dates</b>: the plugin will begin analyzing the documents right after every deadline.';
$string['useroptedout'] = 'Desactivar la detecci&oacute;n de plagio';
$string['viewmatches'] = 'Ver coincidencias';
$string['viewreport'] = 'Ver informe';
$string['wasoptedout'] = 'El usuario desactivo la detecci&oacute;n de plagio';
$string['webonly']='Buscar en Internet';
$string['week'] = 'despu&eacute;s de una semana';
$string['weeks'] = 'despu&eacute;s de 3 meses';
$string['windowsize'] = 'Tama&ntilde;o de la ventana';
$string['windowsize_help'] = 'El tama&ntilde;o de la ventana representa como sera la busqueda granular. Valor recomendado 60.';
$string['yellow']='PlagLevel amarillo empieza en';
$string['report_type']='Reportes:';
$string['newrp_wait']='Estamos generando el enlace para el informe, tenga paciencia';
$string['newrp_redirect']='Ser&aacute; redirigido en unos segundos';
$string['show_to_students_opt2']="Compartir estos resultados";
$string['show_to_students_opt2_help']="Establece que como ven el resultado del an&aacute;lisis los estudiantes";
$string['show_to_students_plvl']="PlagLevel";
$string['show_to_students_links']="PlagLevel e informes";
$string['allowgroups']="Categorias permitidas";
$string['allowgroups_help']="Establece las categor&iacute;as donde puede usar PlagScan (Pj: categoria1, categoria2, ... ). Dejar en blanco para permitir en todas";
$string['callback_setup']="The callback has been set up";
$string['callback_working']="The callback configuration is accepted";
$string['callback_notchecked']="The callback configuration has not been checked";
$string['callback_check']="Check the callback configuration";
$string['callback_help']="The callback configuration is important for getting the reports results when generated and syncronizing them with the Moodle Database";
$string['cron_reset_link']="REINICIAR CRON";
$string['cron_reset']="El cron job ha sido reiniciado";
$string['cron_normal']="The callback configuration is accepted";
$string['cron_running1']="El cron job se est&aacute; ejecutando desde";
$string['cron_running2']="para reiniciar pulse";
$string['cron_help']="Si reinicia el cron job es posible que usted suba archivos duplicados a PlagScan";
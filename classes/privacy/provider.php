<?php

// This file is part of the Plagscan plugin for Moodle - http://moodle.org/
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

namespace plagiarism_plagscan\privacy;

defined('MOODLE_INTERNAL') || die();

use core_plagiarism\privacy\plagiarism_user_provider;
use core_privacy\local\metadata\collection;
use core_privacy\local\request\contextlist;
use core_privacy\local\request\transform;
use core_privacy\local\request\writer;

/**
 * provider.php - Privacy class for user data.
 *
 * @package      plagiarism_plagscan
 * @subpackage   plagiarism
 * @author       Jesús Prieto <jprieto@plagscan.com>  
 * @copyright    2018 PlagScan GmbH {@link https://www.plagscan.com/}
 * @license      http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class provider implements
\core_privacy\local\metadata\provider, \core_plagiarism\privacy\plagiarism_provider {

    // This trait must be included
    use \core_privacy\local\legacy_polyfill;

// This trait must be included
    use \core_plagiarism\privacy\legacy_polyfill;

    /**
     * Get the metadata of the plugin system
     * 
     * @param collection $collection Collection to add items to.
     * 
     * @return collection Collection of user data of the plugin.
     */
    public static function _get_metadata(collection $collection) {
        $collection->link_subsystem('core_plagiarism', 'privacy:metadata:core_plagiarism');
        $collection->link_subsystem('core_files', 'privacy:metadata:core_files');

        $collection->add_database_table(
                'plagiarism_plagscan', [
                    'id' => 'privacy:metadata:plagiarism_plagscan:id',
                    'userid' => 'privacy:metadata:plagiarism_plagscan:userid',
                    'pid' => 'privacy:metadata:plagiarism_plagscan:pid',
                    'pstatus' => 'privacy:metadata:plagiarism_plagscan:pstatus',
                    'status' => 'privacy:metadata:plagiarism_plagscan:status',
                    'cmid' => 'privacy:metadata:plagiarism_plagscan:cmid',
                    'filehash' => 'privacy:metadata:plagiarism_plagscan:filehash',
                    'updatestatus' => 'privacy:metadata:plagiarism_plagscan:updatestatus',
                    'submissiontype' => 'privacy:metadata:plagiarism_plagscan:submissiontype'
                ], 'privacy:metadata:plagiarism_plagscan');

        $collection->add_database_table(
                'plagiarism_plagscan_config', [
                    'id' => 'privacy:metadata:plagiarism_plagscan_config:id',
                    'cm' => 'privacy:metadata:plagiarism_plagscan_config:cm',
                    'upload' => 'privacy:metadata:plagiarism_plagscan_config:upload',
                    'complete' => 'privacy:metadata:plagiarism_plagscan_config:complete',
                    'username' => 'privacy:metadata:plagiarism_plagscan_config:username',
                    'nondisclosure' => 'privacy:metadata:plagiarism_plagscan_config:nondisclosure',
                    'show_report_to_students' => 'privacy:metadata:plagiarism_plagscan_config:show_report_to_students',
                    'show_students_links' => 'privacy:metadata:plagiarism_plagscan_config:show_students_links',
                    'ownerid' => 'privacy:metadata:plagiarism_plagscan_config:ownerid',
                    'submissionid' => 'privacy:metadata:plagiarism_plagscan_config:submissionid',
                    'enable_online_text' => 'privacy:metadata:plagiarism_plagscan_config:enable_online_text'
                ], 'privacy:metadata:plagiarism_plagscan_config');

        $collection->add_database_table(
                'plagiarism_plagscan_user', [
                    'id' => 'privacy:metadata:plagiarism_plagscan_user:id',
                    'userid' => 'privacy:metadata:plagiarism_plagscan_user:userid',
                    'psuserid' => 'privacy:metadata:plagiarism_plagscan_user:psuserid'
                ], 'privacy:metadata:plagiarism_plagscan_user');

        // External Services.
        $collection->link_external_location(
                'PlagScan API', [
                    'useremail' => 'privacy:metadata:plagiarism_external_plagscan_api:useremail',
                    'userfirstname' => 'privacy:metadata:plagiarism_external_plagscan_api:userfirstname',
                    'userlastname' => 'privacy:metadata:plagiarism_external_plagscan_api:userlastname',
                    'fileformat' => 'privacy:metadata:plagiarism_external_plagscan_api:fileformat',
                    'filedata' => 'privacy:metadata:plagiarism_external_plagscan_api:filedata',
                    'filename' => 'privacy:metadata:plagiarism_external_plagscan_api:filename',
                ], 'privacy:metadata:plagiarism_external_plagscan_api');


        return $collection;
    }

    /**
     * Get the list of contexts that contain user information for the specified user.
     *
     * @param   int           $userid       The user to search.
     * @return  contextlist   $contextlist  The list of contexts used in this plugin.
     */
    public static function get_contexts_for_userid(int $userid) {
        $contextlist = new \core_privacy\local\request\contextlist();

        $sql = "SELECT c.id
            FROM {context} c
            JOIN {course_modules} cm ON cm.id = c.instanceid AND c.contextlevel = :contextlevel
            JOIN {plagiarism_plagscan} ps ON ps.cmid = cm.id 
            WHERE ps.userid = :userid
        ";

        $params = [
            'contextlevel' => CONTEXT_MODULE,
            'userid' => $userid,
        ];

        $contextlist->add_from_sql($sql, $params);

        return $contextlist;
    }

    /**
     * Delete all plagiarism data for all users in the specified context.
     * 
     * @param \context $context The context to delete information for.
     */
    public static function delete_plagiarism_for_context(\context $context) {
        global $DB;

        $DB->delete_records('plagiarism_plagscan', ['cmid' => $context->instanceid]);
    }

    /**
     * Delete multiple plagiarism data of a user within a single context.
     *
     * @param   int       $userid The user to delete information for.
     * @param   \context     $context The context to delete information for.
     */
    public static function delete_plagiarism_for_user(int $userid, \context $context) {
        global $DB;

        $DB->delete_records('plagiarism_plagscan', ['userid' => $userid, 'cmid' => $context->instanceid]);
    }

    /**
     * Exports plagiarism data from each plagiarism file for the specified user and context.
     * 
     * @param int $userid The user to export information for.
     * @param \context $context The context  to export information for.
     * @param array $subcontext The subcontext of the context to export information for.
     * @param array $linkarray Link array used to get information for items
     */
    public static function export_plagiarism_user_data(int $userid, \context $context, array $subcontext, array $linkarray) {
        if (!$userid) {
            return;
        }

        global $DB;

        if (isset($linkarray['file'])) {
            $params = ['userid' => $userid, 'cmid' => $context->instanceid, 'filehash' => $linkarray['file']->get_pathnamehash()];
            $sql = "SELECT 'id',            
                'userid',        
                'pid',           
                'pstatus',       
                'status',        
                'cmid',          
                'filehash',      
                'updatestatus',  
                'submissiontype'
                FROM {plagiarism_plagscan}
                WHERE userid = :userid and cmid = :cmid and filehash = :filehash";
            $records = $DB->get_records_sql($sql, $params);
        }

        if (isset($linkarray['content'])) {
            $params = [
                'userid' => $userid,
                'cmid' => $context->instanceid,
                'component' => 'plagiarism_plagscan',
                'contextid' => $context->id
            ];
            $sql = "SELECT 'id',            
                'userid',        
                'pid',           
                'pstatus',       
                'status',        
                'cmid',          
                'filehash',      
                'updatestatus',  
                'submissiontype'
                FROM {plagiarism_plagscan} ps
                INNER JOIN {files} f on f.contenthash = ps.filehash
                WHERE ps.userid = :userid AND ps.cmid = :cmid AND f.component = :component  AND f.contextid = :contextid";
            $records = $DB->get_records_sql($sql, $params);
        }

        if (!isset($records) || !$records) {
            return;
        }

        foreach ($records as $record) {
            $data = (object) [
                'id' => $record->id,
                'userid' => $record->userid,
                'pid' => $record->pid,
                'pstatus' => $record->pstatus,
                'status' => $record->status,
                'cmid' => $record->cmid,
                'filehash' => $record->filehash,
                'updatestatus' => $record->updatestatus,
                'submissiontype' => $record->submissiontype,
            ];

            writer::with_context($context)->export_metadata(
                    $subcontext, 'plagiarism_plagscan_record_' . $record->id, $data, get_string('privacy:export:plagiarism_plagscan:filerecordcontentdescription', 'plagiarism_plagscan'));
        }

        return;
    }

}

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

/**
 * file_handler.php - Class that controls the file observer events
 *
 * @package      plagiarism_plagscan
 * @subpackage   plagiarism
 * @author       Jesús Prieto <jprieto@plagscan.com>
 * @copyright    2018 PlagScan GmbH {@link https://www.plagscan.com/}
 * @license      http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace plagiarism_plagscan\handlers;

use plagiarism_plagscan\classes\plagscan_connection;
use plagiarism_plagscan\classes\plagscan_file;
use plagiarism_plagscan\tasks\plagscan_file_upload_task;

require_once($CFG->dirroot . '/plagiarism/plagscan/lib.php');
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');
}

class file_handler {

    /**
     * Queue of files to be submitted
     * 
     * @var array 
     */
    protected $filesqueue = array();

    /**
     *
     * @var file_handler 
     */
    protected static $instance = null;

    /**
     * Create a singleton instance
     * 
     * @return file_handler
     */
    public static function instance() {
        if (self::$instance === null) {
            self::$instance = new file_handler();
        }

        return self::$instance;
    }

    /**
     * Controls the assesable_upload event and fill the queue with the files received
     * 
     * @param \assignsubmission_file\event\assessable_uploaded $event
     */
    public function file_uploaded(
    \assignsubmission_file\event\assessable_uploaded $event) {

        foreach ($event->other['pathnamehashes'] as $pathnamehash) {
            $file = get_file_storage()->get_file_by_hash($pathnamehash);
            if ($file && !$file->is_directory()) {
                array_push($this->filesqueue, $file);
            }
        }
        $this->handle_files_queue($event->get_context()->instanceid, $event->userid);
    }

    /**
     * Controls the assesable_upload event and fill the queue with the content received
     * 
     * @param \assignsubmission_onlinetext\event\assessable_uploaded $event
     */
    public function onlinetext_uploaded(
    \assignsubmission_onlinetext\event\assessable_uploaded $event) {
        $file = $this->create_file_from_onlinetext_content($event);

        if ($file != null) {
            array_push($this->filesqueue, $file);
        }

        $this->handle_files_queue($event->get_context()->instanceid, $event->userid);
    }

    /**
     * Handles the queue of files and trigger the upload
     * 
     * @global stdClass $DB
     * @param int $cmid
     * @param int $userid
     */
    private function handle_files_queue($cmid, $userid) {
        global $DB;

        $connection = new plagscan_connection();
        $instanceconfig = plagscan_get_instance_config($cmid);

        //Check if the assignment was created from a previous versions without creating it on PS too
        if (isset($instanceconfig->ownerid) && $instanceconfig->ownerid != null) {
            $assign_owner = $DB->get_record('user', array("id" => $instanceconfig->ownerid));
        } else {
            $assign_owner = $DB->get_record('user', array("email" => $instanceconfig->username));
        }

        if ($assign_owner == null) {
            return;
        }

        $assign_psownerid = $connection->find_user($assign_owner);

        $is_multiaccount = get_config('plagiarism_plagscan', 'plagscan_multipleaccounts');
        if ($is_multiaccount) {
            $submitter_user = $DB->get_record('user', array('id' => $userid));
        } else {
            $submitter_user = $DB->get_record('user', array('email' => get_config('plagiarism_plagscan', 'plagscan_admin_email')));
        }

        if ($submitter_user == null) {
            return;
        }

        $submitter_userid = $connection->find_user($submitter_user);

        if ($submitter_userid == null) {
            $submitter_userid = $connection->add_new_user($submitter_user);
        }


        foreach ($this->filesqueue as $key => $file) {

            if (!plagscan_file::find($cmid, $userid, $file->get_pathnamehash())
                    && !plagscan_file::find($cmid, $userid, $file->get_contenthash())) {
                $filedata = array(
                    'submissionid' => $instanceconfig->submissionid,
                    'ownerid' => $assign_psownerid,
                    'submitterid' => $submitter_userid,
                    'email' => $submitter_user->email,
                    'firstname' => $submitter_user->firstname,
                    'lastname' => $submitter_user->lastname);


                $psfile = new \stdClass();
                $psfile->userid = $userid;
                $psfile->cmid = $cmid;
                $psfile->filehash = $file->get_pathnamehash();

                $psfile->pid = 0;
                $psfile->pstatus = '';
                $psfile->status = plagscan_file::STATUS_SUBMITTING;

                $psfile->id = plagscan_file::save($psfile);

                plagscan_file_upload_task::add_task(array(
                    'psfile' => $psfile,
                    'filedata' => $filedata,
                    'pathnamehash' => $file->get_pathnamehash()));
            }
            unset($this->filesqueue[$key]);
        }
    }

    /**
     * Creates a file in the storage folder with the content from the event
     * 
     * @global \plagiarism_plagscan\handlers\stdClass $DB
     * @param \assignsubmission_onlinetext\event\assessable_uploaded $event
     * @return stored_file
     */
    public function create_file_from_onlinetext_content($event) {
        global $DB;

        $content = $event->other['content'];

        if (empty($content)) {
            return null;
        }

        $author = $DB->get_record('user', array('id' => $event->userid));

        $filedata = array(
            'component' => 'plagiarism_plagscan',
            'contextid' => $event->contextid,
            'filearea' => $event->objecttable,
            'filepath' => '/',
            'itemid' => $event->objectid,
            'filename' => 'onlinetext_' . $event->contextid . '_' . $event->get_context()->instanceid . '_' . $event->objectid . "_" . $author->lastname . ".html",
            'userid' => $event->userid,
            'author' => $author->firstname . ' ' . $author->lastname,
            'license' => 'allrightsreserved'
        );

        $filestorage = get_file_storage();

        $previousfile = $filestorage->get_file($filedata['contextid'], $filedata['component'], $filedata['filearea'], $filedata['itemid'], $filedata['filepath'], $filedata['filename']
        );

        if ($previousfile) {
            if ($previousfile->get_contenthash() == sha1($content)) {
                return $previousfile;
            }

            $previousfile->delete();
        }

        return $filestorage->create_file_from_string($filedata, $content);
    }

}

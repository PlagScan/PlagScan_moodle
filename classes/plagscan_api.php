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
 * plagscan_api.php - Class to help working with the PlagScan API.
 *
 * @package      plagiarism_plagscan
 * @subpackage   plagiarism
 * @author       Jesús Prieto <jprieto@plagscan.com>  
 * @copyright    2018 PlagScan GmbH {@link https://www.plagscan.com/}
 * @license      http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace plagiarism_plagscan\classes;

use plagiarism_plagscan\event\error_happened;

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');
}

class plagscan_api {

    /**
     * API_FILES
     */
    const API_FILES = "/documents";

    /**
     * API_USERS
     */
    const API_USERS = "/users";

    /**
     * API_SUBMISSIONS
     */
    const API_SUBMISSIONS = "/submissions";

    /**
     * API_TOKEN
     */
    const API_TOKEN = "/token";
    
    /**
     * API_TOKEN
     */
    const API_PING = "/ping";

    /**
     * API_CHECK_CALLBACK
     */
    const API_CHECK_CALLBACK = "/checkcallback";

    /**
     * API_DEFAULT_URL
     */
    const API_DEFAULT_URL = "https://api.plagscan.com/v3";

    /**
     * API_INTEGRATION_CONSUMER_KEY
     */
    const API_INTEGRATION_CONSUMER_KEY = "APIconsumer";

    /**
     * API_INTEGRATION_CONSUMER_VALUE
     */
    const API_INTEGRATION_CONSUMER_VALUE = "Moodle";
    
    /**
     * API_ERROR_MSG_DOCUMENT_REJECTED
     */
    const API_ERROR_MSG_DOCUMENT_REJECTED = "The document has failed during the upload/convertion process: Document without text or broken file - minimum length is 50 characters";
    
    /**
     * API_ERROR_MSG_DOCUMENT_DELETED
     */
    const API_ERROR_MSG_DOCUMENT_DELETED = "The document has been deleted.";
    
    /**
     * API_ERROR_MSG_NO_REPORT
     */
    const API_ERROR_MSG_NO_REPORT = "There is no report for the document";
    
    /**
     * API_ERROR_MSG_DOCUMENT_DOES_NOT_BELONG_TO_INST
     */
    const API_ERROR_MSG_DOCUMENT_DOES_NOT_BELONG_TO_INST = "The document doesn't belong to this institution";
    
    /**
     * API_ERROR_MSG_USER_DOES_NOT_BELONG_TO_INST
     */
    const API_ERROR_MSG_USER_DOES_NOT_BELONG_TO_INST = "The user doesn't belong to this institution";

    /**
     * API_ERROR_MSG_SUBMISSION_DOES_NOT_EXIST
     */
    const API_ERROR_MSG_SUBMISSION_DOES_NOT_EXIST = "The submission doesn't exist or the user is not the owner of the submission";
    
    /**
     * API_ERROR_MSG_USER_DOES_NOT_EXIST
     */
    const API_ERROR_MSG_USER_DOES_NOT_EXIST = "That user doesn't exist";

    /**
     *
     * @var null|plagscan_api
     */
    private static $instance = null;

    /**
     * Returns a plagscan_api instance
     * 
     * @return null|static
     */
    public final static function instance() {
        if (isset(self::$instance)) {
            return self::$instance;
        } else {
            return self::$instance = new plagscan_api();
        }
    }

    /**
     * Make a HTTP request to the API
     * 
     * @param string $endPoint
     * @param string $requestType
     * @param array $data
     * @param array $filedata
     * @param bool $urlencodeddata
     * 
     * @return array
     */
    public function request($endPoint, $requestType, $data, $filedata = null, $urlencodeddata = false) {

        $ch = curl_init();
        $url = filter_var(get_config('plagiarism_plagscan', 'plagscan_server'), FILTER_SANITIZE_URL);
        
        $url = $url . $endPoint;

        if ($endPoint != self::API_TOKEN && $endPoint != self::API_PING) {
            $url .= "&" . self::API_INTEGRATION_CONSUMER_KEY . "=" . self::API_INTEGRATION_CONSUMER_VALUE.get_config('plagiarism_plagscan', 'version');
        }

        if ($urlencodeddata) {
            foreach ($data as $param => $value) {
                $url .="&$param=" . urlencode($value);
            }
        }

        if ($requestType == "POST" && $filedata != null) {
            $boundary = uniqid();
            $delimiter = '-------------' . $boundary;

            $data = $this->build_data_files($boundary, $data, $filedata);

            $curlopt = array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 400,
                CURLOPT_CUSTOMREQUEST => $requestType,
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array(
                    //"Authorization: Bearer $TOKEN",
                    "Content-Type: multipart/form-data; boundary=" . $delimiter,
                    "Content-Length: " . strlen($data)
                ),
            );
        } else if ($requestType == "PATCH") {
            $curlopt = array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_CUSTOMREQUEST => $requestType,
                CURLOPT_HTTPHEADER => array(
                    //"Authorization: Bearer $TOKEN",
                    "Content-Type: application/json-patch+json"
                ),
            );
        } else {
            $curlopt = array(
                CURLOPT_URL => $url,
                CURLOPT_CUSTOMREQUEST => $requestType,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_POSTFIELDS => $data,
            );
        }
        curl_setopt_array($ch, $curlopt);
        
        $response = curl_exec($ch);
        
        if(curl_errno($ch)){
            $pslog = array(
                'other' => [
                    'errormsg' => curl_error($ch)
                ]
            );
            error_happened::create($pslog)->trigger();
        }

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        $response_handled = $this->handle_response($response, $httpcode);
        
        if($httpcode >= 400 && isset($response_handled["response"]["error"])){
            $pslog = array(
                'other' => [
                    'errormsg' => $response_handled["response"]["error"]["code"]." - ".$response_handled["response"]["error"]["message"]
                ]
            );
            error_happened::create($pslog)->trigger();
        }
        
        return $response_handled;
    }

    /**
     * Returns the reponse within in array with response json decoded and http code
     * 
     * @param string $response
     * @param int $httpcode
     * @return array
     */
    private function handle_response($response, $httpcode) {
        $response = json_decode($response, true);

        return array("response" => $response, "httpcode" => $httpcode);
    }

    /**
     * Helps to build a HTTP content with a given files data
     * 
     * @param string $boundary
     * @param array $fields
     * @param array $files
     * @return string
     */
    private function build_data_files($boundary, $fields, $files) {
        $data = '';
        $eol = "\r\n";

        $delimiter = '-------------' . $boundary;

        foreach ($fields as $name => $content) {
            $data .= "--" . $delimiter . $eol
                    . 'Content-Disposition: form-data; name="' . $name . "\"" . $eol . $eol
                    . $content . $eol;
        }


        foreach ($files as $file) {
            $data .= "--" . $delimiter . $eol
                    . 'Content-Disposition: form-data; name="fileUpload"; filename="' . $file->get_filename() . '"' . $eol
                    . 'Content-Type: ' . $file->get_mimetype() . '' . $eol
                    . 'Content-Transfer-Encoding: binary' . $eol
            ;

            $data .= $eol;
            $data .= $file->get_content() . $eol;
        }
        $data .= "--" . $delimiter . "--" . $eol;


        return $data;
    }

}

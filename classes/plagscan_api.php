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
* @copyright    2016 PlagScan GmbH {@link https://www.plagscan.com/}
* @license      http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/
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
     * API_URL
     */
    const API_URL = "https://api.plagscan.com/v3";
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
    public final static function instance(){
        if(isset(self::$instance))
            return self::$instance;
        else
            return self::$instance = new plagscan_api();    
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
    public function request($endPoint, $requestType ,$data, $filedata = null, $urlencodeddata = false) {
        
        $ch = curl_init();
        
        $url = self::API_URL.$endPoint;
        
        if($urlencodeddata){
                $paramsJoined = array();

                foreach($data as $param => $value) {
                   $paramsJoined[] = "$param=$value";
                }

                $query = implode('&', $paramsJoined);
                $url .="&".$query;
            
        }
        
        if($requestType == "POST" && $filedata != null){
            $boundary = uniqid();
            $delimiter = '-------------' . $boundary;
            
            $data = $this->build_data_files($boundary, $data, $filedata);
    
            $curlopt =array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_CUSTOMREQUEST => $requestType,
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array(
                  //"Authorization: Bearer $TOKEN",
                  "Content-Type: multipart/form-data; boundary=" . $delimiter,
                  "Content-Length: " . strlen($data)

                ),
            );
        }
        else if($requestType == "PATCH"){
            $curlopt =array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_CUSTOMREQUEST => $requestType,
                CURLOPT_HTTPHEADER => array(
                  //"Authorization: Bearer $TOKEN",
                  "Content-Type: application/json-patch+json" 

                ),
            );
        }
        else{
            $curlopt =array(
                CURLOPT_URL => $url,
                CURLOPT_CUSTOMREQUEST => $requestType,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_POSTFIELDS => $data,
            );
        }
        curl_setopt_array($ch, $curlopt);
        
        $response = curl_exec($ch);

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return $this->handle_response($response, $httpcode);
   }
   
   /**
    * Returns the reponse within in array with response json decoded and http code
    * 
    * @param string $response
    * @param int $httpcode
    * @return array
    */
    private function handle_response($response, $httpcode){
        $response = json_decode($response, true);
        
        return array("response" => $response , "httpcode" => $httpcode);
   }
   
   /**
    * Helps to build a HTTP content with a given files data
    * 
    * @param string $boundary
    * @param array $fields
    * @param array $files
    * @return string
    */
   private function build_data_files($boundary, $fields, $files){
        $data = '';
        $eol = "\r\n";

        $delimiter = '-------------' . $boundary;

        foreach ($fields as $name => $content) {
            $data .= "--" . $delimiter . $eol
                . 'Content-Disposition: form-data; name="' . $name . "\"".$eol.$eol
                . $content . $eol;
        }


        foreach ($files as $file) {
            $data .= "--" . $delimiter . $eol
                . 'Content-Disposition: form-data; name="fileUpload"; filename="' . $file->get_filename(). '"' . $eol
                . 'Content-Type: '.$file->get_mimetype().''.$eol
                . 'Content-Transfer-Encoding: binary'.$eol
                ;

            $data .= $eol;
            $data .= $file->get_content() . $eol;
        }
        $data .= "--" . $delimiter . "--".$eol;


        return $data;
    }
}
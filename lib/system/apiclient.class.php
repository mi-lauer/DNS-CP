<?php
/* lib/system/apiclient.class.php - DNS-CP
 * Copyright (C) 2013  CNS-CP project
 * http://dns-cp-de/
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public License 
 * along with this program. If not, see <http://www.gnu.org/licenses/>. 
 */

class APIClient {
	protected static $curl;
	protected static $baseUrl;
	protected static $httpHeaders = array();

	public static function connect($url) {
		self::$baseUrl = $url;
		self::$curl = curl_init();
		curl_setopt(self::$curl, CURLOPT_RETURNTRANSFER, true);
		self::setHttpHeader('Accept', 'application/json');
	}

	public static function disconnect() {
		curl_close(self::$curl);
	}

	public static function setHttpHeader($name, $value) {
		array_push(self::$httpHeaders, $name.": ".$value);
	}

	protected static function get($url) {
		curl_setopt(self::$curl, CURLOPT_HTTPGET, true);
		curl_setopt(self::$curl, CURLOPT_CUSTOMREQUEST, 'GET');
		return self::executeRequest($url);
	}

	protected static function post($url, array $data = array()) { 
		curl_setopt(self::$curl, CURLOPT_POST, true);
		curl_setopt(self::$curl, CURLOPT_CUSTOMREQUEST, 'POST');
		if ($data) {
			curl_setopt(self::$curl, CURLOPT_POSTFIELDS, http_build_query($data));
		}
		return self::executeRequest($url);
	}

	protected static function executeRequest($url) {
		curl_setopt(self::$curl, CURLOPT_URL, $url);
		curl_setopt(self::$curl, CURLOPT_HTTPHEADER, self::$httpHeaders);
		$response = curl_exec(self::$curl);
		$responseCode = curl_getinfo(self::$curl, CURLINFO_HTTP_CODE);
		if (empty($response)) {
			$response = new StdClass();
		} else {
			$response = json_decode($response);
		}
		return self::object_to_array($response);
	}

	protected static function object_to_array($object){
		$new=NULL;
		if(is_object($object)){
			$object=(array)$object;
		}
		if(is_array($object)){
			$new=array();
			foreach($object as $key => $val) {
				$key=preg_replace("/^\\0(.*)\\0/","",$key);
				$new[$key]=self::object_to_array($val);
			}
		}else{
			$new=$object;
		}
		return $new;
	}
	
	public static function sendGet($data) {
		$url = self::$baseUrl.$data;
		return self::get($url);
	}
	
	public static function sendPost($data) {
		$url = self::$baseUrl;
		return self::post($url, $data);
	}
}

?>
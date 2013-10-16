<?php
/* api/index.php - DNS-CP
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
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);
require_once("../config.php");
require_once("../lib/system/db.class.php");
DB::connect();
require_once("../lib/system/apiclient.class.php");
require_once("../lib/server/server.class.php");
require_once("../lib/server/".$conf['server'].".server.class.php");
require_once("../lib/system/user.class.php");
require_once("../lib/system/func.class.php");
require_once("../lib/system/api.class.php");
if($conf['enableapi'] == false) die(json_encode(array("status" => "400")));
if(isset($_GET['key']) && !empty($_GET['key'])) {
	$array = $_GET;
} elseif(isset($_POST['key']) && !empty($_POST['key'])) {
	$array = $_POST;
} else {
	die(json_encode(array("status" => "400")));
}
if(isset($array['key']) && !empty($array['key'])) {
	if(API::login($array['key'])) {
		if(isset($array['action']) && !empty($array['action']) && isset($array['data']) && !empty($array['data']) && isset($array['domain']) && !empty($array['domain'])) {
			if($array['action'] == "add") {
				if($array['data'] == "zone") {
					echo API::add_zone($array['domain']);
				} elseif($array['data'] == "record") {
					if(isset($array['add'])) {
						echo API::add_record($array['domain'], $array['add']);
					} else { echo json_encode(array("status" => "403")); }
				} else { echo json_encode(array("status" => "404")); }
			} elseif($array['action'] == "del") {
				if($array['data'] == "zone") {
					echo API::del_zone($array['domain']);
				} elseif($array['data'] == "record") {
					if(isset($array['del'])) {
						echo API::del_record($array['domain'], $array['del']);
					} else { echo json_encode(array("status" => "403")); }
				} else { echo json_encode(array("status" => "404")); }
			} elseif($array['action'] == "set") {
				if($array['data'] == "zone") {
					if(isset($array['set'])) {
						echo API::set_zone($array['domain'], $array['set']);
					} else { echo json_encode(array("status" => "403")); }
				} elseif($array['data'] == "record") {
					if(isset($array['set'])) {
						echo API::set_record($array['domain'], $array['set']);
					} else { echo json_encode(array("status" => "403")); }
				} else { echo json_encode(array("status" => "404")); }
			} else { echo json_encode(array("status" => "404")); }
		} else { echo json_encode(array("status" => "403")); }
	} else { echo json_encode(array("status" => "401")); }
} else { echo json_encode(array("status" => "400")); }
DB::close();
?>
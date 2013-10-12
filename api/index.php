<?php
/* api.php - DNS-WI
 * Copyright (C) 2013  OWNDNS project
 * http://owndns.me/
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

require_once("../config.php");
require_once("../lib/database/db.class.php");
DB::connect();
require_once("../lib/server/server.class.php");
require_once("../lib/server/".$conf['server'].".server.class.php");
require_once("../lib/system/func.class.php");
require_once("../lib/system/api.class.php");
if(isset($_GET['key']) && !empty($_GET['key'])) {
	if(API::login($_GET['key'])) {
		if(isset($_GET['action']) && !empty($_GET['action']) && isset($_GET['data']) && !empty($_GET['data'])) {
			if($_GET['action'] == "get") {
				if($_GET['data'] == "zone") {
					if(isset($_GET['domain'])) {
						echo API::get_zone($_GET['domain']);
					} else { echo json_encode(array("status" => "403") }
				} elseif($_GET['data'] == "records") {
					if(isset($_GET['domain'])) {
						echo API::get_record($_GET['domain']);
					} else { echo json_encode(array("status" => "403") }
				} elseif($_GET['data'] == "users") {
					if(isset($_GET['user'])) {
						echo API::get_user($_GET['user']);
					} else { echo json_encode(array("status" => "403") }
				} else { echo json_encode(array("status" => "404")); }
			} elseif($_GET['action'] == "add") {
				if($_GET['data'] == "zone") {
					if(isset($_GET['domain'])) {
						echo API::add_zone($_GET['domain']);
					} else { echo json_encode(array("status" => "403") }
				} elseif($_GET['data'] == "records") {
					if(isset($_GET['domain'])) {
						echo API::add_record($_GET['domain']);
					} else { echo json_encode(array("status" => "403") }
				} elseif($_GET['data'] == "users") {
					if(isset($_GET['user'])) {
						echo API::add_user($_GET['user']);
					} else { echo json_encode(array("status" => "403") }
				} else { echo json_encode(array("status" => "404")); }
			} elseif($_GET['action'] == "del") {
				if($_GET['data'] == "zone") {
					if(isset($_GET['domain'])) {
						echo API::del_zone($_GET['domain']);
					} else { echo json_encode(array("status" => "403") }
				} elseif($_GET['data'] == "records") {
					if(isset($_GET['domain'])) {
						echo API::del_record($_GET['domain']);
					} else { echo json_encode(array("status" => "403") }
				} elseif($_GET['data'] == "users") {
					if(isset($_GET['user'])) {
						echo API::del_user($_GET['user']);
					} else { echo json_encode(array("status" => "403") }
				} else { echo json_encode(array("status" => "404")); }
			} elseif($_GET['action'] == "set") {
				if($_GET['data'] == "zone") {
					if(isset($_GET['domain'])) {
						echo API::set_zone($_GET['domain']);
					} else { echo json_encode(array("status" => "403") }
				} elseif($_GET['data'] == "records") {
					if(isset($_GET['domain'])) {
						echo API::set_record($_GET['domain']);
					} else { echo json_encode(array("status" => "403") }
				} elseif($_GET['data'] == "users") {
					if(isset($_GET['user'])) {
						echo API::set_user($_GET['user']);
					} else { echo json_encode(array("status" => "403") }
				} else { echo json_encode(array("status" => "404")); }
			} else { echo json_encode(array("status" => "404")); }
		} else { echo json_encode(array("status" => "403")); }
	} else { echo json_encode(array("status" => "401")); }
} else { echo json_encode(array("status" => "400")); }
DB::close();
?>
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
require_once("config.php");
require_once("lib/database/db.class.php");
DB::connect($database["host"], $database["user"], $database["pw"], $database["db"], $database["typ"], $database["port"]);
require_once("lib/server/server.class.php");
require_once("lib/server/".$conf['server'].".server.class.php");
require_once("lib/system/func.class.php");
require_once("lib/system/api.class.php");
if(isset($_GET['user']) && isset($_GET['pass']) && isset($_GET['domain']) && isset($_GET['action']) && !empty($_GET['user']) && !empty($_GET['pass']) && !empty($_GET['domain']) && !empty($_GET['action'])) {
	if(API::login($_GET['user'], $_GET['pass']) {
		if(isset($_GET['data']) && !empty($_GET['data'])) {
			switch ($_GET['action']) {
				case "get":
					$data = API::get_data($_GET['domain']);
					break;
				case "add":
					$data = API::add_data($_GET['domain'], $_GET['data']);
					break;
				case "del":
					$data = API::del_data($_GET['domain'], $_GET['data']);
					break;
				case "set"
					$data = API::set_data($_GET['domain']m $_GET['data']);
					break;
				default:
					$data = array("status" => "404");
					break;
			}
			echo json_encode($data);
		} else { echo json_encode(array("status" => "403")); }
	} else { echo json_encode(array("status" => "403")); }
} else { echo json_encode(array("status" => "403")); }
?>
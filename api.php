<?php
/* api.php - DNS-WI
 * Copyright (C) 2013  OWNDNS project
 * http://owndns.me/
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License 
 * along with this program. If not, see <http://www.gnu.org/licenses/>. 
 */
require_once("config.php");
require_once("lib/database/db.class.php");
DB::connect($database["host"], $database["port"], $database["user"], $database["pw"], $database["db"], $database["typ"]);
require_once("lib/server/server.class.php");
require_once("lib/server/".$conf['server'].".server.class.php");
require_once("lib/func.class.php");
require_once("lib/api.class.php");
if(isset($_GET['user']) && isset($_GET['pass']) && isset($_GET['domain']) && isset($_GET['action'])) {
} else { echo json_encode(array("status" => "404")); }
?>
<?php
/* lib/page/home.php - DNS-WI
 * Copyright (C) 2013  OwnDNS project
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

$i = 0;
if(user::isAdmin()){
	$res = DB::query("SELECT * FROM ".$conf["soa"]) or die(DB::error());
} else {
	$res = DB::query("SELECT * FROM ".$conf["soa"]." WHERE owner = :id", array(":id" => $_SESSION['userid'])) or die(DB::error());
}
$i = DB::num_rows($res);

if(user::isAdmin()) { $status = "(<u>administrator</u>)"; } else { $status = "(<u>customer</u>)"; }
template::show("home", array(
		"_name" => "Home",
		"_user" => $_SESSION['username'],
		"_status" => $status,
		"_zones" => $i
		));
?>

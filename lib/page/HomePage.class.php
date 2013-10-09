<?php
/* lib/page/HomePage.class.php - DNS-WI
 * Copyright (C) 2013  OwnDNS project
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
if(!defined("IN_PAGE")) { die("no direct access allowed!"); }
class HomePage extends AbstractPage {
	public $i = 0;
	public $status ="";
	
	public function readData() {
		global $conf;
		if(user::isAdmin()){
			$res = DB::query("SELECT * FROM ".$conf["soa"]) or die(DB::error());
		} else {
			$res = DB::query("SELECT * FROM ".$conf["soa"]." WHERE owner = '".DB::escape($_SESSION['userid'])."'") or die(DB::error());
		}
		$this->i = DB::num_rows($res);

		if(user::isAdmin()) { $this->status = "(<u>administrator</u>)"; } else { $this->status = "(<u>customer</u>)"; }
	}
	public function show() {
		return template::show("home", array(
				"_name" => "Home",
				"_user" => $_SESSION['username'],
				"_status" => $this->status,
				"_zones" => $this->i
				));
	}
}
?>

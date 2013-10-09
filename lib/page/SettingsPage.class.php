<?php
/* lib/page/SettingsPage.class.php - DNS-WI
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
class SettingsPage extends AbstractPage {
	public $error = "";
	public $dns = "";
	
	public function readData() {
		global $conf;
		if(isset($_POST["Submit"])){
			$this->error = user::change_password($_SESSION['userid'], $_POST["password_old"], $_POST["password_one"], $_POST["confirm_password"]);
		}
		foreach($conf["avail_dns_srv"] as $dns) {
			$selected = NULL;
			if(func::currentDNSserver() == $dns) {
				$selected = ' selected';
			}
			$this->dns .= '<option value="'.strtolower($dns).'"'.$selected.'>'.$dns.'</option>'."\n";
		}
	}
	
	public function show() {
		return template::show("settings", array(
			"_name" => "Settings",
			"_error" => $this->error,
			"_dnsserver" => $this->dns
			));
	}
}
?>

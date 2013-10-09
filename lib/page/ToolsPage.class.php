<?php
/* lib/page/ToolsPage.class.php - DNS-WI
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
class ToolsPage extends AbstractPage {
	public $cont = "";
	
	public function readData() {
		if(isset($_POST["Submit"])) {
			if(isset($_POST["dns"]) && $_POST["dns"] != "") {
				$dns = new dns;
				$this->cont .= "<pre>";
				$this->cont .= $dns->get($_POST["dns"]);
				$this->cont .= "</pre>";
			}
			if(isset($_POST["whois"]) && $_POST["whois"] != "") {
				$this->cont .= nl2br(shell_exec("whois ".trim($_POST["whois"])));
			}
		} else { $this->cont = ""; }
	}
	public function show() {
		return template::show("tools", array(
				"_name" => "Tools",
				"_content" => $this->cont
				));
	}
}
?>

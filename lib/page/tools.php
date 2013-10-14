<?php
/* lib/page/tools.php - DNS-CP
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

if(isset($_POST["Submit"])) {
	$cont = "";
	if(isset($_POST["dns"]) && $_POST["dns"] != "") {
		$dns = new dns;
		$cont .= "<pre>";
		$cont .= $dns->get($_POST["dns"]);
		$cont .= "</pre>";
	}
	if(isset($_POST["whois"]) && $_POST["whois"] != "") {
		$whois = new Whois();
		$data = $whois->Lookup(trim($_POST["whois"]));
		foreach($data['rawdata'] as $id => $value) {
			$cont .= $value."<br />";
		}
	}
} else { $cont = ""; }
template::show("tools", array(
		"_name" => "Tools",
		"_content" => $cont
		));
?>

<?php
/* lib/page/zone.php - DNS-CP
 * Copyright (C) 2013  DNS-CP project
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

?>
	<?php
	$isAdmin = user::isAdmin();
	$show_list = true;
	$data = false;
	if(isset($_GET["act"]) && $_GET["act"] == "add") {
		if(isset($_POST["Submit"])){
			if(isset($_POST['name']) && $_POST['name'] != "") {
				$row = server::get_zone_by_name($_POST['name']);
				if(!empty($row["id"])) {
					$data = '<font color="#ff0000">Zone already exists.</font>';

				}else if(empty($_POST['name']) || $_POST['name'] == "." || strlen($_POST['name']) < 2) {
					$data = '<font color="#ff0000">Please enter a valid domain name!</font>';

				}else{
					server::add_zone($_POST['name'], $_POST['owner']);
					$row = server::get_zone_by_name($_POST['name']);
					if(isset($conf["ns"]) && $conf["ns"] != Null){
						foreach($conf["ns"] as $id => $ns) {
							$bind = array("newhost" => $row['origin'], "newtype" => "NS", "newdestination" => $ns, "newpri" => "0", "newttl" => $conf["minimum_ttl"]);
							server::add_record($row['id'], $bind);
						}
					}
					if(isset($conf["a"]) && $conf["a"] != Null){
					
						$bind = array("newhost" => $row['origin'], "newtype" => "A", "newdestination" => $conf["a"], "newpri" => "0", "newttl" => $conf["minimum_ttl"]);
						server::add_record($row['id'], $bind);
						$bind = array("newhost" => "*.".$row['origin'], "newtype" => "A", "newdestination" => $conf["a"], "newpri" => "0", "newttl" => $conf["minimum_ttl"]);
						server::add_record($row['id'], $bind);
					}
					if(isset($conf["aaaa"]) && $conf["aaaa"] != Null){
						$bind = array("newhost" => $row['origin'], "newtype" => "AAAA", "newdestination" => $conf["aaaa"], "newpri" => "0", "newttl" => $conf["minimum_ttl"]);
						server::add_record($row['id'], $bind);
					}
					if(isset($conf["txt"]) && $conf["txt"] != Null){
						$bind = array("newhost" => $row['origin'], "newtype" => "TXT", "newdestination" => $conf["txt"], "newpri" => "0", "newttl" => $conf["minimum_ttl"]);
						server::add_record($row['id'], $bind);
					}					
					$bind = array("newhost" => $row['origin'], "newtype" => "MX", "newdestination" => "mail.".$row['origin'], "newpri" => "10", "newttl" => $conf["minimum_ttl"]);
					server::add_record($row['id'], $bind);
					$data = '<font color="#008000">Zone <b>'.$_POST['name'].'</b> sucessfully added.</font>';
				}
			} else{
				$data = '<font color="#ff0000">Please enter a domain name</font>';
			}
			$data .= "<br /><br />";

		} else {
			$show_list = false;
			$res3 = user::get_users();
			if(!isset($data) or empty($data) or !$data) $data = "";
			tpl::show("zone_add", array(
					"name" => "Zones",
					"isAdmin" => $isAdmin,
					"res3" => $res3,
					"daza" => $data,
					"title" => $title,
					"login" => $login,
					"menu" => $tmenu,
					"build" => $conf["build"],
					"version" => $conf["version"]
					));
		}

	}elseif(isset($_GET["id"])){
		if(isset($_GET["act"]) && $_GET["act"] == "del" && $isAdmin) {
			server::del_zone($_GET["id"]);
			$data = '<font color="#008000">Domain deleted successfully.</font><br /><br />';
		} else {
			if(isset($_POST["Submit"])){
				$total = $_POST["total"];
				for($x = 0; $x < $total; $x++) {
					if(($_POST['type'][$x] == "MX") && ($_POST['pri'][$x] == 0)) {
						$_POST['pri'][$x] = 10;
					} elseif($_POST['type'][$x] != "MX") {
						$_POST['pri'][$x] = 0;
					}
					if(!$_POST['host'][$x]) {
						$_POST['host'][$x] = $_POST["zone"];
					}
					if(!$_POST['ttl'][$x] && $_POST['ttl'][$x] < $conf["minimum_ttl"]) {
						$_POST['ttl'][$x] = $conf["minimum_ttl"];
					}
					if(! $_POST['destination'][$x]) {
						$_POST['destination'][$x] = "";
					}
					$bind = array('host' => $_POST['host'][$x], 'type' => $_POST['type'][$x], 'aux' => $_POST['pri'][$x], 'destination' => $_POST['destination'][$x], 'ttl' => $_POST['ttl'][$x], 'host_id' => $_POST['host_id'][$x]);
					server::set_record($_GET['id'], $bind);
					
					if(isset($_POST['delete'][$x])) {
						server::del_record($_GET['id'], $_POST['host_id'][$x]);
					}
				}
				if(($_POST['newhost']) || ($_POST['newdestination'])) {
					if(! $_POST['newhost']) {
						$_POST['newhost'] = $_POST["zone"];
					}
					if(!$_POST['newdestination']) {
						$_POST['newdestination'] = $_POST["zone"];
					}
					if(!$_POST['newttl'] && $_POST['newttl'] < $conf["minimum_ttl"]) {
						$_POST['newttl'] = $conf["minimum_ttl"];
					}
					if(($_POST['newtype'] == "MX") && ($_POST['newpri'] == 0)) {
						$_POST['newpri'] = 10;
					} elseif($_POST['newtype'] != "MX") {
						$_POST['newpri'] = 0;
					}					
					$bind = array("newhost" => $_POST['newhost'], "newtype" => $_POST['newtype'], "newdestination" => $_POST['newdestination'], "newpri" => $_POST['newpri'], "newttl" => $_POST['newttl']);
					server::add_record($_GET['id'], $bind);
				}
				$old_serial = $_POST['serial'];
				if(substr($old_serial, 0, -2) == date("Ymd")) {
					$serial = $old_serial + 1;
				} else {
					$serial = date("Ymd")."01";
				}
				if($isAdmin) {
					$bind = array("refresh" => $_POST['refresh'], "retry" => $_POST['retry'], "expire" => $_POST['expire'], "attl" => $_POST['attl'], "owner" => $_POST['owner'], "serial" => $serial);
					server::set_zone($_GET['id'], $bind);
				} else {
					$bind = array("refresh" => $_POST['refresh'], "retry" => $_POST['retry'], "expire" => $_POST['expire'], "attl" => $_POST['attl'], "serial" => $serial);
					server::set_zone($_GET['id'], $bind);
				}
				$data = '<font color="#008000">Done</font><br /><br />';
			}

			if($isAdmin){
				$row = server::get_zone($_GET["id"]);
				$res2 = server::get_all_records($_GET["id"]);
			} else {
				$row = server::get_zone($_GET["id"], $_SESSION['userid']);
				$res2 = server::get_all_records($_GET["id"]);
			}

			if($row["owner"] == $_SESSION['userid'] OR $isAdmin) {
				$i = 0;
				$res3 = user::get_users();
				tpl::show("zone_edit", array(
						"name" => "Zones",
						"row" => $row,
						"isAdmin" => $isAdmin,
						"res3" => $res3,
						"res2" => $res2,
						"conf" => $conf,
						"i" => count($res2),
						"data" => $data,

						"title" => $title,
						"login" => $login,
						"menu" => $tmenu,
						"build" => $conf["build"],
						"version" => $conf["version"]
						));

				$show_list = false;
			} else { $data = "No Access"; }
		} 
	}

	if($show_list) {
		if($isAdmin){
			$res = server::get_all_zones();
		} else {
			$res = server::get_all_zones($_SESSION['userid']);
		}
		$zones  = array();
		$zoneid = 0;
		
		foreach($res as $id => $row) {
			$zoneid++;
			$zones[$zoneid] = $row;
			$zones[$zoneid]["records"] = count(server::get_all_records($row["id"]));
		}

		if($zoneid > 0) {
			if($isAdmin){
				$data .= '	<strong><a href="?page=zone&act=add">Create a new zone</a></strong><br /><br />'."\n";
			}
		}else{
			$data = 'There are currently no zones available. <strong><a href="?page=zone&act=add">Create your first zone</a></strong>';
		}
			tpl::show("zone_list", array(
					"name" => "Zones",
					"zones" => $zones,
					"isAdmin" => $isAdmin,
					"data" => $data,
					"title" => $title,
					"login" => $login,
					"menu" => $tmenu,
					"build" => $conf["build"],
					"version" => $conf["version"]
					));
	}
		?>


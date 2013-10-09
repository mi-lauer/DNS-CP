<?php
/* lib/page/ZonePage.class.php - DNS-WI
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
class ZonePage extends AbstractPage {
/*will be changes later*/
public function show() {
	global $conf;
$ret = '
<h2><a href="?page=home">DNS</a> &raquo; <a href="#" class="active">Zones</a></h2>
<div id="main">';
	$isAdmin = user::isAdmin();
	$show_list = true;
	if(isset($_GET["act"]) && $_GET["act"] == "add") {
		if(isset($_POST["Submit"])){
			if(isset($_POST['name']) && $_POST['name'] != "") {
				$zone_name = $_POST['name'].".";
				$res = DB::query("SELECT * FROM ".$conf["soa"]." where origin = :zone", array(":zone" => $zone_name));
				$row = DB::fetch_array($res);
				if(!empty($row["id"])) {
					$ret .= '<font color="#ff0000">Zone already exists.</font>';

				}else if(empty($_POST['name']) || $_POST['name'] == "." || strlen($_POST['name']) < 2) {
					$ret .= '<font color="#ff0000">Please enter a valid domain name!</font>';

				}else{
					$bind = array(":zone" => $zone_name, ":ns" => $conf["soans"], ":mbox" => $conf["mbox"], ":serial" => date("Ymd").'01', ":refresh" => $conf["refresh"], ":retry" => $conf["retry"], ":expire" => $conf["expire"], ":minimum" => $conf["minimum_ttl"], ":ttl" => $conf["ttl"], ":owner" => $_POST['owner']);
					DB::query("INSERT INTO ".$conf["soa"]." (origin, ns, mbox, serial, refresh, retry, expire, minimum, ttl, owner) VALUES (:zone, :ns, :mbox, :serial, :refresh, :retry, :expire, :minimum, :ttl, :owner)", $bind) or die(DB::error());
					$res = DB::query("SELECT * FROM ".$conf["soa"]." where origin = :zone", array(":zone" => $zone_name)) or die(DB::error());
					$row = DB::fetch_array($res);

					if(isset($conf["ns"]) && $conf["ns"] != Null){
						foreach($conf["ns"] as $id => $ns) {
							$bind = array(":zone" => $row['id'], ":name" => $zone_name, ":type" => "NS", ":data" => $ns, ":aux" => "0", ":ttl" => $conf["minimum_ttl"]);
							DB::query("INSERT INTO ".$conf["rr"]." (zone, name, type, data, aux, ttl) VALUES (:zone, :name, :type, :data, :aux, :ttl);", $bind) or die(DB::error());
						}
					}
					if(isset($conf["a"]) && $conf["a"] != Null){
						$bind = array(":zone" => $row['id'], ":name" => $zone_name, ":type" => "A", ":data" => $conf["a"], ":aux" => "0", ":ttl" => $conf["minimum_ttl"]);
						DB::query("INSERT INTO ".$conf["rr"]." (zone, name, type, data, aux, ttl) VALUES (:zone, :name, :type, :data, :aux, :ttl);", $bind) or die(DB::error());
						$bind = array(":zone" => $row['id'], ":name" => "*", ":type" => "A", ":data" => $conf["a"], ":aux" => "0", ":ttl" => $conf["minimum_ttl"]);
						DB::query("INSERT INTO ".$conf["rr"]." (zone, name, type, data, aux, ttl) VALUES (:zone, :name, :type, :data, :aux, :ttl);", $bind) or die(DB::error());
					}
					if(isset($conf["aaaa"]) && $conf["aaaa"] != Null){
						$bind = array(":zone" => $row['id'], ":name" => $zone_name, ":type" => "AAAA", ":data" => $conf["aaaa"], ":aux" => "0", ":ttl" => $conf["minimum_ttl"]);
						DB::query("INSERT INTO ".$conf["rr"]." (zone, name, type, data, aux, ttl) VALUES (:zone, :name, :type, :data, :aux, :ttl);", $bind) or die(DB::error());
					}
					if(isset($conf["txt"]) && $conf["txt"] != Null){
						$bind = array(":zone" => $row['id'], ":name" => $zone_name, ":type" => "TXT", ":data" => $conf["txt"], ":aux" => "0", ":ttl" => $conf["minimum_ttl"]);
						DB::query("INSERT INTO ".$conf["rr"]." (zone, name, type, data, aux, ttl) VALUES (:zone, :name, :type, :data, :aux, :ttl);", $bind) or die(DB::error());
					}
					$bind = array(":zone" => $row['id'], ":name" => $zone_name, ":type" => "MX", ":data" => "mail.".$zone_name, ":aux" => "10", ":ttl" => $conf["minimum_ttl"]);
					DB::query("INSERT INTO ".$conf["rr"]." (zone, name, type, data, aux, ttl) VALUES (:zone, :name, :type, :data, :aux, :ttl);", $bind) or die(DB::error());
					$ret .= '<font color="#008000">Zone <b>'.$_POST['name'].'</b> sucessfully added.</font>';
				}
			} else{
				$ret .= '<font color="#ff0000">Please enter a domain name</font>';
			}
			$ret .= "<br /><br />";

		} else {
			$show_list = false;

			$ret .= '
			<form name="form1" method="post" action="?page=zone&act=add" class="jNice">
				<table width="320"  border="0">
					<tr>
						<td><div align="right"><strong>Zone:</strong></div></td>
						<td><input class="text" type="text" name="name"></td>
						<td>(without dot at the end)</td>
					</tr>
					<tr>
						<td><div align="right"><strong>Owner: </strong></div></td>
						<td>
							<select name="owner">
								'; 
								$res3 = DB::query("SELECT * FROM ".$conf["users"]." ORDER BY username ASC") or die(DB::error());
								while ($row3 = DB::fetch_array($res3)) {
								$ret .= '<option value="'.$row3["id"].'">'.$row3["username"].'</option>';
								} $ret .= '
							</select>
						</td>
						<td>&nbsp;</td>
					</tr>
					<tr class="odd">
						<td>&nbsp;</td>
						<td><input name="Submit" type="submit" value="Add zone"></td>
						<td>&nbsp;</td>
					</tr>
				</table>
			</form>
			';
		}

	}elseif(isset($_GET["id"])){
		if(isset($_GET["act"]) && $_GET["act"] == "del" && $isAdmin) {
			DB::query("DELETE FROM ".$conf["soa"]." WHERE id = :id", array(":id" => $_GET["id"])) or die(DB::error());
			DB::query("DELETE FROM ".$conf["rr"]." WHERE zone = :id", array(":id" => $_GET["id"])) or die(DB::error());
			$ret .= '<font color="#008000">Domain deleted successfully.</font><br /><br />';
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
					$bind = array(":name" => $_POST['host'][$x],":type" => $_POST['type'][$x],":aux" => $_POST['type'][$x],":data" => $_POST['destination'][$x],":ttl" => $_POST['ttl'][$x],":id" => $_POST['host_id'][$x],":zone" => $_GET['id']);
					DB::query("UPDATE ".$conf["rr"]." SET name = :name, type = :type, aux = :aux, data = :data, ttl = :ttl WHERE id = :id AND zone = :zone", $bind) or die(DB::error());

					if(isset($_POST['delete'][$x])) {
						DB::query("DELETE FROM ".$conf["rr"]." WHERE id = :id AND zone = :zone", array(":id" => $_POST['host_id'][$x],":zone" => $_GET['id'])) or die(DB::error());
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
					$bind = array(":zone" => $_GET['id'],":name" => $_POST['newhost'],":type" => $_POST['newtype'],":data" => $_POST['newdestination'],":aux" => $_POST['newpri'],":ttl" => $_POST['newttl']);
					DB::query("INSERT INTO ".$conf["rr"]." (id, zone, name, type, data, aux, ttl) VALUES (NULL, :zone, :name, :type, :data, :aux, :ttl)", $bind) or die(DB::error());
				}
				$old_serial = $_POST['serial'];
				if(substr($old_serial, 0, -2) == date("Ymd")) {
					$serial = $old_serial + 1;
				} else {
					$serial = date("Ymd")."01";
				}
				if($isAdmin) {
					$bind = array(":refresh" => $_POST['refresh'],":retry" => $_POST['retry'],":expire" => $_POST['expire'],":ttl" => $_POST['attl'],":owner" => $_POST['owner'],":serial" => $serial,":id" => $_GET['id']);
					DB::query("UPDATE ".$conf["soa"]." SET refresh = :refresh, retry = :retry, expire = :expire, ttl = :ttl, owner = :owner, serial = :serial WHERE id = :id", $bind) or die(DB::error());
				} else {
					$bind = array(":refresh" => $_POST['refresh'],":retry" => $_POST['retry'],":expire" => $_POST['expire'],":ttl" => $_POST['attl'],":serial" => $serial,":id" => $_GET['id']);
					DB::query("UPDATE ".$conf["soa"]." SET refresh = :refresh, retry = :retry, expire = :expire, ttl = :ttl, serial = :serial WHERE id = :id", $bind) or die(DB::error());
				}
				$ret .= '<font color="#008000">Done</font><br /><br />';
			}

			if($isAdmin){
				$res = DB::query("SELECT * FROM ".$conf["soa"]." where id = :id", array(":id" => $_GET["id"])) or die(DB::error());
				$res2 = DB::query("SELECT * FROM ".$conf["rr"]." where zone = :id ORDER BY type ASC", array(":id" => $_GET["id"])) or die(DB::error());
			} else {
				$res = DB::query("SELECT * FROM ".$conf["soa"]." where id = :id and owner = :owner", array(":id" => $_GET["id"], ":owner" => $_SESSION['userid'])) or die(DB::error());
				$res2 = DB::query("SELECT * FROM ".$conf["rr"]." where zone =' :id ORDER BY type ASC", array(":id" => $_GET["id"])) or die(DB::error());
			}

			$row = DB::fetch_array($res);
			if($row["owner"] == $_SESSION['userid'] OR $isAdmin) {
				$i = 0;

				$ret .= '

				<form name="form1" method="post" action="?page=zone&id='.$row["id"].'" class="jNice">
					<table border="0" cellpadding="0" cellspacing="3">
						<tr>
							<td><div align="right"><strong>Zone:</strong></div></td>
							<td>'.func::ent($row["origin"]).'</td>
							<td><div align="right"><strong>Serial:</strong></div></td>
							<td>'.func::ent($row["serial"]).'</td>
						</tr>
						<tr>
							<td><div align="right"><strong>Refresh:</strong></div></td>
							<td><input class="text" type="text" name="refresh" size="25" value="'.func::ent($row["refresh"]).'"></td>
							<td><div align="right"><strong>Retry:</strong></div></td>
							<td><input class="text" type="text" name="retry" size="25" value="'.func::ent($row["retry"]).'"></td>
						</tr>
						<tr>
							<td><div align="right"><strong>Expire:</strong></div></td>
							<td><input class="text" type="text" name="expire" size="25" value="'.func::ent($row["expire"]).'"></td>
							<td><div align="right"><strong>TTL:</strong></div></td>
							<td><input class="text" type="text" name="attl" size="25" value="'.func::ent($row["ttl"]).'"></td>
						</tr>
						'; if($isAdmin) { $ret .= '
						<tr>
							';
							$res3 = DB::query("SELECT * FROM ".$conf["users"]." ORDER BY username ASC") or die(DB::error());
							$ret .= '
							<td><div align="right"><font face="Arial,Helvetica" size="-1"><strong>Owner: </strong></font></div></td>
							<td>
								<select name="owner">
									'; while ($row3 = DB::fetch_array($res3)) {
									if($row3["id"] == $row["owner"]) { $ret .= '
									<option value="'.$row3["id"].'" selected>'.$row3["username"].'</option>
									'; } else { $ret .= '
									<option value="'.$row3["id"].'">'.$row3["username"].'</option>
									'; } } $ret .= '
								</select>
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						
					</table>

					<input type="hidden" name="serial" value="'.func::ent($row["serial"]).'">
					<input type="hidden" name="zone" value="'.func::ent($row["origin"]).'">
					<input type="hidden" name="zoneid" value="'.func::ent($row["id"]).'">
					<table border="0" cellpadding="0" cellspacing="3">
						<tr>
							<td><strong>Host</strong></td>
							<td><strong>TTL</strong></td>
							<td><strong>Type</strong></td>
							<td><strong>Prio</strong></td>
							<td><strong>Data</strong></td>
							<td><strong>Manage</strong></td>
						</tr>
						'; while ($row2 = DB::fetch_array($res2)) { $ret .= '
						<tr>
							<td>
								<input type="hidden" name="host_id['.$i.']" value="'.func::ent($row2["id"]).'">
								<input class="text" type="text" name="host['.$i.']" value="'.func::ent($row2["name"]).'" size="14">
							</td>
							<td><input class="text" type="text" name="ttl['.$i.']" size="1" value="'.func::ent($row2["ttl"]).'"></td>
							<td>'.func::getOptions($row2["type"], $i).'</td>
							<td><input class="text" type="text" name="pri['.$i.']" size="1" value="'.func::ent($row2["aux"]).'"></td>
							<td><input class="text" type="text" name="destination['.$i.']" size="14" value="'.func::ent($row2["data"]).'"></td>
							<td><center><input type="checkbox" name="delete['.$i.']" /></center></td>
						</tr>

						'; $i++; } $ret .= '
						<tr>
							<td colspan="6"><hr size="1" noshade></td>
						</tr>
						<tr>
							<td><input class="text" type="text" name="newhost" size="14"></td>
							<td><input class="text" type="text" name="newttl" size="1" value="'.$conf["minimum_ttl"].'"></td>
							<td>'.func::getOptions("A").'</td>
							<td><input class="text" type="text" name="newpri" size="1" value="0"></td>
							<td><input class="text" type="text" name="newdestination" size="14"></td>
							<td>&nbsp;</td>
						</tr>
						<tr class="odd">
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>
								<input type="hidden" name="total" value="'.$i.'">
								<input name="Submit" type="submit" value="Save">
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</table>
				</form>

				';
				$show_list = false;
			} else { $ret .=  "No Access"; }
		} 
	}
	}
	if($show_list) {
		if($isAdmin){
			$res = DB::query("SELECT * FROM ".$conf["soa"]." ORDER BY origin ASC") or die(DB::error());
		} else {
			$res = DB::query("SELECT * FROM ".$conf["soa"]." WHERE owner = :owner ORDER BY origin ASC", array(":owner" => $_SESSION['userid'])) or die(DB::error());
		}

		$zones  = array();
		$zoneid = 0;
		while($row = DB::fetch_array($res)) {
			$zoneid++;
			$zones[$zoneid] = $row;
			$zones[$zoneid]["records"] = DB::num_rows(DB::query("SELECT * FROM ".$conf["rr"]." WHERE zone = :id", array(":id" => $row["id"]))) or die(DB::error());
		}

		if($zoneid > 0) {
			if($isAdmin){
				$ret .= '<strong><a href="?page=zone&act=add">Create a new zone</a></strong><br /><br />'."\n";
			}
			$ret .= '
			<table width="100%"  border="0" cellspacing="1" class="jNice">
				<tr>
					<td><strong>Name</strong></td>
					<td><strong>Serial</strong></td>
					<td><strong>Records</strong></td>
					<td><strong>Manage</strong></td>
				</tr>
				';
				foreach($zones as $zoneid => $row) {
					$ret .= '
					<tr>
						<td class="action"><a class="view" href="?page=zone&id='.$row["id"].'">'.substr($row["origin"], 0, strlen($row["origin"])-1).'</a></td>
						<td class="action"><a class="edit" href="?page=zone&id='.$row["id"].'">'.$row["serial"].'</a></td>
						<td class="action"><a class="edit" href="?page=zone&id='.$row["id"].'">'.$row["records"].'</a></td>
						'; if($isAdmin){ $ret .= '
						<td class="action"><a class="delete" href="?page=zone&id='.$row["id"].'&act=del" onClick="return confirm(\'Do you really want to remove this zone?\');">Delete</a></td>
						'; } else { $ret .= '
						<td>&nbsp;</td>
						'; } $ret .= '
					</tr>
					';
				}
				$ret .= '</table>
				';
			}else{
				$ret .= 'There are currently no zones available. <strong><a href="?page=zone&act=add">Create your first zone</a></strong>';
			}
		}
		$ret .= '
	</div>';
 return $ret; } } ?>
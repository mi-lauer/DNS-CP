<?php
/* lib/page/zone.php - DNS-CP
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

?>
<h2><a href="?page=home">DNS</a> &raquo; <a href="#" class="active">Zones</a></h2>
<div id="main">
	<?php
	$isAdmin = user::isAdmin();
	$show_list = true;
	if(isset($_GET["act"]) && $_GET["act"] == "add") {
		if(isset($_POST["Submit"])){
			if(isset($_POST['name']) && $_POST['name'] != "") {
				$row = server::get_zone_by_name($_POST['name']);
				if(!empty($row["id"])) {
					echo '<font color="#ff0000">Zone already exists.</font>';

				}else if(empty($_POST['name']) || $_POST['name'] == "." || strlen($_POST['name']) < 2) {
					echo '<font color="#ff0000">Please enter a valid domain name!</font>';

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
					echo '<font color="#008000">Zone <b>'.$_POST['name'].'</b> sucessfully added.</font>';
				}
			} else{
				echo '<font color="#ff0000">Please enter a domain name</font>';
			}
			echo "<br /><br />";

		} else {
			$show_list = false;

			?>
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
								<?php 
								$res3 = user::get_users();
								foreach($res3 as $id3 => $row3 ) { ?>
								<option value="<?php echo $row3["id"]; ?>"><?php echo $row3["username"]; ?></option>
								<?php } ?>
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
			<?php
		}

	}elseif(isset($_GET["id"])){
		if(isset($_GET["act"]) && $_GET["act"] == "del" && $isAdmin) {
			server::del_zone($_GET["id"]);
			echo '<font color="#008000">Domain deleted successfully.</font><br /><br />';
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
				echo '<font color="#008000">Done</font><br /><br />';
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

				?>

				<form name="form1" method="post" action="?page=zone&id=<?php echo $row["id"]; ?>" class="jNice">
					<table border="0" cellpadding="0" cellspacing="3">
						<tr>
							<td><div align="right"><strong>Zone:</strong></div></td>
							<td><?php echo func::ent($row["origin"]); ?></td>
							<td><div align="right"><strong>Serial:</strong></div></td>
							<td><?php echo func::ent($row["serial"]); ?></td>
						</tr>
						<tr>
							<td><div align="right"><strong>Refresh:</strong></div></td>
							<td><input class="text" type="text" name="refresh" size="25" value="<?php echo func::ent($row["refresh"]); ?>"></td>
							<td><div align="right"><strong>Retry:</strong></div></td>
							<td><input class="text" type="text" name="retry" size="25" value="<?php echo func::ent($row["retry"]); ?>"></td>
						</tr>
						<tr>
							<td><div align="right"><strong>Expire:</strong></div></td>
							<td><input class="text" type="text" name="expire" size="25" value="<?php echo func::ent($row["expire"]); ?>"></td>
							<td><div align="right"><strong>TTL:</strong></div></td>
							<td><input class="text" type="text" name="attl" size="25" value="<?php echo func::ent($row["ttl"]); ?>"></td>
						</tr>
						<?php if($isAdmin) { ?>
						<tr>
							<?php
							$res3 = user::get_users();
							?>
							<td><div align="right"><font face="Arial,Helvetica" size="-1"><strong>Owner: </strong></font></div></td>
							<td>
								<select name="owner">
									<?php foreach($res3 as $id3 => $row3 ) { ?>
									<?php if($row3["id"] == $row["owner"]) { ?>
									<option value="<?php echo $row3["id"]; ?>" selected><?php echo $row3["username"]; ?></option>
									<?php } else { ?>
									<option value="<?php echo $row3["id"]; ?>"><?php echo $row3["username"]; ?></option>
									<?php } ?>
									<?php } ?>
								</select>
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<?php } ?>
					</table>

					<input type="hidden" name="serial" value="<?php echo func::ent($row["serial"]); ?>">
					<input type="hidden" name="zone" value="<?php echo func::ent($row["origin"]); ?>">
					<input type="hidden" name="zoneid" value="<?php echo func::ent($row["id"]); ?>">
					<table border="0" cellpadding="0" cellspacing="3">
						<tr>
							<td><strong>Host</strong></td>
							<td><strong>TTL</strong></td>
							<td><strong>Type</strong></td>
							<td><strong>Prio</strong></td>
							<td><strong>Data</strong></td>
							<td><strong>Manage</strong></td>
						</tr>
						<?php foreach($res2 as $rid => $row2) { ?>
						<tr>
							<td>
								<input type="hidden" name="host_id[<?php echo $i; ?>]" value="<?php echo func::ent($row2["id"]); ?>">
								<input class="text" type="text" name="host[<?php echo $i; ?>]" value="<?php echo func::ent($row2["name"]); ?>" size="14">
							</td>
							<td><input class="text" type="text" name="ttl[<?php echo $i; ?>]" size="1" value="<?php echo func::ent($row2["ttl"]); ?>"></td>
							<td><?php echo func::getOptions($row2["type"], $i); ?></td>
							<td><input class="text" type="text" name="pri[<?php echo $i; ?>]" size="1" value="<?php echo func::ent($row2["aux"]); ?>"></td>
							<td><input class="text" type="text" name="destination[<?php echo $i; ?>]" size="14" value="<?php echo func::ent($row2["data"]); ?>"></td>
							<td><center><input type="checkbox" name="delete[<?php echo $i; ?>]" /></center></td>
						</tr>

						<?php $i++; } ?>
						<tr>
							<td colspan="6"><hr size="1" noshade></td>
						</tr>
						<tr>
							<td><input class="text" type="text" name="newhost" size="14"></td>
							<td><input class="text" type="text" name="newttl" size="1" value="<?php echo $conf["minimum_ttl"]; ?>"></td>
							<td><?php echo func::getOptions("A"); ?></td>
							<td><input class="text" type="text" name="newpri" size="1" value="0"></td>
							<td><input class="text" type="text" name="newdestination" size="14"></td>
							<td>&nbsp;</td>
						</tr>
						<tr class="odd">
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>
								<input type="hidden" name="total" value="<?php echo $i; ?>">
								<input name="Submit" type="submit" value="Save">
							</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
					</table>
				</form>

				<?php
				$show_list = false;
			} else { echo "No Access"; }
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
				echo '	<strong><a href="?page=zone&act=add">Create a new zone</a></strong><br /><br />'."\n";
			}
			?>
			<table width="100%"  border="0" cellspacing="1" class="jNice">
				<tr>
					<td><strong>Name</strong></td>
					<td><strong>Serial</strong></td>
					<td><strong>Records</strong></td>
					<td><strong>Manage</strong></td>
				</tr>
				<?php
				foreach($zones as $zoneid => $row) {
					?>
					<tr>
						<td class="action"><a class="view" href="?page=zone&id=<?php echo $row["id"]; ?>"><?php echo $row["origin"]; ?></a></td>
						<td class="action"><a class="edit" href="?page=zone&id=<?php echo $row["id"]; ?>"><?php echo $row["serial"]; ?></a></td>
						<td class="action"><a class="edit" href="?page=zone&id=<?php echo $row["id"]; ?>"><?php echo $row["records"]; ?></a></td>
						<?php if($isAdmin){ ?>
						<td class="action"><a class="delete" href="?page=zone&id=<?php echo $row["id"]; ?>&act=del" onClick="return confirm('Do you really want to remove this zone?');">Delete</a></td>
						<?php } else { ?>
						<td>&nbsp;</td>
						<?php } ?>
					</tr>
					<?php
				}
				echo '</table>
				';
			}else{
				echo 'There are currently no zones available. <strong><a href="?page=zone&act=add">Create your first zone</a></strong>';
			}
		}
		?>
	</div>

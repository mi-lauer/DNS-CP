<?php
/* page/zone.php - DNS-WI
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
?>
<h2><a href="?page=home">DNS</a> &raquo; <a href="#" class="active">Zones</a></h2>
<div id="main">
<?php

$show_list = true;
if(isset($_GET["act"]) && $_GET["act"] == "add") {
if(isset($_POST["Submit"])){
	if(isset($_POST['name']) && $_POST['name'] != "") {
		$zone_name = $_POST['name'].".";
		$res = DB::query("SELECT * FROM ".$conf["soa"]." where origin ='".DB::escape($zone_name)."'");
		$row = DB::fetch_array($res);
		if(!empty($row["id"])) {
			echo '<font color="#ff0000">Zone already exists.</font>';

		}else if(empty($_POST['name']) || $_POST['name'] == "." || strlen($_POST['name']) < 2) {
			echo '<font color="#ff0000">Please enter a valid domain name!</font>';

		}else{

			DB::query("INSERT INTO ".$conf["soa"]." (origin, ns, mbox, serial, refresh, retry, expire, minimum, ttl, owner) VALUES ('".DB::escape($zone_name)."', '".DB::escape($conf["soans"])."', '".DB::escape($conf["mbox"])."', '".date("Ymd")."01', '".DB::escape($conf["refresh"])."', '".DB::escape($conf["retry"])."', '".DB::escape($conf["expire"])."', '".DB::escape($conf["minimum_ttl"])."', '".DB::escape($conf["ttl"])."', '".DB::escape($_POST['owner'])."')") or die(DB::error());
			$res = DB::query("SELECT * FROM ".$conf["soa"]." where origin ='".DB::escape($zone_name)."'") or die(DB::error());
			$row = DB::fetch_array($res);

			if(isset($conf["ns"]) && $conf["ns"] != Null){
				foreach($conf["ns"] as $id => $ns) {
					DB::query("INSERT INTO ".$conf["rr"]." (zone, name, type, data, aux, ttl) VALUES ('".$row['id']."', '".DB::escape($zone_name)."', 'NS', '".DB::escape($ns)."', '0', '".DB::escape($conf["minimum_ttl"])."');") or die(DB::error());
				}
			}
			if(isset($conf["a"]) && $conf["a"] != Null){
				DB::query("INSERT INTO ".$conf["rr"]." (zone, name, type, data, aux, ttl) VALUES ('".$row['id']."', '".DB::escape($zone_name)."', 'A', '".DB::escape($conf["a"])."', '0', '".DB::escape($conf["minimum_ttl"])."');") or die(DB::error());
				DB::query("INSERT INTO ".$conf["rr"]." (zone, name, type, data, aux, ttl) VALUES ('".$row['id']."', '*', 'A', '".DB::escape($conf["a"])."', '0', '".DB::escape($conf["minimum_ttl"])."');") or die(DB::error());
			}
			if(isset($conf["aaaa"]) && $conf["aaaa"] != Null){
				DB::query("INSERT INTO ".$conf["rr"]." (zone, name, type, data, aux, ttl) VALUES ('".$row['id']."', '".DB::escape($zone_name)."', 'AAAA', '".DB::escape($conf["aaaa"])."', '0', '".DB::escape($conf["minimum_ttl"])."');") or die(DB::error());
			}
			if(isset($conf["txt"]) && $conf["txt"] != Null){
				DB::query("INSERT INTO ".$conf["rr"]." (zone, name, type, data, aux, ttl) VALUES ('".$row['id']."', '".DB::escape($zone_name)."', 'TXT', '".DB::escape($conf["txt"])."', '0', '".DB::escape($conf["minimum_ttl"])."');") or die(DB::error());
			}
			DB::query("INSERT INTO ".$conf["rr"]." (zone, name, type, data, aux, ttl) VALUES ('".$row['id']."', '".DB::escape($zone_name)."', 'MX', 'mail.".DB::escape($zone_name)."', '10', '".DB::escape($conf["minimum_ttl"])."');") or die(DB::error());
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
				$res3 = DB::query("SELECT * FROM ".$conf["users"]." ORDER BY username ASC") or die(DB::error());
				while ($row3 = DB::fetch_array($res3)) { ?>
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
	if(isset($_GET["act"]) && $_GET["act"] == "del" && func::isAdmin()) {
		DB::query("DELETE FROM ".$conf["soa"]." WHERE id = '".DB::escape($_GET["id"])."'") or die(DB::error());
		DB::query("DELETE FROM ".$conf["rr"]." WHERE zone = '".DB::escape($_GET["id"])."'") or die(DB::error());
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
			DB::query("UPDATE ".$conf["rr"]." SET name = '".DB::escape($_POST['host'][$x])."', type = '".DB::escape($_POST['type'][$x])."', aux = ".DB::escape($_POST['pri'][$x]).", data = '".DB::escape($_POST['destination'][$x])."', ttl = '".DB::escape($_POST['ttl'][$x])."' WHERE id = '".DB::escape($_POST['host_id'][$x])."' AND zone = '".DB::escape($_GET['id'])."'") or die(DB::error());
			
			if(isset($_POST['delete'][$x])) {
				DB::query("DELETE FROM ".$conf["rr"]." WHERE id = '".DB::escape($_POST['host_id'][$x])."' AND zone = '".DB::escape($_GET['id'])."'") or die(DB::error());
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
			DB::query("INSERT INTO ".$conf["rr"]." (id, zone, name, type, data, aux, ttl) VALUES (NULL, '".DB::escape($_GET['id'])."', '".DB::escape($_POST['newhost'])."', '".DB::escape($_POST['newtype'])."', '".DB::escape($_POST['newdestination'])."', '".DB::escape($_POST['newpri'])."', '".DB::escape($_POST['newttl'])."')") or die(DB::error());
		}
		$old_serial = $_POST['serial'];
		if(substr($old_serial, 0, -2) == date("Ymd")) {
			$serial = $old_serial + 1;
		} else {
			$serial = date("Ymd")."01";
		}
		if(func::isAdmin()) {
			DB::query("UPDATE ".$conf["soa"]." SET refresh = " . DB::escape($_POST['refresh']) . ", retry = " . DB::escape($_POST['retry']) . ", expire = " . DB::escape($_POST['expire']) . ", ttl = " . DB::escape($_POST['attl']) . ", owner = '" . DB::escape($_POST['owner']) . "', serial = '".DB::escape($serial)."' WHERE id = " . DB::escape($_GET['id'])) or die(DB::error());
		} else {
			DB::query("UPDATE ".$conf["soa"]." SET refresh = " . DB::escape($_POST['refresh']) . ", retry = " . DB::escape($_POST['retry']) . ", expire = " . DB::escape($_POST['expire']) . ", ttl = " . DB::escape($_POST['attl']) . ", serial = '".DB::escape($serial)."' WHERE id = " . DB::escape($_GET['id'])) or die(DB::error());
		}
		echo '<font color="#008000">Done</font><br /><br />';
	}

if(func::isAdmin()){
	$res = DB::query("SELECT * FROM ".$conf["soa"]." where id ='".DB::escape($_GET["id"])."'") or die(DB::error());
	$res2 = DB::query("SELECT * FROM ".$conf["rr"]." where zone ='".DB::escape($_GET["id"])."' ORDER BY type ASC") or die(DB::error());
} else {
	$res = DB::query("SELECT * FROM ".$conf["soa"]." where id ='".DB::escape($_GET["id"])."' and owner = '".DB::escape($_SESSION['userid'])."'") or die(DB::error());
	$res2 = DB::query("SELECT * FROM ".$conf["rr"]." where zone ='".DB::escape($_GET["id"])."' ORDER BY type ASC") or die(DB::error());
}

$row = DB::fetch_array($res);
if($row["owner"] == $_SESSION['userid'] OR func::isAdmin()) {
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
<?php if(func::isAdmin()) { ?>
	<tr>
<?php
$res3 = DB::query("SELECT * FROM ".$conf["users"]." ORDER BY username ASC") or die(DB::error());
?>
    <td><div align="right"><font face="Arial,Helvetica" size="-1"><strong>Owner: </strong></font></div></td>
    <td>
		<select name="owner">
		<?php while ($row3 = DB::fetch_array($res3)) { ?>
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
<?php while ($row2 = DB::fetch_array($res2)) { ?>
	<tr>
		<td>
			<input type="hidden" name="host_id[<?php echo $i; ?>]" value="<?php echo func::ent($row2["id"]); ?>">
			<input class="text" type="text" name="host[<?php echo $i; ?>]" value="<?php echo func::ent($row2["name"]); ?>" size="14">
		</td>
		<td><input class="text" type="text" name="ttl[<?php echo $i; ?>]" size="1" value="<?php echo func::ent($row2["ttl"]); ?>"></td>
		<td><?php echo func::getOptions($row2["type"], $i); ?></td>
		<td><input class="text" type="text" name="pri[<?php echo $i; ?>]" size="1" value="<?php echo func::ent($row2["aux"]); ?>"></td>
		<td><input class="text" type="text" name="destination[<?php echo $i; ?>]" size="14" value="<?php echo func::ent(DB::unescape($row2["data"])); ?>"></td>
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
} else { echo "No Access"; }
} 
}

if($show_list) {
	if(func::isAdmin()){
		$res = DB::query("SELECT * FROM ".$conf["soa"]." ORDER BY origin ASC") or die(DB::error());
	 } else {
		$res = DB::query("SELECT * FROM ".$conf["soa"]." WHERE owner = '".DB::escape($_SESSION['userid'])."' ORDER BY origin ASC") or die(DB::error());
	}

	$zones  = array();
	$zoneid = 0;
	while($row = DB::fetch_array($res)) {
		$zoneid++;
		$zones[$zoneid] = $row;
		$zones[$zoneid]["records"] = DB::num_rows(DB::query("SELECT * FROM ".$conf["rr"]." WHERE zone = '".$row["id"]."'")) or die(DB::error());
	}

	if($zoneid > 0) {
	if(func::isAdmin()){
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
		<td class="action"><a class="view" href="?page=zone&id=<?php echo $row["id"]; ?>"><?php echo substr($row["origin"], 0, strlen($row["origin"])-1); ?></a></td>
		<td class="action"><a class="edit" href="?page=zone&id=<?php echo $row["id"]; ?>"><?php echo $row["serial"]; ?></a></td>
		<td class="action"><a class="edit" href="?page=zone&id=<?php echo $row["id"]; ?>"><?php echo $row["records"]; ?></a></td>
<?php if(func::isAdmin()){ ?>
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

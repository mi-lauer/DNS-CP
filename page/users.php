<?php
/* page/users.php - DNS-WI
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
?>
<h2><a href="?page=main">DNS</a> &raquo; <a href="#" class="active">Users</a></h2>
<div id="main">
<?php
if(func::isAdmin()){
if(isset($_GET["act"]) && $_GET["act"] == "add") {
if(isset($_POST["Submit"])) {
	if($_POST["password_one"] == $_POST["confirm_password"]) {
		DB::query("INSERT INTO ".$conf["users"]." (username, password, admin) VALUES ('".DB::escape($_POST["username_one"])."', '".md5($_POST["confirm_password"])."', '".DB::escape($_POST["admin"])."');") or die(DB::error());
		echo '<font color="#008000">User sucessful added</font>';
	} else {
		echo '<font color="#ff0000">The data you have entered are invalid.</font>';
	}
}
?>

<form name="form1" method="post" action="?page=users&act=add" class="jNice">
	<table width="320"  border="0">
		<tr>
			<td><div align="right"><strong>Username:</strong></div></td>
			<td><input class="text" type="text" name="username_one" ></td>
		</tr>
		<tr>
			<td><div align="right"><strong>Administrator:</strong></div></td>
			<td>
				<label><input type="radio" name="admin" value="1" />yes</label> 
				<label><input type="radio" name="admin" value="0" checked="checked" />no</label>
			</td>
		</tr>
		<tr>
			<td><div align="right"><strong>New password:</strong></div></td>
			<td><input class="text" type="password" name="password_one" ></td>
		</tr>
		<tr>
			<td><div align="right"><strong>Confirm new password:</strong></div></td>
			<td><input class="text" type="password" name="confirm_password" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr class="odd">
			<td>&nbsp;</td>
			<td><input name="Submit" type="submit" value="Save"></td>
		</tr>
	</table>
</form>

<?php
}elseif(isset($_GET["id"])){
	if(isset($_GET["act"]) && $_GET["act"] == "del") {
		DB::query("DELETE FROM ".$conf["users"]." WHERE id = '".DB::escape($_GET["id"])."'") or die(DB::error());
		DB::query("UPDATE ".$conf["soa"]." SET owner = '1' WHERE owner = '".DB::escape($_GET["id"])."'") or die(DB::error());
		echo '<font color="#008000">User sucessful deleted</font>';
	} else {
	if(isset($_POST["Submit"])) {
		if(isset($_POST["password_one"]) && isset($_POST["confirm_password"]) && $_POST["password_one"] != "" && $_POST["confirm_password"] != ""){
			if($_POST["password_one"] == $_POST["confirm_password"]) {
				DB::query("UPDATE ".$conf["users"]." SET password = '".md5($_POST["confirm_password"])."', admin = '".DB::escape($_POST["admin"])."' WHERE id = ".DB::escape($_GET["id"])) or die(DB::error());
				echo '<font color="#008000">Password changed successfully.</font>';
			} else {
				echo '<font color="#ff0000">The data you have entered are invalid.</font>';
			}
		} elseif(isset($_POST["admin"])) {
			DB::query("UPDATE ".$conf["users"]." SET admin = '".DB::escape($_POST["admin"])."' WHERE id = ".DB::escape($_GET["id"])) or die(DB::error());
			echo '<font color="#008000">Status changed sucessfully.</font>';
		}
	}
$res = DB::query("SELECT * FROM ".$conf["users"]." WHERE id = ".DB::escape($_GET["id"])) or die(DB::error());
$row = DB::fetch_array($res);
?>

<form name="form1" method="post" action="?page=users&id=<?php echo $_GET["id"];?>" class="jNice">
	<table width="320"  border="0">
		<tr>
			<td><div align="right"><strong>Username:</strong></div></td>
			<td><?php echo $row["username"]; ?></td>
		</tr>
		<tr>
			<td><div align="right"><strong>Administrator:</strong></div></td>
			<td>
			<?php if($row["admin"] == 1) { ?>
				<label><input type="radio" name="admin" value="1" checked="checked" />yes</label> 
				<label><input type="radio" name="admin" value="0" />no</label>
			<?php } else { ?>
				<label><input type="radio" name="admin" value="1" />yes</label> 
				<label><input type="radio" name="admin" value="0" checked="checked" />no</label>
			<?php } ?>
			</td>
		</tr>
		<tr>
			<td><div align="right"><strong>New password:</strong></div></td>
			<td><input class="text" type="password" name="password_one" ></td>
		</tr>
		<tr>
			<td><div align="right"><strong>Confirm new password:</strong></div></td>
			<td><input class="text" type="password" name="confirm_password" ></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr class="odd">
			<td>&nbsp;</td>
			<td><input name="Submit" type="submit" value="Save"></td>
		</tr>
	</table>
</form>
<?php
$res2 = DB::query("SELECT * FROM ".$conf["soa"]." where owner = '".DB::escape($row["id"])."' ORDER BY origin ASC") or die(DB::error());
?>
<strong>Zones owned by this user:</strong>
<table width="100%"  border="0" cellspacing="1">
	<tr>
		<td><strong>Name</strong></td>
		<td><strong>Records</strong></td>
		<td><strong>Serial</strong></td>
	</tr>
<?php 
while ($row2 = DB::fetch_array($res2)) { 
$records = DB::num_rows(DB::query("SELECT * FROM ".$conf["rr"]." WHERE zone = '".$row2["id"]."'")) or die(DB::error());
?>
	<tr>
		<td class="action"><a class="view" href="?page=zone&id=<?php echo $row2["id"]; ?>"><?php echo $row2["origin"]; ?></a></td>
		<td class="action"><a class="view" href="?page=zone&id=<?php echo $row2["id"]; ?>"><?php echo $records; ?></a></td>
		<td class="action"><a class="edit" href="?page=zone&id=<?php echo $row2["id"]; ?>"><?php echo $row2["serial"]; ?></a></td>
	</tr>
<?php } ?>
</table>
<?php
}
} else {
$res = DB::query("SELECT * FROM ".$conf["users"]." ORDER BY username ASC") or die(DB::error());
?>
<strong><a href="?page=users&act=add">Add a new user</a></strong>
<table width="100%"  border="0" cellspacing="1">
	<tr>
		<td><strong>Username</strong></td>
		<td><strong>Administrator</strong></td>
		<td><strong>Zones</strong></td>
		<td><strong>Delete</strong></td>
	</tr>
<?php while ($row = DB::fetch_array($res)) { ?>
	<tr>
		<td class="action"><a class="view" href="?page=users&id=<?php echo $row["id"]; ?>"><?php echo $row["username"]; ?></a></td>
		<td class="action"><a class="edit" href="?page=users&id=<?php echo $row["id"]; ?>"><?php if($row["admin"] == 1) { echo "yes"; } else { echo "no"; } ?></a></td>
		<td class="action">
			<a class="edit" href="?page=users&id=<?php echo $row["id"]; ?>">
		<?php
			$zone = DB::query("SELECT * FROM ".$conf["soa"]." WHERE owner = '".DB::escape($row['id'])."'") or die(DB::error());
			echo DB::num_rows($zone); 
		?>
			</a>
		</td>
		<td class="action"><a class="delete" href="?page=users&id=<?php echo $row["id"]; ?>&act=del" onClick="return confirm('really??')">Delete</a></td>
	</tr>
<?php } ?>
</table>
<?php } ?>
<?php } else { ?>
No Access
<?php } ?>
</div>

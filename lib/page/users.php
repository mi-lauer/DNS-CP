<?php
/* lib/page/users.php - DNS-CP
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
<h2><a href="?page=home">DNS</a> &raquo; <a href="#" class="active">Users</a></h2>
<div id="main">
<?php
if(user::isAdmin()){
if(isset($_GET["act"]) && $_GET["act"] == "add") {
if(isset($_POST["Submit"])) {
	echo user::add($_POST["username_one"], $_POST["password_one"], $_POST["confirm_password"], $_POST["admin"]);
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
			<td><div align="right"><strong>password:</strong></div></td>
			<td><input class="text" type="password" name="password_one" ></td>
		</tr>
		<tr>
			<td><div align="right"><strong>Confirm password:</strong></div></td>
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
		if($_GET['id'] != 1) {
			echo user::del($_GET['id']);
		}
	} else {
	if(isset($_POST["Submit"])) {
		if(isset($_POST["password_one"]) && isset($_POST["confirm_password"]) && $_POST["password_one"] != "" && $_POST["confirm_password"] != ""){
			if($_GET['id'] != 1) {
				echo user::change("chpw", $_GET['id'], $_POST["admin"], $_POST["password_one"], $_POST["confirm_password"]);
			} else {
				echo user::change("chpw", $_GET['id'], 1, $_POST["password_one"], $_POST["confirm_password"]);
			}
		} elseif(isset($_POST["admin"])) {
			if($_GET['id'] != 1) {
				echo user::change("chad", $_GET['id'], $_POST["admin"]);
			}
		}
	}
$res = DB::query("SELECT * FROM ".$conf["users"]." WHERE id = :id", array(":id" => $_GET["id"])) or die(DB::error());
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
			<?php if($_GET['id'] == 1) { echo "yes"; } elseif($row["admin"] == 1) { ?>
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
$zones = server::get_all_zones($_GET["id"]);
?>
<strong>Zones owned by this user:</strong>
<table width="100%"  border="0" cellspacing="1">
	<tr>
		<td><strong>Name</strong></td>
		<td><strong>Records</strong></td>
		<td><strong>Serial</strong></td>
	</tr>
<?php
foreach($zones as $id => $row2) {
$records = count(server::get_all_records($row2["id"]));
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
<strong><a href="?page=users&act=add">Add a new user</a></strong><br /><br />
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
			echo count(server::get_all_zones($row["id"])); 
		?>
			</a>
		</td>
		<td class="action"><a class="delete" href="?page=users&id=<?php echo $row["id"]; ?>&act=del" onClick="return confirm('Are you really sure that you want delete this user?')">Delete</a></td>
	</tr>
<?php } ?>
</table>
<?php } ?>
<?php } else { ?>
No Access
<?php } ?>
</div>

<?php
/* lib/page/UsersPage.class.php - DNS-WI
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
class UsersPage extends AbstractPage {
/*will be changes later*/
public function show() {
	global $conf;
$ret = '
<h2><a href="?page=home">DNS</a> &raquo; <a href="#" class="active">Users</a></h2>
<div id="main">
';
if(user::isAdmin()){
if(isset($_GET["act"]) && $_GET["act"] == "add") {
if(isset($_POST["Submit"])) {
	$ret .= user::add($_POST["username_one"], $_POST["password_one"], $_POST["confirm_password"], $_POST["admin"]);
}
$ret .= '

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

';
}elseif(isset($_GET["id"])){
	if(isset($_GET["act"]) && $_GET["act"] == "del") {
		$ret .= user::del($_GET['id']);
	} else {
	if(isset($_POST["Submit"])) {
		if(isset($_POST["password_one"]) && isset($_POST["confirm_password"]) && $_POST["password_one"] != "" && $_POST["confirm_password"] != ""){
			$ret .= user::change("chpw", $_GET['id'], $_POST["admin"], $_POST["password_one"], $_POST["confirm_password"]);
		} elseif(isset($_POST["admin"])) {
			$ret .= user::change("chad", $_GET['id'], $_POST["admin"]);
		}
	}
$res = DB::query("SELECT * FROM ".$conf["users"]." WHERE id = ".DB::escape($_GET["id"])) or die(DB::error());
$row = DB::fetch_array($res);
$ret .= '

<form name="form1" method="post" action="?page=users&id='.$_GET["id"].'?>" class="jNice">
	<table width="320"  border="0">
		<tr>
			<td><div align="right"><strong>Username:</strong></div></td>
			<td>'.$row["username"].'</td>
		</tr>
		<tr>
			<td><div align="right"><strong>Administrator:</strong></div></td>
			<td>';
			if($row["admin"] == 1) {
				$ret .= '<label><input type="radio" name="admin" value="1" checked="checked" />yes</label>';
				$ret .= '<label><input type="radio" name="admin" value="0" />no</label>';
			} else {
				$ret .= '<label><input type="radio" name="admin" value="1" />yes</label>';
				$ret .= '<label><input type="radio" name="admin" value="0" checked="checked" />no</label>';
			}
			$ret .= '</td>
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
';
$res2 = DB::query("SELECT * FROM ".$conf["soa"]." where owner = '".DB::escape($row["id"])."' ORDER BY origin ASC") or die(DB::error());
$ret .= '
<strong>Zones owned by this user:</strong>
<table width="100%"  border="0" cellspacing="1">
	<tr>
		<td><strong>Name</strong></td>
		<td><strong>Records</strong></td>
		<td><strong>Serial</strong></td>
	</tr>
';
while ($row2 = DB::fetch_array($res2)) { 
$records = DB::num_rows(DB::query("SELECT * FROM ".$conf["rr"]." WHERE zone = '".$row2["id"]."'")) or die(DB::error());
$ret .='
	<tr>
		<td class="action"><a class="view" href="?page=zone&id='.$row2["id"].'">'.$row2["origin"].'</a></td>
		<td class="action"><a class="view" href="?page=zone&id='.$row2["id"].'">'.$records.'</a></td>
		<td class="action"><a class="edit" href="?page=zone&id='.$row2["id"].'">'.$row2["serial"].'</a></td>
	</tr>
'; }
$ret .= '</table>';
}
} else {
$res = DB::query("SELECT * FROM ".$conf["users"]." ORDER BY username ASC") or die(DB::error());
$ret .= '
<strong><a href="?page=users&act=add">Add a new user</a></strong><br /><br />
<table width="100%"  border="0" cellspacing="1">
	<tr>
		<td><strong>Username</strong></td>
		<td><strong>Administrator</strong></td>
		<td><strong>Zones</strong></td>
		<td><strong>Delete</strong></td>
	</tr>
'; while ($row = DB::fetch_array($res)) { 
	$ret .= '<tr>
		<td class="action"><a class="view" href="?page=users&id='.$row["id"].'">'.$row["username"].'</a></td>
		<td class="action"><a class="edit" href="?page=users&id='.$row["id"].'">';
		if($row["admin"] == 1) { $ret .= "yes"; } else { $ret .= "no"; } $ret .= '</a></td>
		<td class="action">
			<a class="edit" href="?page=users&id='.$row["id"].'">
';
			$zone = DB::query("SELECT * FROM ".$conf["soa"]." WHERE owner = '".DB::escape($row['id'])."'") or die(DB::error());
			$ret .= DB::num_rows($zone); 

			$ret .='</a>
		</td>
		<td class="action"><a class="delete" href="?page=users&id='.$row["id"].'&act=del" onClick="return confirm(\'Are you really sure that you want delete this user?\')">Delete</a></td>
	</tr>';
}
$ret .='</table>';
}
} else {
$ret .= 'No Access';
}
$ret .= '</div>';
return $ret;
} } ?>

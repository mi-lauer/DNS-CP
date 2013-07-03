<?php
/* page/chpw.php - myDNS-WI
 * Copyright (C) 2012-2013  Nexus-IRC project
 * http://nexus-irc.de
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
<h2><a href="?page=main">DNS</a> &raquo; <a href="#" class="active">Change password</a></h2>
<div id="main">
<?php
if(isset($_POST["Submit"])){
	$res = DB::query("SELECT * FROM ".$conf["users"]." WHERE username = '".DB::escape($_SESSION['username'])."'") or die(DB::error());
	$row = DB::fetch_array($res);
	if(isset($_POST["password_one"]) && isset($_POST["confirm_password"]) && isset($_POST["password_old"]) && $_POST["password_old"] != "" && $_POST["password_one"] != "" && $_POST["confirm_password"] != ""){
		if($_POST["password_one"] == $_POST["confirm_password"]) {
			if($row["password"] == md5($_POST["password_old"])){
				DB::query("UPDATE ".$conf["users"]." SET password = '".md5($_POST["confirm_password"])."' WHERE username = '".DB::escape($_SESSION['username'])."'") or die(DB::error());
				echo '<font color="#008000">Password changed successfully.</font>';
			} else {
				echo '<font color="#ff0000">The data you have entered are invalid.</font>';
			}
		} else {
			echo '<font color="#ff0000">The data you have entered are invalid.</font>';
		}
	} else {
		echo '<font color="#ff0000">The data you have entered are invalid.</font>';
	}
}
?>
<form name="form1" method="post" action="?page=chpw" class="jNice">
	<table width="320"  border="0">
		<tr>
			<td><div align="right"><strong>Old password:</strong></div></td>
			<td><input class="text" type="password" name="password_old" ></td>
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
			<td><input name="Submit" type="submit" class="a" value="Save"></td>
		</tr>
	</table>
</form>
</div>

<?php
/* lib/page/users.php - DNS-CP
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
$data = Null;
if(user::isAdmin()){
if(isset($_GET["act"]) && $_GET["act"] == "add") {
if(isset($_POST["Submit"])) {
	$data = user::add_user($_POST["username_one"], $_POST["password_one"], $_POST["confirm_password"], $_POST["admin"]);
}

tpl::show("user_add", array(
		"name" => "Users",
		"data" => $data,
		"title" => $title,
		"login" => $login,
		"menu" => $tmenu,
		"build" => $conf["build"],
		"version" => $conf["version"]
		));

}elseif(isset($_GET["id"])){
	if(isset($_GET["act"]) && $_GET["act"] == "del") {
		if($_GET['id'] != 1) {
			$data = user::del_user($_GET['id']);
		}
		header('Location: ?page=users');
	} else {
	if(isset($_POST["Submit"])) {
		if(isset($_POST["password_one"]) && isset($_POST["confirm_password"]) && $_POST["password_one"] != "" && $_POST["confirm_password"] != ""){
			if($_GET['id'] != 1) {
				$data = user::set_user("chpw", $_GET['id'], $_POST["admin"], $_POST["password_one"], $_POST["confirm_password"]);
			} else {
				$data = user::set_user("chpw", $_GET['id'], 1, $_POST["password_one"], $_POST["confirm_password"]);
			}
		} elseif(isset($_POST["admin"])) {
			if($_GET['id'] != 1) {
				$data = user::set_user("chad", $_GET['id'], $_POST["admin"]);
			}
		}
	}
$row = user::get_user($_GET["id"]);
$zones = server::get_all_zones($_GET["id"]);
$records = array();
foreach ($zones as $id => $row2) {
	$records[$row2["id"]] = count(server::get_all_records($row2["id"]));
}
tpl::show("user_edit", array(
		"name" => "Users",
		"data" => $data,
		"row" => $row,
		"id" => $_GET["id"],
		"zones" => $zones,
		"records" => $records,
		"title" => $title,
		"login" => $login,
		"menu" => $tmenu,
		"build" => $conf["build"],
		"version" => $conf["version"]
		));

}
} else {
$res = user::get_users();
$zones = array();
foreach ($res as $id => $row2) {
	$zones[$row2["id"]] = count(server::get_all_zones($row2["id"]));
}
tpl::show("user_list", array(
		"name" => "Users",
		"data" => $data,
		"res" => $res,
		"zones" => $zones,
		"title" => $title,
		"login" => $login,
		"menu" => $tmenu,
		"build" => $conf["build"],
		"version" => $conf["version"]
		));

} ?>
<?php } else { ?>
No Access
<?php } ?>

<?php
/* lib/page/settings.php - DNS-CP
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

if(isset($_POST["Submit"])){
	$error = user::change_password($_SESSION['userid'], $_POST["password_old"], $_POST["password_one"], $_POST["confirm_password"]);
} else { $error = ""; }

template::show("settings", array(
	"_name" => "Settings",
	"_error" => $error
	));
?>

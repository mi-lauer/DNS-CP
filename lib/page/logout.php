<?php
/* lib/page/logout.php - DNS-WI
 * Copyright (C) 2013  OwnDNS project
 * http://owndns.me/
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
use DNS\system\template;
use DNS\user\user;

if(!defined("IN_PAGE")) { die("no direct access allowed!"); }
if(user::isLoggedIn()) {
	$error = user::logout();
}else{
	$error = 'You are not logged in. <a href="?page=login">Click here</a>.';
}
template::show("logout", array(
		"_name" => "Logout",
		"_error" => $error
		));
?>

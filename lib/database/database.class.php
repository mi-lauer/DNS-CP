<?php
/* lib/database/database.class.php - DNS-WI
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
/* Database layout class */
class database {
	private static $conn = NULL;
	public static function connect($host, $user, $pw, $db) { }
	public static function query ($res) { }
	public static function escape ($res) { return $res; }
	public static function fetch_array ($res) { }
	public static function num_rows ($res) { }
	public static function error () { }
	public static function unescape ($data) { return $data; }
}
?>

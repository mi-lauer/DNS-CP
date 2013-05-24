<?php
/* lib/mysql.class.php - myDNS-WI
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
if (!extension_loaded("mysql")) die("Missing <a href=\"http://www.php.net/manual/en/book.mysql.php\">mysql</a> PHP extension."); // check if extension loaded
class DB {
	private static $conn = NULL;
	
	public static function connect($host, $user, $pw, $db) {
		self::$conn = mysql_connect($host, $user, $pw);
		mysql_select_db($db);
	}
	
	public static function query ($res) {
		return mysql_query($res, self::$conn);
	}
	
	public static function escape ($res) {
		return mysql_real_escape_string($res, self::$conn);
	}
	
	public static function fetch_array ($res) {
		return mysql_fetch_array($res);
	}
	
	public static function num_rows ($res) {
		return mysql_num_rows($res);
	}
	
	public static function error () {
		return mysql_error(self::$conn);
	}
	
	public static function unescape ($data) {
		return $data;
	}
}
?>

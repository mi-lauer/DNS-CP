<?php
/* lib/database/pgsql.database.class.php - DNS-WI
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
/* This is the database implementation for PostgreSQL. */
if (!extension_loaded("pgsql")) die("Missing <a href=\"http://www.php.net/manual/en/book.pgsql.php\">pgsql</a> PHP extension."); // check if extension loaded
class DB extends database {
	private static $conn = NULL;
	
	/**
	 * @see database::connect();
	 */
	public static function connect($host, $user, $pw, $db) {
		self::$conn = pg_connect("host=".$host." user=".$user." password=".$pw." dbname=".$db) ;
	}
	
	/**
	 * @see database::query();
	 */
	public static function query ($res) {
		return pg_query(self::$conn, $res);
	}
	
	/**
	 * @see database::escape();
	 */
	public static function escape ($res) {
		return pg_escape_string(self::$conn, $res);
	}
	
	/**
	 * @see database::fetch_array();
	 */
	public static function fetch_array ($res) {
		return pg_fetch_array($res);
	}
	
	/**
	 * @see database::num_rows();
	 */
	public static function num_rows ($res) {
		return pg_num_rows($res);
	}
	
	/**
	 * @see database::error();
	 */
	public static function error () {
		return pg_last_error(self::$conn);
	}
	
	/**
	 * @see database::unescape();
	 */
	public static function unescape ($data) {
		return pg_unescape_bytea($data);
	}
}
?>

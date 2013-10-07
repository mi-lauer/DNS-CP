<?php
/* lib/database/mysqli.database.class.php - DNS-WI
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
/* This is the database implementation for MySQL4.1 or higher using the mysqli extension. */
if (!extension_loaded("mysqli")) die("Missing <a href=\"http://www.php.net/manual/en/book.mysqli.php\">mysqli</a> PHP extension."); // check if extension loaded
class DB extends database {
	private static $conn = NULL;

	/**
	 * @see database::connect();
	 */
	public static function connect($host, $user, $pw, $db) {
		self::$conn = new mysqli($host, $user, $pw, $db);
	}

	/**
	 * @see database::query();
	 */
	public static function query ($res) {
		return self::$conn->query($res);
	}

	/**
	 * @see database::escape();
	 */
	public static function escape ($res) {
		return self::$conn->real_escape_string($res);
	}
	
	/**
	 * @see database::fetch_array();
	 */
	public static function fetch_array ($res) {
		return $res->fetch_array();
	}
	
	/**
	 * @see database::num_rows();
	 */
	public static function num_rows ($res) {
		return $res->num_rows;
	}
	
	/**
	 * @see database::error();
	 */
	public static function error () {
		/* DOES CURRENTLY NOT WORK, NEEDS TO BE FIXED!
		 * ISSUE: Does not respond anything.
		 * (Stricted: i think its a bug un our system when num_rows nothin response then makes or die(DB::error) we check this later)
		 */		
		return self::$conn->error();
	}
}
?>

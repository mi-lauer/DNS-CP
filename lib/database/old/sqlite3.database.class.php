<?php
/* lib/database/sqlite3.database.class.php - DNS-WI
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
/* This is the database implementation for SQLite3. */
if (!extension_loaded("sqlite3")) die("Missing <a href=\"http://www.php.net/manual/en/book.sqlite3.php\">sqlite3</a> PHP extension."); // check if extension loaded
class DB extends database {
	private static $conn = NULL;

	/**
	 * @see database::connect();
	 */
	public static function connect($host, $user, $pw, $db) {
		$dbfile  = "database/".$db.".db";
		$created = false;
		if(!file_exists($dbfile)) {
			$created = true;
		}
		if(!file_exists("database/")) {
			mkdir("database", 0777, true);			
		}
		if(!file_exists($dbfile)) {
			touch($dbfile);
		}
		if(!file_exists("database/.htaccess")) {
			file_put_contents("database/.htaccess", "Deny from all");
		}
		if(is_readable($dbfile) && is_writable($dbfile)) {
			self::$conn  = new SQLite3($dbfile);
			if($created) {
				self::$conn->exec(file_get_contents("lib/database/db.sqlite3.sql"));
			}
		} else { die(/* error message will be added later ;) */); }
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
		return self::$conn->escapeString($res);
	}
	
	/**
	 * @see database::fetch_array();
	 */
	public static function fetch_array ($res) {
		return $res->fetchArray(SQLITE3_ASSOC);
	}
	
	/**
	 * @see database::num_rows();
	 */
	public static function num_rows ($res) {
		$count = 0;
		while ($row = self::fetch_array($res)) { $count++; }
		return $count;
	}
	
	/**
	 * @see database::error();
	 */
	public static function error () {
		return self::$conn->lastErrorMsg();
	}
}
?>

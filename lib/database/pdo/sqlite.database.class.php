<?php
/* lib/database/pdo/sqlite.database.class.php - DNS-WI
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
if (!extension_loaded("pdo")) die("Missing <a href=\"http://www.php.net/manual/en/book.pdo.php\">PDO</a> PHP extension."); // check if extension loaded
if (!extension_loaded("pdo_sqlite")) die("Missing <a href=\"http://php.net/manual/de/ref.pdo-sqlite.php\">pdo_sqlite</a> PHP extension."); // check if extension loaded
class DB extends database {
	private static $conn = NULL;
	private static $err = NULL;

	/**
	 * @see	database::connect();
	 */
	public static function connect($host, $user, $pw, $db) {
		try {
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
			if(file_exists($dbfile) && is_readable($dbfile) && is_writable($dbfile)) {
				self::$conn = new PDO("sqlite:".$dbfile.";", $user, $pw);
				if($created) {
					self::$conn->exec(file_get_contents("lib/database/db.sqlite3.sql"));
				}
			} else { die(/* error message will be added later ;) */); }
		} catch (PDOException $e) {
			self::$err = $e->getMessage();
			return false;
		}
	}
	
	/**
	 * @see	database::close();
	 */
	public static function close () {
		self::$conn = NULL;
	}
	
	/**
	 * @see	database::query();
	 */
	public static function query ($res, $bind = array()) {
		try {
			$query = self::$conn->prepare($res);
			if(is_array($bind) && !empty($bind))
				$query->execute($bind);
			else
				$query->execute();
			return $query;
		} catch (PDOException $e) {
			self::$err = $e->getMessage();
		}
	}

	
	/**
	 * @see	database::fetch_array();
	 */
	public static function fetch_array ($res) {
		try {
			return $res->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			self::$err = $e->getMessage();
		}
	}
	
	/**
	 * @see	database::num_rows();
	 */
	public static function num_rows ($res) {
		try {
			return $res->rowCount();
		} catch (PDOException $e) {
			self::$err = $e->getMessage();
		}
	}
	
	/**
	 * @see	database::error();
	 */
	public static function error () {
		return self::$err;
	}
}
?>

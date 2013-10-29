<?php
/* lib/database/pdo/db.class.php - DNS-CP
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

if (!extension_loaded("pdo")) die("Missing <a href=\"http://www.php.net/manual/en/book.pdo.php\">PDO</a> PHP extension."); // check if extension loaded
class DB {
	private static $conn = NULL;
	private static $err = NULL;

	/**
	 * Connects to SQL Server
	 * 
	 * @return	true/false
	 */
	public static function connect() {
		$conf = system::get_conf();
		$database = system::get_database();
		try {
			switch (strtolower($database["typ"])) {
				case "mysql":
					if (!extension_loaded("pdo_mysql")) die("Missing <a href=\"http://php.net/manual/de/ref.pdo-mysql.php\">pdo_mysql</a> PHP extension."); // check if extension loaded
					if(empty($database["port"])) $database["port"]=3306;
					self::$conn = new PDO("mysql:host=".$database["host"].";port=".$database["port"].";dbname=".$database["db"], $database["user"], $database["pw"]);
					break;
				
				case "pgsql":
					if (!extension_loaded("pdo_pgsql")) die("Missing <a href=\"http://php.net/manual/de/ref.pdo-pgsql.php\">pdo_pgsql</a> PHP extension."); // check if extension loaded
					if(empty($database["port"])) $database["port"]=5432;
					self::$conn = new PDO("pgsql:host=".$database["host"].";port=".$database["port"].";dbname=".$database["db"], $database["user"], $database["pw"]);
					break;
					
				case "sqlite":
					if (!extension_loaded("pdo_sqlite")) die("Missing <a href=\"http://php.net/manual/de/ref.pdo-sqlite.php\">pdo_sqlite</a> PHP extension."); // check if extension loaded	
					$rootdir = dirname(__FILE__)."/../../";
					$dbfile  = $rootdir."database/".$database["db"].".db";
					$created = false;
					if(!file_exists($rootdir."database/")) {
						// try to create the database folder
						@mkdir($rootdir."database", 0777, true);			
					}
					if(!file_exists($dbfile)) {
						// try to create the database file
						if(@touch($dbfile))
							$created = true;
					}
					if(!file_exists($rootdir."database/.htaccess")) {
						// try to create the htaccess file
						@file_put_contents($rootdir."database/.htaccess", "Deny from all");
					}
					if(file_exists($dbfile) && is_readable($dbfile) && is_writable($dbfile)) {
						self::$conn = new PDO("sqlite:".$dbfile, $database["user"], $database["pw"]);
						if($created)
							self::$conn->exec(file_get_contents($rootdir."sql/".$conf["server"]."/sqlite.sql"));
					} else {
						self::$err = "cant crate the sqlite database";
						return false;
					}
					break;
					
				default:
					self::$err = "not supported database typ";
					return false;
					break;
			}
			return true;
		} catch (PDOException $e) {
			self::$err = $e->getMessage();
			return false;
		}
	}
	
	/*
	 * close the database connection
	 */
	public static function close () {
		self::$conn = NULL;
	}
	
	/**
	 * Sends a database query to SQL server.
	 *
	 * @param	string		$res 		a database query
	 * @param	array		$bind 		
	 * @return 	integer					id of the query result
	 */
	public static function query ($res, $bind = array()) {
		try {
			$query = Null;
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
	 * Gets a row from SQL database query result.
	 *
	 * @param	string		$res		a database query
	 * @return 				array		a row from result
	 */
	public static function fetch_array ($res) {
		try {
			return $res->fetch(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			self::$err = $e->getMessage();
		}
	}
	
	/**
	 * return the last insert id
	 */
	public static function last_id () {
		return self::$conn->lastInsertId();
	}
	
	/**
	 * Returns SQL error number for last error.
	 *
	 * @return 	integer		MySQL error number
	 */
	public static function error () {
		return self::$err;
	}
}
?>

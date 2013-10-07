<?php
/* lib/database/mysql.pdo.database.class.php - DNS-WI
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
/* This is the database implementation for MySQL4.1 or higher using the mysql extension. */
if (!extension_loaded("pdo")) die("Missing <a href=\"http://www.php.net/manual/en/book.pdo.php\">PDO</a> PHP extension."); // check if extension loaded
if (!extension_loaded("pdo_mysql")) die("Missing <a href=\"http://php.net/manual/de/ref.pdo-mysql.php\">pdo_mysql</a> PHP extension."); // check if extension loaded
class DB extends pdo_database {
	private static $conn = NULL;

	/**
	 * @see	pdo_database::connect();
	 */
	public static function connect($host, $user, $pw, $db) {
		self::$conn = new PDO("mysql:host=".$host.";dbname=".$db, $user, $pw);
	}
	
	/**
	 * @see	pdo_database::close();
	 */
	public static function close () {
		self::$conn = NULL;
	}
	
	/**
	 * @see	pdo_database::query();
	 */
	public static function query ($res, $bind = array()) {
		$query = self::$conn->prepare($res);
		if(is_array($bind) && !empty($bind))
			return $query->execute($bind);
		else
			return $query->execute();
		
	}

	
	/**
	 * @see	pdo_database::fetch_array();
	 */
	public static function fetch_array ($res) {
		return $res->fetchAll(PDO::FETCH_ASSOC);
	}
	
	/**
	 * @see	pdo_database::num_rows();
	 */
	public static function num_rows ($res) {
		return $res->rowCount();
	}
	
	/**
	 * @see	pdo_database::error();
	 */
	public static function error () {
		$return = "<pre>";
		$return .= print_r(self::$conn->errorInfo());
		$return .= "</pre>";
		return $return;
	}
}
?>

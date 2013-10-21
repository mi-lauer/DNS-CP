<?php
/* lib/system/system.class.php - DNS-CP
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

class system {
	private static $conf = array();
	private static $database = array();
	
	/*
	 * set the config array
	 *
	 * @param	array	$conf
	 */
	public static function set_conf ($conf) {
		self::$conf = $conf;
	}
	
	/*
	 * set the database array
	 *
	 * @param	array	$database
	 */
	public static function set_database ($database) {
		self::$database = $database;
	}
	
	/*
	 * get the config array
	 *
	 * @return	array
	 */
	public static function get_conf () {
		return self::$conf;
	}
	
	/*
	 * get the darabase array
	 *
	 * @return	array
	 */
	public static function get_database() {
		return self::$database;
	}
}
?>

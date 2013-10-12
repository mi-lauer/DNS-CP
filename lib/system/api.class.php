<?php
/* lib/system/api.class.php - DNS-WI
 * Copyright (C) 2013  OWNDNS project
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

class API {
	/**
	 * login a user
	 *
	 * @param		string		$key
	 * @return		string
	 */
	public static function login ($key) {
		global $conf;
		if($key == $conf['apikey'])
			return true;
		else
			return false;
	}
	
	/* RECORD */
	public static function get_record () { }
	public static function add_record () { }
	public static function del_record () { }
	public static function set_record () { }
	
	/* SOA */
	public static function get_soa () { }
	public static function add_soa () { }
	public static function del_soa () { }
	public static function set_soa () { }
	
	/* SOA */
	public static function get_zone () { }
	public static function add_zone () { }
	public static function del_zone () { }
	public static function set_zone () { }
	
	/* User */
	public static function get_user () { }
	public static function add_user () { }
	public static function del_user () { }
	public static function set_user () { }
}
?>
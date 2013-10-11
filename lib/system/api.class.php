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
	 * @param		string		$user
	 * @param		string		$pass
	 * @return		string
	 */
	public static function login ($user, $pass) {
		return false;
	}
	
	/**
	 * get dns data from domain
	 *
	 * @param	string	$domain
	 * @return	array
	 */
	public static function get_data ($domain) {
		return json_encode(array("status" => "404"));
	}
	
	/**
	 * add dns data to domain
	 *
	 * @param	string	$domain
	 * @param	array	$data
	 * @return	array
	 */
	public static function add_data ($domain, $data) {
		return json_encode(array("status" => "404"));
	}
	
	/**
	 * del dns data to domain
	 *
	 * @param	string	$domain
	 * @param	array	$data
	 * @return	array
	 */
	public static function del_data ($domain, $data) {
		return json_encode(array("status" => "404"));
	}
	
	/**
	 * set dns data to domain
	 *
	 * @param	string	$domain
	 * @param	array	$data
	 * @return	array
	 */
	public static function set_data ($domain, $data) {
		return json_encode(array("status" => "404"));
	}
}
?>
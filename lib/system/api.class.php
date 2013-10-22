<?php
/* lib/system/api.class.php - DNS-CP
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

class API {
	/**
	 * login a user
	 *
	 * @param		string		$key
	 * @return		string
	 */
	public static function login ($key) {
		$conf = system::get_conf();
		if($key == $conf['apikey'])
			return true;
		else
			return false;
	}
	
	/* RECORD */
	public static function add_record ($domain, $record) {
		$record = unserialize(base64_decode($record));
		$ret = array();
		$ret['status'] = "200";
		$ret['data'] = server::add_record($domain, $record);
		echo json_encode($ret);
	}
	
	public static function del_record ($domain, $record) {
		$record = unserialize(base64_decode($record));
		$ret = array();
		$ret['status'] = "200";
		$ret['data'] = server::del_record($domain, $record);
		echo json_encode($ret);
	}
	
	public static function set_record ($domain, $record) {
		$record = unserialize(base64_decode($record));
		$ret = array();
		$ret['status'] = "200";
		$ret['data'] = server::set_record($domain, $record);
		echo json_encode($ret);
	}
	
	/* ZONE */	
	public static function add_zone ($domain) {
		$ret = array();
		$ret['status'] = "200";
		$ret['data'] = server::add_zone($domain);
		echo json_encode($ret);
	}
	
	public static function del_zone ($domain) {
		$ret = array();
		$ret['status'] = "200";
		$ret['data'] = server::del_zone($domain);
		echo json_encode($ret);
	}
	
	public static function set_zone ($domain, $data) {
		$data = unserialize(base64_decode($data));
		$ret = array();
		$ret['status'] = "200";
		$ret['data'] = server::set_zone($domain, $data);
		echo json_encode($ret);
	}
}
?>
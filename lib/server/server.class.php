<?php
/* lib/server/server.class.php - DNS-CP
 * Copyright (C) 2013  CNS-CP project
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

class dns_server {
	/* RECORD */
	public static function get_record ($domain, $record) {
		global $conf;
		if($conf['useremoteapi']) {
			foreach($conf['api'] as $id => $api) {
				APIClient::connect($api['url']);
				$post = array("key" => $api['key']);
				APIClient::sendPost($post);
			}
		}
	}
	public static function add_record ($domain, $record) {
		global $conf;
		if($conf['useremoteapi']) {
			foreach($conf['api'] as $id => $api) {
				APIClient::connect($api['url']);
				$post = array("key" => $api['key']);
				APIClient::sendPost($post);
			}
		}
	}
	public static function del_record ($domain, $record) {
		global $conf;
		if($conf['useremoteapi']) {
			foreach($conf['api'] as $id => $api) {
				APIClient::connect($api['url']);
				$post = array("key" => $api['key']);
				APIClient::sendPost($post);
			}
		}
	}
	public static function set_record ($domain, $record) {
		global $conf;
		if($conf['useremoteapi']) {
			foreach($conf['api'] as $id => $api) {
				APIClient::connect($api['url']);
				$post = array("key" => $api['key']);
				APIClient::sendPost($post);
			}
		}
	}

	/* ZONE */
	public static function get_zone ($domain, $owner = Null, $api = false) {
		global $conf;
		if($conf['useremoteapi']) {
			foreach($conf['api'] as $id => $api) {
				APIClient::connect($api['url']);
				$post = array("key" => $api['key']);
				APIClient::sendPost($post);
			}
		}
	}
	public static function add_zone ($domain, $owner = Null) {
		global $conf;
		if($conf['useremoteapi']) {
			foreach($conf['api'] as $id => $api) {
				APIClient::connect($api['url']);
				$post = array("key" => $api['key']);
				APIClient::sendPost($post);
			}
		}
	}
	public static function del_zone ($domain, $api = false) {
		global $conf;
		if($conf['useremoteapi']) {
			foreach($conf['api'] as $id => $api) {
				APIClient::connect($api['url']);
				$post = array("key" => $api['key']);
				APIClient::sendPost($post);
			}
		}
	}
	public static function set_zone ($domain, $data, $api = false) {
		global $conf;
		if($conf['useremoteapi']) {
			foreach($conf['api'] as $id => $api) {
				APIClient::connect($api['url']);
				$post = array("key" => $api['key']);
				APIClient::sendPost($post);
			}
		}
	}
}
?>
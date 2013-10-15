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
				$post = array("key" => $api['key'], "action" => "get", "data" => "record", "domain" => $domain, "get" => $record);
				APIClient::sendPost($post);
			}
		}
	}
	public static function add_record ($domain, $record) {
		global $conf;
		if($conf['useremoteapi']) {
			foreach($conf['api'] as $id => $api) {
				APIClient::connect($api['url']);
				$post = array("key" => $api['key'], "data" => "record", "action" => "add", "domain" => $domain, "add" => base64_encode(serialize($record)));
				APIClient::sendPost($post);
			}
		}
	}
	public static function del_record ($domain, $record) {
		global $conf;
		if($conf['useremoteapi']) {
			foreach($conf['api'] as $id => $api) {
				APIClient::connect($api['url']);
				$post = array("key" => $api['key'], "action" => "get", "data" => "record", "domain" => $domain, "del" => $record);
				APIClient::sendPost($post);
			}
		}
	}
	public static function set_record ($domain, $record) {
		global $conf;
		if($conf['useremoteapi']) {
			foreach($conf['api'] as $id => $api) {
			
				APIClient::connect($api['url']);
				$post = array("key" => $api['key'], "data" => "record", "action" => "set", "domain" => $domain, "set" => base64_encode(serialize($record)));
				APIClient::sendPost($post);
			}
		}
	}
	
	/* function to get all domain records in webinterface */
	public static function get_all_records ($domain) { /* here we not need send anything to api */ }

	/* ZONE */
	public static function get_zone ($domain, $owner = Null, $api = false) {
		global $conf;
		if($conf['useremoteapi']) {
			foreach($conf['api'] as $id => $api) {
				APIClient::connect($api['url']);
				$post = array("key" => $api['key'], "data" => "zone", "action" => "get", "domain" => $domain);
				APIClient::sendPost($post);
			}
		}
	}
	public static function add_zone ($domain, $owner = Null) {
		global $conf;
		if($conf['useremoteapi']) {
			foreach($conf['api'] as $id => $api) {
				APIClient::connect($api['url']);
				$post = array("key" => $api['key'], "data" => "zone", "action" => "add", "domain" => $domain);
				APIClient::sendPost($post);
			}
		}
	}
	public static function del_zone ($domain) {
		global $conf;
		if($conf['useremoteapi']) {
			foreach($conf['api'] as $id => $api) {
				APIClient::connect($api['url']);
				$post = array("key" => $api['key'], "data" => "zone", "action" => "del", "domain" => $domain);
				APIClient::sendPost($post);
			}
		}
	}
	public static function set_zone ($domain, $data) {
		global $conf;
		if($conf['useremoteapi']) {
			foreach($conf['api'] as $id => $api) {
				APIClient::connect($api['url']);
				$post = array("key" => $api['key'], "data" => "zone", "action" => "set", "domain" => $domain, "set" => base64_encode(serialize($data)));
				APIClient::sendPost($post);
			}
		}
	}
}
?>
<?php
/* lib/server/mydns.class.php - DNS-CP
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
/* myDNS server class */

class server extends dns_server {
	/* RECORD */
	public static function get_record ($domain, $record) { }
	public static function add_record ($domain, $record) { }
	public static function del_record ($domain, $record) { }
	public static function set_record ($domain, $record) { }

	/* ZONE */
	public static function get_zone ($domain, $owner = Null, $api = false) {
		global $conf;
		if($api) {
			$res = DB::query("SELECT * FROM ".$conf["soa"]." where origin = :id", array(":id" => $domain.".")) or die(DB::error());
		} else {
			if(user::isAdmin()) {
				$res = DB::query("SELECT * FROM ".$conf["soa"]." where id = :id", array(":id" => $domain)) or die(DB::error());
			} else {
				$res = DB::query("SELECT * FROM ".$conf["soa"]." where id = :id and owner = :owner", array(":id" => $domain, ":owner" => $owner)) or die(DB::error());
			}
		}
		parent::get_zone($domain, $owner, $api);
		return DB::fetch_array($res);
	}
	
	public static function add_zone ($domain, $owner = Null) {
		global $conf;
		$domain = $domain.".";
		if(!empty($owner)) {
			$bind = array(":zone" => $domain, ":ns" => $conf["soans"], ":mbox" => $conf["mbox"], ":serial" => date("Ymd").'01', ":refresh" => $conf["refresh"], ":retry" => $conf["retry"], ":expire" => $conf["expire"], ":minimum" => $conf["minimum_ttl"], ":ttl" => $conf["ttl"], ":owner" => $owner);
			DB::query("INSERT INTO ".$conf["soa"]." (origin, ns, mbox, serial, refresh, retry, expire, minimum, ttl, owner) VALUES (:zone, :ns, :mbox, :serial, :refresh, :retry, :expire, :minimum, :ttl, :owner)", $bind) or die(DB::error());
		} else {
			$bind = array(":zone" => $domain, ":ns" => $conf["soans"], ":mbox" => $conf["mbox"], ":serial" => date("Ymd").'01', ":refresh" => $conf["refresh"], ":retry" => $conf["retry"], ":expire" => $conf["expire"], ":minimum" => $conf["minimum_ttl"], ":ttl" => $conf["ttl"]);
			DB::query("INSERT INTO ".$conf["soa"]." (origin, ns, mbox, serial, refresh, retry, expire, minimum, ttl, owner) VALUES (:zone, :ns, :mbox, :serial, :refresh, :retry, :expire, :minimum, :ttl, 0)", $bind) or die(DB::error());
		}
		parent::add_zone($domain, $owner);
		return true;
	}
	
	public static function del_zone ($domain, $api = false) {
		global $conf;
		if($api) {
			$res = DB::query("SELECT id FROM ".$conf["soa"]." where origin = :id", array(":id" => $domain.".")) or die(DB::error());
			$row = DB::fetch_array($res);
			DB::query("DELETE FROM ".$conf["soa"]." WHERE id = :id", array(":id" => $row['id'])) or die(DB::error());
			DB::query("DELETE FROM ".$conf["rr"]." WHERE zone = :id", array(":id" => $row["id"])) or die(DB::error());
		} else {
			DB::query("DELETE FROM ".$conf["soa"]." WHERE id = :id", array(":id" => $domain)) or die(DB::error());
			DB::query("DELETE FROM ".$conf["rr"]." WHERE zone = :id", array(":id" => $domain)) or die(DB::error());
		}
		parent::del_zone($domain, $api);
		return true;
	}
	
	public static function set_zone ($domain, $data, $api = false) {
		global $conf;
		if($api) {
			$bind = array(":refresh" => $data['refresh'],":retry" => $data['retry'],":expire" => $data['expire'],":ttl" => $data['attl'],":owner" => $data['owner'],":serial" => $data['serial'],":id" => $domain);
			DB::query("UPDATE ".$conf["soa"]." SET refresh = :refresh, retry = :retry, expire = :expire, ttl = :ttl, owner = :owner, serial = :serial WHERE id = :id", $bind) or die(DB::error());
		} else{
			$bind = array(":refresh" => $data['refresh'],":retry" => $data['retry'],":expire" => $data['expire'],":ttl" => $data['attl'],":owner" => $data['owner'],":serial" => $serial,":id" => $domain.".");
			DB::query("UPDATE ".$conf["soa"]." SET refresh = :refresh, retry = :retry, expire = :expire, ttl = :ttl, owner = :owner, serial = :serial WHERE origin = :id", $bind) or die(DB::error());
		}
		parent::set_zone($domain, $data, $api);
		return true;
	}
}
?>

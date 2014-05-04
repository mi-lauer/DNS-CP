<?php
/* lib/server/mydns.class.php - DNS-CP
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
/* myDNS server class */

class server extends dns_server {
	/* RECORD */
	public static function get_record ($domain, $record) {
		$conf = system::get_conf();
		$res = DB::query("SELECT * FROM ".$conf["rr"]." where zone = :zone and id = :record ORDER BY type ASC", array(":zone" => $domain, ":record" => $record)) or die(DB::error());
		return DB::fetch_array($res);
	}
	
	public static function add_record ($domain, $record) {
		$conf = system::get_conf();
		$bind = array(":zone" => $domain,":name" => $record['newhost'],":type" => $record['newtype'],":data" => $record['newdestination'],":aux" => $record['newpri'],":ttl" => $record['newttl']);
		DB::query("INSERT INTO ".$conf["rr"]." (id, zone, name, type, data, aux, ttl) VALUES (NULL, :zone, :name, :type, :data, :aux, :ttl)", $bind) or die(DB::error());
		parent::add_record($domain, $record);
		return true;
	}
	
	public static function del_record ($domain, $record) {
		$conf = system::get_conf();
		DB::query("DELETE FROM ".$conf["rr"]." WHERE id = :id AND zone = :zone", array(":id" => $record,":zone" => $domain)) or die(DB::error());
		parent::del_record($domain, $record);
		return true;
	}
	
	public static function set_record ($domain, $record) {
		$conf = system::get_conf();
		$bind = array(":name" => $record['host'],":type" => $record['type'],":aux" => $record['aux'],":data" => $record['destination'],":ttl" => $record['ttl'],":id" => $record['host_id'],":zone" => $domain);
		DB::query("UPDATE ".$conf["rr"]." SET name = :name, type = :type, aux = :aux, data = :data, ttl = :ttl WHERE id = :id AND zone = :zone", $bind) or die(DB::error());
		parent::set_record($domain, $record);
		return true;
	}
	
	public static function get_all_records ($domain) {
		$conf = system::get_conf();
		$res = DB::query("SELECT * FROM ".$conf["rr"]." where zone = :zone ORDER BY type ASC", array(":zone" => $domain)) or die(DB::error());
		$return = array();
		while($row = DB::fetch_array($res)) {
			$return[] = $row;
		}
		return $return;
	}

	/* ZONE */
	public static function get_zone ($domain, $owner = Null, $api = false) {
		$conf = system::get_conf();
		if(user::isAdmin() or $api) {
			$res = DB::query("SELECT * FROM ".$conf["soa"]." where id = :id", array(":id" => $domain)) or die(DB::error());
		} else {
			$res = DB::query("SELECT * FROM ".$conf["soa"]." where id = :id and owner = :owner", array(":id" => $domain, ":owner" => $owner)) or die(DB::error());
		}
		return DB::fetch_array($res);
	}
	
	public static function add_zone ($domain, $owner = Null) {
		$conf = system::get_conf();
		if(!empty($owner)) {
			$bind = array(":zone" => $domain.".", ":ns" => $conf["soans"], ":mbox" => $conf["mbox"], ":serial" => date("Ymd").'01', ":refresh" => $conf["refresh"], ":retry" => $conf["retry"], ":expire" => $conf["expire"], ":minimum" => $conf["minimum_ttl"], ":ttl" => $conf["ttl"], ":owner" => $owner);
			DB::query("INSERT INTO ".$conf["soa"]." (origin, ns, mbox, serial, refresh, retry, expire, minimum, ttl, owner) VALUES (:zone, :ns, :mbox, :serial, :refresh, :retry, :expire, :minimum, :ttl, :owner)", $bind) or die(DB::error());
		} else {
			$bind = array(":zone" => $domain.".", ":ns" => $conf["soans"], ":mbox" => $conf["mbox"], ":serial" => date("Ymd").'01', ":refresh" => $conf["refresh"], ":retry" => $conf["retry"], ":expire" => $conf["expire"], ":minimum" => $conf["minimum_ttl"], ":ttl" => $conf["ttl"]);
			DB::query("INSERT INTO ".$conf["soa"]." (origin, ns, mbox, serial, refresh, retry, expire, minimum, ttl, owner) VALUES (:zone, :ns, :mbox, :serial, :refresh, :retry, :expire, :minimum, :ttl, 0)", $bind) or die(DB::error());
		}
		parent::add_zone($domain, $owner);
		return true;
	}
	
	public static function del_zone ($domain) {
		$conf = system::get_conf();
		DB::query("DELETE FROM ".$conf["soa"]." WHERE id = :id", array(":id" => $domain)) or die(DB::error());
		DB::query("DELETE FROM ".$conf["rr"]." WHERE zone = :id", array(":id" => $domain)) or die(DB::error());
		parent::del_zone($domain);
		return true;
	}
	
	public static function set_zone ($domain, $data) {
		$conf = system::get_conf();
		$bind = array(":refresh" => $data['refresh'],":retry" => $data['retry'],":expire" => $data['expire'],":ttl" => $data['attl'],":serial" => $data['serial'],":id" => $domain);
		DB::query("UPDATE ".$conf["soa"]." SET refresh = :refresh, retry = :retry, expire = :expire, ttl = :ttl, serial = :serial WHERE id = :id", $bind) or die(DB::error());
		if(isset($data['owner']))
			DB::query("UPDATE ".$conf["soa"]." SET owner = :owner where id = :id ", array(":owner" => $data['owner'], ":id" => $domain));
		parent::set_zone($domain, $data);
		return true;
	}
	
	public static function get_all_zones ($owner = Null) {
		$conf = system::get_conf();
		if($owner) {
			$res = DB::query("SELECT * FROM ".$conf["soa"]." where owner = :owner", array( ":owner" => $owner)) or die(DB::error());
		} else {
			$res = DB::query("SELECT * FROM ".$conf["soa"]) or die(DB::error());
		}
		$return = array();
		while($row = DB::fetch_array($res)) {
			$return[] = $row;
		}
		return $return;
	}
	
	public static function get_zone_by_name($name) {
		$conf = system::get_conf();
		$res = DB::query("SELECT * FROM ".$conf["soa"]." where origin = :name", array(":name" => $name.".")) or die(DB::error());
		$zone = DB::fetch_array($res);
		return self::get_zone($zone['id']);
		
	}
}
?>

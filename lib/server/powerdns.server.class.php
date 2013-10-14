<?php
/* lib/server/powerdns.server.class.php - DNS-CP
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
/* powerDNS server class */

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
			$res = DB::query("SELECT * FROM ".$conf["rr"]." where name = :id and type = :type", array(":id" => $domain, ":type" => "SOA")) or die(DB::error());
		} else {
			if(user::isAdmin()) {
				$res = DB::query("SELECT * FROM ".$conf["rr"]." where domain_id = :id and type = :type", array(":id" => $domain, ":type" => "SOA")) or die(DB::error());
			} else {
				$res = DB::query("SELECT * FROM ".$conf["rr"]." where domain_id = :id and type = :type and owner = :owner", array(":id" => $domain, ":type" => "SOA", ":owner" => $owner)) or die(DB::error());
			}
		}
		parent::get_zone($domain, $owner, $api)
		return DB::fetch_array($res);
	}
	
	public static function add_zone ($domain, $owner = Null) {
		global $conf;
		if(empty($owner)) {
			DB::query("INSERT INTO ".$conf["soa"]." (name, master, last_check, type, notified_serial, account, owner) VALUES (:zone, NULL, NULL, 'MASTER', NULL, NULL, 0);", array(":zone" => $domain));
		} else {
		DB::query("INSERT INTO ".$conf["soa"]." (name, master, last_check, type, notified_serial, account, owner) VALUES (:zone, NULL, NULL, 'MASTER', NULL, NULL, :owner);", array(":zone" => $domain, ":owner" => $owner));
	}
		$content = $conf["soans"]." ".$conf["mbox"]." ".date("Ymd")."01 ".$conf["refresh"]." ".$conf["retry"]." ".$conf["expire"]." ".$conf["minimum_ttl"];
		$bind array(":id" => DB::last_id(), ":name" => $domain, ":type" => "SOA", ":content" => $content, ":ttl" => $conf["ttl"], ":prio" => 0, ":date" => time());
		DB::query("INSERT INTO ".$conf["rr"]." (domain_id, name, type, content, ttl, prio, change_date) VALUES (:id, :name, :type, :content, :ttl, :prio, :date);", $bind);
		parent::add_zone($domain, $owner);
		return true;
	}

	public static function del_zone ($domain, $api = false) {
		global $conf;
		if($api) {
			$res = DB::query("SELECT id FROM ".$conf["soa"]." where name = :id", array(":id" => $domain)) or die(DB::error());
			$row = DB::fetch_array($res);
			DB::query("DELETE FROM ".$conf["soa"]." WHERE id = :id", array(":id" => $row['id'])) or die(DB::error());
			DB::query("DELETE FROM ".$conf["rr"]." WHERE domain_id = :id", array(":id" => $row["id"])) or die(DB::error());
		} else {
			DB::query("DELETE FROM ".$conf["soa"]." WHERE id = :id", array(":id" => $domain)) or die(DB::error());
			DB::query("DELETE FROM ".$conf["rr"]." WHERE domain_id = :id", array(":id" => $domain)) or die(DB::error());
		}
		parent::del_zone($domain, $api);
		return true;
	}
	
	public static function set_zone ($domain, $data, $api = false) {
		global $conf;
		if($api) {
			$content = $conf["soans"]." ".$conf["mbox"]." ".$data['serial']." ".$data['refresh']." ".$data['retry']." ".$data['expire']." ".$conf["minimum_ttl"];
			DB::query("UPDATE ".$conf["rr"]." SET content = :content, ttl = :ttl where name = :name ", array(":content" => $content, ":ttl" => $data['attl'], ";name" => $domain));
		} else{
			$content = $conf["soans"]." ".$conf["mbox"]." ".$data['serial']." ".$data['refresh']." ".$data['retry']." ".$data['expire']." ".$conf["minimum_ttl"];
			DB::query("UPDATE ".$conf["rr"]." SET content = :content, ttl = :ttl where id = :name ", array(":content" => $content, ":ttl" => $data['attl'], ";name" => $domain));
		}
		parent::set_zone($domain, $data, $api);
		return true;
	}
}
?>

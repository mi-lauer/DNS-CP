<?php
/* lib/server/bind9.class.php - DNS-WI
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
/* bind9 server class */

class server {
	/* RECORD */
	public static function get_record ($domain, $record) { }
	public static function add_record ($domain, $record) { }
	public static function del_record ($domain, $record) { }
	public static function set_record ($domain, $record) { }

	/* ZONE */
	public static function get_zone ($domain) { }
	public static function add_zone ($domain, $data) { }
	public static function del_zone ($domain) { }
	public static function set_zone ($domain, $data) { }
}
?>

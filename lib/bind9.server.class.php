<?php
/* lib/bind9.server.class.php - DNS-WI
 * Copyright (C) 2013  OWNDNS project
 * http://owndns.me/
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License 
 * along with this program. If not, see <http://www.gnu.org/licenses/>. 
 */
/* bind9 server class */
class server extends dns_server {
	public static function add_record () { }
	public static function del_record () { }
	public static function update_record () { }
	public static function add_soa () { }
	public static function del_soa () { }
	public static function update_soa () { }
	public static function add_user () { }
	public static function del_user () { }
	public static function update_user () { }
	public static function add_zone () { }
	public static function del_zone () { }
}
?>

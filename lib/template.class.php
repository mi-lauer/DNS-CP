<?php
/* lib/template.class.php - DNS-WI
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
class template {
	public static function get_template($template) {
		return file_get_contents("templates/".$template.".php");
	}
	public static function show ($content, $replace) {
		foreach($replace as $name => $value) {
			$content = str_replace("{".$name."}", $value, $content);
		} 
		global $conf;
		return eval("?>".$content);
	}
}
?>

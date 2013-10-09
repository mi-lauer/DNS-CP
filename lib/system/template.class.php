<?php
/* lib/system/template.class.php - DNS-WI
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
	/**
	 * get the template
	 *
	 * @param	string		$template
	 * @return 	string		source from the template
	 */
	public static function get_template($template) {
		return file_get_contents("templates/".$template.".php");
	}
	
	/**
	 * show the template
	 *
	 * @param	string		$content
	 * @param	string		$replace
	 * @return	string		returns the replaces template
	 */
	public static function show ($template, $replace) {
		global $conf, $lang;
		$content = self::get_template($template);
		foreach($replace as $name => $value) {
			$content = str_replace("{".$name."}", $value, $content);
		}
		foreach($lang as $name => $value) {
			$content = str_replace("{@_".$name."}", $value, $content);
		}
		return eval("?>".$content);
	}
}
?>

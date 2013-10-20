<?php
/* lib/system/tpl.class.php - DNS-CP
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

class tpl {
	private static $lang = array();

	/**
	 * set language array
	 *
	 * @param	array	$lang
	 */
	public static function set_lang ($lang) {
		self::$lang = $lang;
	}
	
	/**
	 * show the template
	 *
	 * @param	string		$content
	 * @param	array		$replace
	 */
	public static function show ($template, $replace) {
		$tpl = new template;
		$tpl->compile_dir = "templates/compiled";
		$tpl->compile_check = true;
		$tpl->tpl_ending = "tpl";
		$tpl->language = self::$lang
		$tpl->assign($replace);
		$tpl->display($template);
	}
}
?>

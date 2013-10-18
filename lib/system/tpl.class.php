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
	/**
	 * show the template
	 *
	 * @param	string		$content
	 * @param	array		$replace
	 * @return	string		returns the replaces template
	 */
	public static function show ($template, $replace) {
		#require("../template/template.class.php");
		$tpl = new template;
		#$tpl->force_compile = true;
		$tpl->compile_dir = "templates/compiled";
		$tpl->compile_check = true;
		#$tpl->cache = false;
		#$tpl->cache_lifetime = 3600;
		#$tpl->config_overwrite = false;
		$tpl->tpl_ending = "tpl";
		#$tpl->language = array("test" => "hallo");
		#$tpl->assign("Name","Fred Irving Johnathan Bradley Peppergill");
		#$tpl->assign("FirstName",array("John","Mary","James","Henry"));
		#$tpl->assign("contacts", array(array("phone" => "1", "fax" => "2", "cell" => "3"),
		#	  array("phone" => "555-5555", "fax" => "555-4444", "cell" => "555-3333")));
		#$tpl->assign("bold", array("up", "down", "left", "right"));
		#$tpl->assign("lala", array("up" => "first entry", "down" => "last entry"));
		#$tpl->assign("blah", "up");
		$tpl->assign($replace);

		$tpl->display($template);
	
	}
}
?>

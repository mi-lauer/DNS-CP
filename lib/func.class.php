<?php
/* lib/func.class.php - DNS-WI
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
class func {
	/**
	 * returns a options box
	 *
	 * @param		string		$type
	 * @param		integer		$id
	 * @return					retuns a options box
	 */
	public static function getOptions ($type, $id = NULL) {
		global $conf;
		$return = NULL;
		if(isset($id)) {
			$return .= '<select name="type['.$id.']">';
		} else {
			$return .= '<select name="newtype">';
		}
		foreach($conf["typearray"] as $name ){
			if($name == $type) {
				$return .= '<option label="'.$name.'" value="'.$name.'" selected="selected">'.$name.'</option>';
			} else {
				$return .= '<option label="'.$name.'" value="'.$name.'">'.$name.'</option>';
			}
		}
		$return .= '</select>';
		return $return;
	}
	
	/**
	 * Convert all applicable characters to HTML entities
	 *
	 * @param 	string	$str
	 * @return	string
	 */
	public static function ent ($str) {
		return htmlentities($str);
	}

	/**
	 * Output current dns server
	 *
	 * @return   string    dns server in lowercase
	*/
	public static function currentDNSserver () {
		return '<MYSQL QUERY>';
	}
}
?>

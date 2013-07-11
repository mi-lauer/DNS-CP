<?php
/* lib/user.class.php - DNS-WI
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
class user {
	/**
	 * login a user
	 *
	 * @param		string		$user
	 * @param		string		$user
	 * @return		string
	 */
	public static function login ($user, $pass) {
		global $conf;
		$res = DB::query("SELECT * FROM ".$conf["users"]." WHERE username='".DB::escape($user)."'") or die(DB::error());
		$row = DB::fetch_array($res);
		if($row["password"] == md5($pass)) {
			$_SESSION['login'] = 1;
			$_SESSION['username'] = $row["username"];
			$_SESSION['userid'] = $row["id"];
			return '<font color="#008000">Login sucessful</font><meta http-equiv="refresh" content="0; URL=?page=home">';
		} else {
			return '<font color="#ff0000">The data you have entered are invalid.</font>';
		}
	}
	
	/**
	 * logout a user
	 *
	 * @return		string
	 */
	public static function logout () {
		session_destroy();
		return '<font color="#008000">Logout sucessful</font><meta http-equiv="refresh" content="2; URL=?page=home">';
	}
	
	/**
	 * change the password of a user
	 *
	 * @param 		string		$user
	 * @param 		string		$opw
	 * @param 		string		$npw
	 * @param 		string		$npw2
	 * @return		string
	 */
	public static function change_password ($user, $opw, $npw, $npw2) {
		$res = DB::query("SELECT * FROM ".$conf["users"]." WHERE username = '".DB::escape($user)."'") or die(DB::error());
		$row = DB::fetch_array($res);
		if(isset($npw) && isset($npw2) && isset($opw) && $opw != "" && $npw != "" && $npw2 != ""){
			if($npw == $npw2) {
				if($row["password"] == md5($opw)){
					DB::query("UPDATE ".$conf["users"]." SET password = '".md5($npw)."' WHERE username = '".DB::escape($user)."'") or die(DB::error());
					return '<font color="#008000">Password changed successfully.</font>';
				} else {
					return '<font color="#ff0000">The data you have entered are invalid.</font>';
				}
			} else {
				return '<font color="#ff0000">The data you have entered are invalid.</font>';
			}
		} else {
			return '<font color="#ff0000">The data you have entered are invalid.</font>';
		}
	}
	
	/**
	 * check if the user is loggedin
	 *
	 * @return		true or false
	 */
	public static function isLoggedIn () {
		if(isset($_SESSION['login']) && $_SESSION['login'] == 1){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * check is user an Admin
	 *
	 * @return 		true or false
	 */
	public static function isAdmin () {
		global $conf;
		$res = DB::query("SELECT * FROM ".$conf["users"]." WHERE id = '".DB::escape($_SESSION["userid"])."'") or die(DB::error());
		$row = DB::fetch_array($res);
		if(isset($row['admin']) && $row['admin'] == 1){
			return true;
		} else {
			return false;
		}
	}
	/* will be added later
	public static function get_users () { }
	public static function add_user () { }
	public static function del_user () { }
	public static function change_user () { }
	*/
}
?>

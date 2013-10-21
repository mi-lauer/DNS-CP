<?php
/* index.php - DNS-CP
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

session_start();
ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

if(!file_exists("config.php")) {
	die("Missing config file! Please change config.sample.php to your needs and rename it to config.php!");
}

// set config variables
$database               = array();                    // init database array
$conf                   = array();                    // init config array
$conf["version"]        = "0.1.8-dev";                // Version
$conf["build"]          = "1";                        // build number for internal version checking
$conf["typearray"]      = array('A', 'AAAA', 'CNAME', 'MX', 'NS', 'PTR', 'SRV', 'TXT');
$conf["avail_dns_srv"]  = array("MyDNS", "Bind9", "PowerDNS");

// requirements
require_once("config.php");
require_once("lib/system/system.class.php");
// set system variables
system::set_conf($conf);
system::set_database($database);

require_once("lib/template/template.class.php");
require_once("lib/system/db.class.php");
DB::connect() or die(DB::error());

require_once("lib/system/user.class.php");
require_once("lib/system/apiclient.class.php");
require_once("lib/server/server.class.php");
require_once("lib/server/".$conf['server'].".server.class.php");
require_once("lib/system/tpl.class.php");
require_once("lib/system/func.class.php");
require_once("lib/system/dns.class.php");
require_once("lib/whois/whois.main.php");
require_once("lib/lang/".$conf['lang'].".inc.php");

// save all existing pages in a array
$pages=array();
foreach (glob("lib/page/*.php") as $file) {
	$pages[] = $file;
}

// set language to template
tpl::set_lang($lang);

$page = NULL;
if(isset($_GET["page"]) && !empty($_GET["page"]))
	$page = trim($_GET["page"]);

// set default site
if(empty($page)) {
	$page = "home";
}

// menu array
$menu = array(
	"home"     => "Home",
	"zone"     => "Zones",
	"users"    => "Users",
	"settings" => "Settings",
	"tools"    => "Tools",
	"help"     => "Help"
);

// set title
$title = $conf["name"];
if(!empty($menu[$page])) {
	$title .= " :: ".$menu[$page];
}
if(user::isLoggedIn()){
	$tmenu = "";
	foreach($menu as $mpage => $menu_name) {
		if($page == $mpage) { $class = ' class="active"'; }else{ $class = null; }
		$tmenu .= '<li><a href="?page='.$mpage.'"'.$class.'>'.$menu_name.'</a></li>'."\n";
	}
	$login = '<li class="logout"><a href="?page=logout">LOGOUT</a></li>';
	if(isset($page)) {
		$page = "lib/page/".$page.".php";
		if(in_array($page, $pages)) {
			if(@file_exists($page)){
				require_once($page);
			} else {
				require_once("lib/page/404.php");
			}
		} else {
			require_once("lib/page/404.php");
		}
	}
} else {
	$tmenu ='<li><a href="?page=login" class="active">Login</a></li>';
	$login = '<li class="logout"><a href="?page=login">LOGIN</a></li>';
	require_once("lib/page/login.php");
}
DB::close();
?>

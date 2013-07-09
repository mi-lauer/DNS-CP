<?php
/* index.php - DNS-WI
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

define("IN_PAGE", true);
if(!file_exists("config.php")) {
	die("Missing config file! Please change config.sample.php to your needs and rename it to config.php!");
}

// set config variables
$database               = array();                    // init database array
$conf                   = array();                    // init config array
$conf["version"]        = "0.1.7-dev";                // Version
$conf["build"]          = "2";                        // build number for internal version checking
$conf["typearray"]      = array('A', 'AAAA', 'CNAME', 'MX', 'NS', 'PTR', 'SRV', 'TXT');

require_once("config.php");

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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $title; ?></title>
	<link href="style/css/layout.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="style/css/jNice.css" rel="stylesheet" type="text/css" media="screen" />
	<script type="text/javascript" src="style/js/jquery.js"></script>
	<script type="text/javascript" src="style/js/jNice.js"></script>
</head>
<body>
	<div id="wrapper">
    	<h1><?php echo $conf["name"]; ?></h1>
        <ul id="mainNav">
			<?php if(func::isLoggedIn()){ ?>
				<li class="logout"><a href="?page=logout">LOGOUT</a></li>
			<?php } else { ?>
				<li class="logout"><a href="?page=login">LOGIN</a></li>
			<?php } ?>
        </ul>
        <div id="containerHolder">
			<div id="container">
        		<div id="sidebar">
                	<ul class="sideNav">
						<?php if(func::isLoggedIn()){
							// put the menu out
							foreach($menu as $mpage => $menu_name) {
								if($page == $mpage) { $class = ' class="active"'; }else{ $class = null; }
								echo '							<li><a href="?page='.$mpage.'"'.$class.'>'.$menu_name.'</a></li>'."\n";
							}	
						} else { ?>
							<li><a href="?page=login" class="active">Login</a></li>
						<?php } ?>
                    </ul>
                </div>
<?php

if(func::isLoggedIn()){
	if(isset($page)) {
		if(@file_exists("page/".$page.".php")){
			require_once("page/".$page.".php");
		 } else {
			require_once("page/404.php");
		}
	}
 } else {
	require_once("page/login.php");
}

?>
                <div class="clear"></div>
            </div>
        </div>
        <p id="footer"><a href="http://owndns.me">Software: <strong>DNS-WI <span title="<?php echo $conf["build"]; ?>"><?php echo $conf["version"]; ?></strong></span>, developed by <a href="https://github.com/Stricted/DNS-Webinterface"><strong>OwnDNS</strong></a></a></p>
    </div>
</body>
</html>

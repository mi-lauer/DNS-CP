<?php
/* index.php - myDNS-WI
 * Copyright (C) 2012-2013  Nexus-IRC project
 * http://nexus-irc.de
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
require_once("config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $conf["name"]; ?></title>
	<link href="style/css/layout.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="style/css/jNice.css" rel="stylesheet" type="text/css" media="screen" />
	<script type="text/javascript" src="style/js/jquery.js"></script>
	<script type="text/javascript" src="style/js/jNice.js"></script>
</head>
<body>
	<div id="wrapper">
    	<h1><?php echo $conf["name"]; ?></h1>
        <ul id="mainNav">
			<?php if(isset($_SESSION['login']) && $_SESSION['login'] == 1){ ?>
				<li class="logout"><a href="?page=logout">LOGOUT</a></li>
			<?php } else { ?>
				<li class="logout"><a href="?page=login">LOGIN</a></li>
			<?php } ?>
        </ul>
        <div id="containerHolder">
			<div id="container">
        		<div id="sidebar">
                	<ul class="sideNav">
						<?php if(isset($_SESSION['login']) && $_SESSION['login'] == 1){ ?>
							<li><a href="?page=main" <?php if($_GET["page"] == "main" || !$_GET["page"]) { ?>class="active"<?php } ?>>Main</a></li>
							<li><a href="?page=zone" <?php if($_GET["page"] == "zone" ) { ?>class="active"<?php } ?>>Zones</a></li>
							<li><a href="?page=users" <?php if($_GET["page"] == "users") { ?>class="active"<?php } ?>>Users</a></li>
							<li><a href="?page=tools" <?php if($_GET["page"] == "tools") { ?>class="active"<?php } ?>>Tools</a></li>
							<li><a href="?page=chpw" <?php if($_GET["page"] == "chpw") { ?>class="active"<?php } ?>>Change password</a></li>
							<li><a href="?page=help" <?php if($_GET["page"] == "help") { ?>class="active"<?php } ?>>Help</a></li>
						<?php } else { ?>
							<li><a href="?page=login" class="active">Login</a></li>
							<li><a href="?page=main">Main</a></li>
						<?php } ?>
                    </ul>
                </div>
<?php
if(isset($_SESSION['login']) && $_SESSION['login'] == 1){
	if(isset($_GET["page"])) {
		if(file_exists("page/".$_GET["page"].".php")){
			require_once("page/".$_GET["page"].".php");
		} else {
			require_once("page/main.php");
		}
	} else {
		require_once("page/main.php");
	}
} else {
	require_once("page/login.php");
}
?>
                <div class="clear"></div>
            </div>
        </div>
        <p id="footer"><a href="http://nexus-irc.de">Software: <strong>MyDNS-WI <?php echo $conf["version"]; ?></strong>, developed by <strong>Nexus-IRC</strong></a></p>
    </div>
</body>
</html>



<?php
/* templates/index.php - DNS-WI
 * Copyright (C) 2013  OWNDNS project
 * http://owndns.me/
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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>{_title}</title>
	<link href="style/css/layout.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="style/css/jNice.css" rel="stylesheet" type="text/css" media="screen" />
	<script type="text/javascript" src="style/js/jquery.js"></script>
	<script type="text/javascript" src="style/js/jNice.js"></script>
</head>
<body>
	<div id="wrapper">
    	<h1>{_name}</h1>
        <ul id="mainNav">
			{_login}
        </ul>
        <div id="containerHolder">
			<div id="container">
        		<div id="sidebar">
                	<ul class="sideNav">
						{_menu}
                    </ul>
                </div>
				{_content}
                <div class="clear"></div>
            </div>
        </div>
        <p id="footer"><a href="http://owndns.me">Software: <strong>DNS-WI <span title="{_build}">{_version}</strong></span>, developed by <a href="https://github.com/Stricted/DNS-Webinterface"><strong>OwnDNS</strong></a></a></p>
    </div>
</body>
</html>

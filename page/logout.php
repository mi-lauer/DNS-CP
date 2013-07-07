<?php
/* page/logout.php - DNS-WI
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
?>
<h2><a href="?page=main">DNS</a> &raquo; <a href="#" class="active">Logout</a></h2>
<div id="main">
<?php
$_SESSION['login'] = 0;
$_SESSION['username'] = 0;
$_SESSION['userid'] = 0;
echo '<font color="#008000">Logout sucessful</font>';
echo '<meta http-equiv="refresh" content="0; URL=?page=main">';
?>
</div>

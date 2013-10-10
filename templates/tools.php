<?php
/* templates/tools.php - DNS-WI
 * Copyright (C) 2013  OwnDNS project
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
if(!defined("IN_PAGE")) { die("no direct access allowed!"); }
?>
<h2><a href="?page=home">DNS</a> &raquo; <a href="#" class="active">{_name}</a></h2>
<div id="main">
<?php
if(isset($_POST["Submit"])) {
?>
{_content}
<?php
} else {
?>
<form method="post" name="target" action="?page=tools" class="jNice">
	<table width="320"  border="0" align="center">
		<tr>
			<td><strong>DNS lookup:</strong></td>
			<td><input class="text" type="text" name="dns" /></td>
		</tr>
			<td><strong>Domain WHOIS:</strong></td>
			<td><input class="text" type="text" name="whois" /></td>
		<tr class="odd">
			<td>&nbsp;</td>
			<td><center><input type="submit" name="Submit" value="Check" /></center></td>
		</tr>
	</table>
</form>
<?php } ?>
</div>

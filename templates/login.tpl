<?php
/* templates/login.php - DNS-CP
 * Copyright (C) 2013  CNS-CP project
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

?>
<h2><a href="?page=home">DNS</a> &raquo; <a href="#" class="active">{_name}</a></h2>
<div id="main">
{_error}
<form method="post" name="login" action="?page=login" class="jNice">
	<table width="320"  border="0" align="center">
		<tr>
			<td><strong>Username:</strong></td>
			<td><input class="text" type="text" name="username" /></td>
		</tr>
		<tr>
			<td><strong>Password:</strong></td>
			<td><input class="text" type="password" name="password" /></td>
		</tr>
		<tr class="odd">
			<td><center><input type="submit" name="Submit" value="Login" /></center></td>
			<td>&nbsp;</td>
		</tr>
	</table>
</form>
</div>

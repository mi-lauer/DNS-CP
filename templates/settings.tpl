<?php
/* templates/settings.php - DNS-CP
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

?>
<h2><a href="?page=home">DNS</a> &raquo; <a href="#" class="active">{_name}</a></h2>
<div id="main">
	{_error}
	<form name="form1" method="post" action="?page=settings" class="jNice">
		<table width="320" border="0">
			<tr>
				<td><div align="right"><strong>Old password:</strong></div></td>
				<td><input class="text" type="password" name="password_old" ></td>
			</tr>
			<tr>
				<td><div align="right"><strong>New password:</strong></div></td>
				<td><input class="text" type="password" name="password_one" ></td>
			</tr>
			<tr>
				<td><div align="right"><strong>Confirm new password:</strong></div></td>
				<td><input class="text" type="password" name="confirm_password" ></td>
			</tr>
		</table>

		<br />
		<input name="Submit" type="submit" class="a" value="Save settings">
	</form>
</div>

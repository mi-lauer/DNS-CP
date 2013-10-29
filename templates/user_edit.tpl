{include file="header"}
<h2><a href="?page=home">DNS</a> &raquo; <a href="#" class="active">{$name}</a></h2>
<div id="main">
	{if $data|isset}{$data}{/if}
	<form name="form1" method="post" action="?page=users&id={$id}" class="jNice">
		<table width="320"  border="0">
			<tr>
				<td><div align="right"><strong>Username:</strong></div></td>
				<td>{$row[username]}</td>
			</tr>
			<tr>
				<td><div align="right"><strong>Administrator:</strong></div></td>
				<td>
				{if $id == 1}yes{elseif $row[admin] == 1}
					<label><input type="radio" name="admin" value="1" checked="checked" />yes</label> 
					<label><input type="radio" name="admin" value="0" />no</label>
				{else}
					<label><input type="radio" name="admin" value="1" />yes</label> 
					<label><input type="radio" name="admin" value="0" checked="checked" />no</label>
				{/if}
				</td>
			</tr>
			<tr>
				<td><div align="right"><strong>New password:</strong></div></td>
				<td><input class="text" type="password" name="password_one" ></td>
			</tr>
			<tr>
				<td><div align="right"><strong>Confirm new password:</strong></div></td>
				<td><input class="text" type="password" name="confirm_password" ></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr class="odd">
				<td>&nbsp;</td>
				<td><input name="Submit" type="submit" value="Save"></td>
			</tr>
		</table>
	</form>
	<strong>Zones owned by this user:</strong>
	<table width="100%"  border="0" cellspacing="1">
		<tr>
			<td><strong>Name</strong></td>
			<td><strong>Records</strong></td>
			<td><strong>Serial</strong></td>
		</tr>
	{foreach from=$zones item=row2}
		<tr>
			<td class="action"><a class="view" href="?page=zone&id={$row2["id"]}">{$row2[origin]}</a></td>
			<td class="action">
				<a class="view" href="?page=zone&id={$row2["id"]}">
					{foreach from=$records key=recordid item=record}
						{if $recordid == $row2[id]}
							{$record}
						{/if}
					{/foreach}
				</a>
			</td>
			<td class="action"><a class="edit" href="?page=zone&id={$row2["id"]}">{$row2[serial]}</a></td>
		</tr>
	{/foreach}
	</table>

</div>
{include file="footer"}
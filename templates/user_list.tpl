{include file="header"}
<h2><a href="?page=home">DNS</a> &raquo; <a href="#" class="active">{$name}</a></h2>
<div id="main">
	{if $data|isset}{$data}{/if}
	<strong><a href="?page=users&act=add">Add a new user</a></strong><br /><br />
	<table width="100%"  border="0" cellspacing="1">
		<tr>
			<td><strong>Username</strong></td>
			<td><strong>Administrator</strong></td>
			<td><strong>Zones</strong></td>
			<td><strong>Delete</strong></td>
		</tr>
		{foreach from=$res item=row}
		<tr>
			<td class="action"><a class="view" href="?page=users&id={$row[id]}">{$row[username]}</a></td>
			<td class="action"><a class="edit" href="?page=users&id={$row[id]}">{if $row[admin] == 1}yes{else}no{/if}</a></td>
			<td class="action">
				<a class="edit" href="?page=users&id={$row[id]}">
					{foreach from=$zones key=zoneid item=zone}
						{if $zoneid == $row[id]}
							{$zone}
						{/if}
					{/foreach}
				</a>
			</td>
			<td class="action"><a class="delete" href="?page=users&id={$row[id]}&act=del" onClick="return confirm('Are you really sure that you want delete this user?')">Delete</a></td>
		</tr>
		{/foreach}
	</table>
</div>
{include file="footer"}
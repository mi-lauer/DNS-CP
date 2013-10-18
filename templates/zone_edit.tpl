{include file="header"}
<h2><a href="?page=home">DNS</a> &raquo; <a href="#" class="active">{$name}</a></h2>
<div id="main">
{if $data|isset}{$data}{/if}
<form name="form1" method="post" action="?page=zone&id={$row[id]}" class="jNice">
	<table border="0" cellpadding="0" cellspacing="3">
		<tr>
			<td><div align="right"><strong>Zone:</strong></div></td>
			<td>{$row[origin]}</td>
			<td><div align="right"><strong>Serial:</strong></div></td>
			<td>{$row[serial]}</td>
		</tr>
		<tr>
			<td><div align="right"><strong>Refresh:</strong></div></td>
			<td><input class="text" type="text" name="refresh" size="25" value="{$row[refresh]}"></td>
			<td><div align="right"><strong>Retry:</strong></div></td>
			<td><input class="text" type="text" name="retry" size="25" value="{$row[retry]}"></td>
		</tr>
		<tr>
			<td><div align="right"><strong>Expire:</strong></div></td>
			<td><input class="text" type="text" name="expire" size="25" value="{$row[expire]}"></td>
			<td><div align="right"><strong>TTL:</strong></div></td>
			<td><input class="text" type="text" name="attl" size="25" value="{$row[ttl]}"></td>
		</tr>
		{if $isAdmin}
		<tr>
			<td><div align="right"><font face="Arial,Helvetica" size="-1"><strong>Owner: </strong></font></div></td>
			<td>
				<select name="owner">
					{foreach from=$res3 key=row3id item=row3}
						{if $row3[id] == $row[owner]}
							<option value="{$row3[id]}" selected>{$row3[username]}</option>
						{else}
							<option value="{$row3[id]}">{$row3[username]}</option>
						{/if}
					{/foreach}
				</select>
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		{/if}
	</table>

	<input type="hidden" name="serial" value="{$row[serial]}">
	<input type="hidden" name="zone" value="{$row[origin]}">
	<input type="hidden" name="zoneid" value="{$row[id]}">
	<table border="0" cellpadding="0" cellspacing="3">
		<tr>
			<td><strong>Host</strong></td>
			<td><strong>TTL</strong></td>
			<td><strong>Type</strong></td>
			<td><strong>Prio</strong></td>
			<td><strong>Data</strong></td>
			<td><strong>Manage</strong></td>
		</tr>
		{foreach from=$res2 item=row2}
		<tr>
			<td>
				<input type="hidden" name="host_id[]" value="{$row2[id]}">
				<input class="text" type="text" name="host[]" value="{$row2[name]}" size="14">
			</td>
			<td><input class="text" type="text" name="ttl[]" size="1" value="{$row2[ttl]}"></td>
			<td class="longSelect formElement">
				<select name="type[]">
					<option label="A" value="A"{if $row2[type] == "A"} selected="selected"{/if}>A</option>
					<option label="AAAA" value="AAAA"{if $row2[type] == "AAAA"} selected="selected"{/if}>AAAA</option>
					<option label="CNAME" value="CNAME"{if $row2[type] == "CNAME"} selected="selected"{/if}>CNAME</option>
					<option label="MX" value="MX"{if $row2[type] == "MX"} selected="selected"{/if}>MX</option>
					<option label="NS" value="NS"{if $row2[type] == "NS"} selected="selected"{/if}>NS</option>
					<option label="PTR" value="PTR"{if $row2[type] == "PTR"} selected="selected"{/if}>PTR</option>
					<option label="SRV" value="SRV"{if $row2[type] == "SRV"} selected="selected"{/if}>SRV</option>
					<option label="TXT" value="TXT"{if $row2[type] == "TXT"} selected="selected"{/if}>TXT</option>
				</select>
			</td>
			<td><input class="text" type="text" name="pri[]" size="1" value="{$row2[aux]}"></td>
			<td><input class="text" type="text" name="destination[]" size="14" value="{$row2[data]}"></td>
			<td><center><input type="checkbox" name="delete[]" /></center></td>
		</tr>
		{/foreach}
		<tr>
			<td colspan="6"><hr size="1" noshade></td>
		</tr>
		<tr>
			<td><input class="text" type="text" name="newhost" size="14"></td>
			<td><input class="text" type="text" name="newttl" size="1" value="{$conf[minimum_ttl]}"></td>
			<td class="longSelect formElement"><select name="newtype"><option label="A" value="A" selected="selected">A</option><option label="AAAA" value="AAAA">AAAA</option><option label="CNAME" value="CNAME">CNAME</option><option label="MX" value="MX">MX</option><option label="NS" value="NS">NS</option><option label="PTR" value="PTR">PTR</option><option label="SRV" value="SRV">SRV</option><option label="TXT" value="TXT">TXT</option></select></td>
			<td><input class="text" type="text" name="newpri" size="1" value="0"></td>
			<td><input class="text" type="text" name="newdestination" size="14"></td>
			<td>&nbsp;</td>
		</tr>
		<tr class="odd">
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>
				<input type="hidden" name="total" value="{$i}">
				<input name="Submit" type="submit" value="Save">
			</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>
</form>
</div>
{include file="footer"}
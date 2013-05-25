<?php
/* page/help.php - myDNS-WI
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
?>
<h2><a href="?page=main">DNS</a> &raquo; <a href="#" class="active">Help</a></h2>
<div id="main">
<b>Forward DNS and Reverse DNS (A and PTR)</b><br />
The Address (A) record associates a domain name with an IP address, which is the primary purpose of the DNS system.  The Pointer (PTR) record provides data for reverse DNS, which is used for logging the domain name and verification purposes.  Also called "reverse DNS," the PTR record is an option.  See <a href="http://www.pcmag.com/encyclopedia/term/50493/reverse-dns">reverse DNS</a>.<br />
<br />

<b>AAAA Record</b><br />
AAAA records store a 128-bit Internet Protocol version 6 (IPv6) address that does not fit the standard A record format.<br />
For example, 2007:0db6:85a3:0000:0000:6a2e:0371:7234 is a valid 128-bit/IPv6 address.<br />
<br />
<b>Aliasing Names (CNAME)</b><br />
The Canonical Name (CNAME) record is used to create aliases that point to other names.  It is commonly used to map WWW, FTP and MAIL subdomains to a domain name; for example, a CNAME record can associate the subdomain FTP.COMPUTERLANGUAGE.COM with COMPUTERLANGUAGE.COM.<br />
<br />

<b>DNS Name Servers (NS)</b><br />
The Name Server (NS) record identifies the authoritative DNS servers for a domain.  A second name server is required for redundancy, and two NS records must be in the zone file (one for the primary; one for the secondary).  The secondary server queries the primary server for changes.<br />
<br />

<b>Mail Servers (MX)</b><br />
The Mail Exchange (MX) record identifies the server to which e-mail is directed.  It also contains a priority field so that mail can be directed to multiple servers in a prescribed order.<br />
<br />

<b>Text Record (TXT)</b><br />
A TXT record can be used for any kind of documentation.  It is also used to provide information to the SPF e-mail authentication system.  See <a href="http://www.pcmag.com/encyclopedia/term/51853/spf">SPF</a>.<br />
<br />

<b>SRV Record</b><br />
SRV records are resource records used to identify computers hosting specific services.<br />
The data column must contain three space-separated values.<br />
The first value is a number specifying the weight for this entry.<br />
The second field is a number specifying the port on the target<br />
host of this service. The last field is a name specifying the target host.<br /><br />
<?php
// TODO
// HELP FOR CNAME
// HELP FOR SRV http://pastie.org/pastes/7828064/text?key=kkmybxzl07ajhwzwjwshw
// Es darf nicht mehr als einen SPF/TXT-Record geben, der mit v=spf1 beginnt das resultiert in abgewiesenen Mails https://tools.ietf.org/html/rfc4408#section-3.1.2
?>
</div>

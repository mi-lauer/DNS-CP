<?php
/* config.sample.php - DNS-WI
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

// config
// database
$database["typ"]        = "mysql";                    // Database typ (available: mysql, pgsql and sqlite) 
$database["host"]       = "localhost";                // Database host
$database["port"]       = "3306";                     // Database port
$database["user"]       = "dns";                      // Database user
$database["pw"]         = "dns";                      // Database password
$database["db"]         = "dns";                      // MyDNS Database

// database tables
$conf["soa"]            = "dns_soa";                  // SOA Table
$conf["rr"]             = "dns_rr";                   // RR Table
$conf["users"]          = "dns_users";                // Users Table

// general
$conf["name"]           = "OwnDNS";                   // Name of Page
$conf["lang"]           = "en";                       // Site Language

// server
$conf["server"]         = "mydns";                    // Server typ (available: mydns, bind9, powerdns, api)

// api
$conf['apikey']         = "";                         // access key for the api
$conf['enableapi']      = false;                      // enable the api true/false

// remote management api servers
$conf['useremoteapi']   = false;                      // use remote api true/false
$conf['api'][0]['url']  = "";                         // url to remote api
$conf['api'][0]['key']  = "";                         // key for the remote api

// Default values on create
$conf["mbox"]           = "info.owndns.me.";          // mbox for SOA
$conf["soans"]          = "ns1.owndns.me.";           // NS for SOA
$conf["ns"]             = array("ns1.owndns.me.", "ns2.owndns.me.", "ns3.owndns.me.", "ns4.owndns.me.", "ns5.owndns.me.");
$conf["a"]              = "127.0.0.1";                // A record for new zone
$conf["aaaa"]           = Null;                       // AAAA record for new zone
$conf["txt"]            = "v=spf1 mx -all";           // TXT record for new zone
$conf["ttl"]            = 86400;                      // TTL of soa record
$conf["refresh"]        = 28800;                      // Refresh of soa record
$conf["retry"]          = 7200;                       // Retry of soa record
$conf["expire"]         = 604800;                     // Expire of soa record
$conf["minimum_ttl"]    = 60;                         // Minimum ttl for some records
?>

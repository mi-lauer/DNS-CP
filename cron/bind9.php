<?php
if(!defined('STDIN')) die();
require_once("../config.php");
require_once("../lib/system/system.class.php");
// set system variables
system::set_conf($conf);
system::set_database($database);
require_once("../lib/system/db.class.php");
DB::connect();
require_once("../lib/server/server.class.php");
require_once("../lib/server/".$conf['server'].".server.class.php");
require_once("../lib/system/user.class.php");
require_once("../lib/system/func.class.php");
$zones = server::get_all_zones();
if(file_exists("domains.cfg")) unlink("domains.cfg");
foreach ($zones as $zone) {
	if(file_exists($zone['origin'].".db")) unlink($zone['origin'].".db");
	$cout = "zone \"" . $zone['origin'] . "\" {
	type master;
	file \"".$zone['origin'].".db\";
};\n\n";

	$out = $zone['origin']."       IN      SOA     " . $zone['ns'] . " " . $zone['mbox'] . " (
			" . $zone['serial'] . " \t; Serial
			" . $zone['refresh'] . " \t\t; Refresh
			" . $zone['retry'] . " \t\t; Retry
			" . $zone['expire'] . " \t; Expire
			" . $zone['minimum'] . ")\t\t; Negative Cache TTL
;\n" ;
	$records = server::get_all_records($zone['id']);
	foreach ($records as $record) {
		$out .= $record['name'] . "\t ".$record['ttl']."\tIN\t" . $record['type'] . "\t" . ($record['type'] == "MX" ? $record['aux'] : "") . "\t" . $record['data'] . "\n";
	}
    $handler = fOpen("domains.cfg" , "a+");
    fWrite($handler , $cout);
    fClose($handler);
    $handler = fOpen($zone['origin'].".db" , "a+");
    fWrite($handler , $out);
    fClose($handler);
}
DB::close();
?>
<?php
/* lib/system/dns.class.php - DNS-WI
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
namespace DNS\system;

class dns {
	/**
	 * convert time to string
	 *
	 * @param 	integer 	$time
	 * @param	integer		$anz
	 * @return	stting
	 */
	function time2str($time, $anz = 9) {
		$str="";
		if(!$anz) $anz=9;
		if($time>=(60*60*24*365) && $anz > 0) {
			$anz--;
			$years=floor($time/(60*60*24*365));
			$str.=$years."Y";
			$time=$time-((60*60*24*365)*$years);
		}
		if($time>=(60*60*24*30) && $anz > 0) {
			$anz--;
			$months=floor($time/(60*60*24*30));
			if($str != "") $str.=" ";
			$str.=$months."M";
			$time=$time-((60*60*24*30)*$months);
		}
		if($time>=(60*60*24) && $anz > 0) {
			$anz--;
			$days=floor($time/(60*60*24));
			if($str != "") $str.=" ";
			$str.=$days."d";
			$time=$time-((60*60*24)*$days);
		}
		if($time>=(60*60) && $anz > 0) {
			$anz--;
			$stunden=floor($time/(60*60));
			if($str != "") $str.=" ";
			$str.=$stunden."h";
			$time=$time-((60*60)*$stunden);
		}
		if($time>=(60) && $anz > 0) {
			$anz--;
			$min=floor($time/(60));
			if($str != "") $str.=" ";
			$str.=$min."m";
			$time=$time-((60)*$min);
		}
		if(($time>1 || $str == "") && $anz > 0){
			$anz--;
			if($str != "") $str.=" ";
			$str.=$time."s";
		}
		return $str;
	}

	/**
	 * show sub records of dns request
	 *
	 * @param	string	$host
	 * @return	string
	 */
	function show_subrecords($host) {
		$return = "";
		$dns = dns_get_record($host, DNS_ALL);
		if(count($dns)) {
			usort($dns, array($this, "sort_records"));
			foreach($dns as $record) {
				switch($record['type']) {
					case "A":
						$return .="   <b>A     </b> ".$record['ip'].($record['ttl'] < 86400 ? "  (ttl: ".$this->time2str($record['ttl'],2).")" : "")."\n";
						break;
					case "AAAA":
						$return .="   <b>AAAA  </b> ".$record['ipv6'].($record['ttl'] < 86400 ? "  (ttl: ".$this->time2str($record['ttl'],2).")" : "")."\n";
						break;
					case "CNAME":
						$return .="   <b>CNAME </b> ".$record['target']."\n";
						break;
				}
			}
		}
		return $return;
	}

	/**
	 * sort dns records
	 *
	 * @param	array	$a
	 * @param	array	$b
	 * @return	array
	 */
	static function sort_records($a, $b) {
		$record_order = array("SOA", "NS", "A", "AAAA", "MX");
		$index_a = array_search($a['type'], $record_order);
		if($index_a === FALSE) $index_a = count($record_order);
		$index_b = array_search($b['type'], $record_order);
		if($index_b === FALSE) $index_b = count($record_order);
		$order = $index_a - $index_b;
		if($order == 0 && isset($record)) {
			switch($record['type']) {
				case "A":
					$suborder = "ip";
					break;
				case "AAAA":
					$suborder = "ipv6";
					break;
				case "TXT":
					$suborder = "txt";
					break;
				default:
					$suborder = "target";
					break;
			}
			$order = strcmp($a[$suborder], $b[$suborder]);
		}
		return $order;
	}
	
	/**
	 * get dns records
	 *
	 * @param	string	$host
	 * @param	string	$show_record
	 * @return	string
	 */
	function get ($host,$show_record = Null) {
		$pattern_ipv6 = '/^((([0-9A-Fa-f]{1,4}:){7}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){6}:[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){5}:([0-9A-Fa-f]{1,4}:)?[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){4}:([0-9A-Fa-f]{1,4}:){0,2}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){3}:([0-9A-Fa-f]{1,4}:){0,3}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){2}:([0-9A-Fa-f]{1,4}:){0,4}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){6}((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|(([0-9A-Fa-f]{1,4}:){0,5}:((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|(::([0-9A-Fa-f]{1,4}:){0,5}((\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b)\.){3}(\b((25[0-5])|(1\d{2})|(2[0-4]\d)|(\d{1,2}))\b))|([0-9A-Fa-f]{1,4}::([0-9A-Fa-f]{1,4}:){0,5}[0-9A-Fa-f]{1,4})|(::([0-9A-Fa-f]{1,4}:){0,6}[0-9A-Fa-f]{1,4})|(([0-9A-Fa-f]{1,4}:){1,7}:))(|\/[0-9]{1,3})$/';
		$pattern_ipv4 = '/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}(|\/[0-9]{1,2})$/';
		$return ="";
		if(strlen($host) && preg_match("#^((([a-z0-9-.]*)\.|)([a-z]{2,5})|).?$#i", $host)) {
			$dns = dns_get_record($host, DNS_ALL);
			$return .="DNS Records for <b>".$host."</b>:";
			if($show_record != "" && $show_record != "*" && $show_record != "ANY") {
				$show_record = strtoupper($show_record);
				$return .=" (".$show_record.")";
			}
			$return .="\n";
			if(count($dns)) {
				usort($dns, array($this, "sort_records"));
				foreach($dns as $record) {
					if($show_record != "" && $show_record != "*" && $show_record != "ANY" && $show_record != $record['type'])
						continue;
					switch($record['type']) {
						case "A":
							$return .=" <b>A     </b> ".$record['ip'].($record['ttl'] < 86400 ? "  (ttl: ".$this->time2str($record['ttl'],2).")" : "")."\n";
							break;
						case "AAAA":
							$return .=" <b>AAAA  </b> ".$record['ipv6'].($record['ttl'] < 86400 ? "  (ttl: ".$this->time2str($record['ttl'],2).")" : "")."\n";
							break;
						case "MX":
							$return .=" <b>MX    </b> ".$record['target']." (priority: ".$record['pri'].")\n";
							$return .= $this->show_subrecords($record['target']);
							break;
						case "NS":
							$return .=" <b>NS    </b> ".$record['target']."\n";
							$return .= $this->show_subrecords($record['target']);
							break;
						case "CNAME":
							$return .=" <b>CNAME </b> ".$record['target']."\n";
							break;
						case "TXT":
							$return .=" <b>TXT   </b> ".$record['txt']."\n";
							break;
						case "SOA":
							$mail = explode(".",$record['rname'],2);
							$return .=" <b>SOA   </b> (Start of Authority):\n";
							$return .="   name:        ".$record['mname']."\n";
							$return .="   admin:       ".$mail[0]."@".$mail[1]."\n";
							$return .="   serial:      ".$record['serial']."\n";
							$return .="   refresh:     ".$record['refresh']." (".$this->time2str($record['refresh'], 2).")\n";
							$return .="   retry:       ".$record['retry']." (".$this->time2str($record['retry'], 2).")\n";
							$return .="   expire:      ".$record['expire']." (".$this->time2str($record['expire'], 2).")\n";
							$return .="   TTL:         ".$record['ttl']." (".$this->time2str($record['ttl'], 2).")\n";
							$return .="   minimum-ttl: ".$record['minimum-ttl']." (".$this->time2str($record['minimum-ttl'], 2).")\n";
							break;
					}
				}
			} else {
				$return .="No records found.\n";
			}
		} elseif(preg_match($pattern_ipv4, $host) || preg_match($pattern_ipv6, $host)) {
			$hostname = gethostbyaddr($host);
			$return .="Reverse Lookup for <b>".$host."</b>:\n";
			$return .= " <b>PTR  </b> ".$hostname."\n";
		} else {
			$return .="Invalid Hostname or IP-Address.\n";
		}
		return $return;
	}
}
?>

<?php
/**
 * Smarty-Light urlencode modifier plugin
 *
 * Type:     modifier
 * Name:     urlencode
 * Purpose:  urlencode vars (only if they were assigned/defined) function
 * Author:   axel
 */
function tpl_modifier_urlencode($data) {
	if (is_array($data) && function_exists("http_build_query")) {
		return http_build_query($data);
	} else {
		return urlencode($data)
	}

	$_args = explode( ",", $params["vars"] );
	$url = array();
	foreach($_args as $val) {
		$var = $tpl->get_vars( trim( $val ) );
		if( $var != null ) {
			$url[ $val ] = $var;
		}
	}
	return http_build_query($url);
}
?>
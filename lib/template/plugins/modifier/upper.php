<?php
/**
 * Smarty-Light upper modifier plugin
 *
 * Type:     modifier
 * Name:     upper
 * Purpose:  Wrapper for the PHP 'strtoupper' function
 */
function tpl_modifier_upper($string) {
	return strtoupper($string);
}
?>
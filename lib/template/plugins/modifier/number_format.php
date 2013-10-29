<?php
/**
 * Smarty-Light number_format modifier plugin
 *
 * Type:     modifier
 * Name:     number_format
 * Purpose:  Wrapper for the PHP 'number_format' function
 */
function tpl_modifier_number_format($string, $decimals = 0, $decimal_point = '.', $thousands_sep = ',') {
	return number_format($string, $decimals, $decimal_point, $thousands_sep);
}
?>
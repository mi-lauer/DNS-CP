<?php
/**
 * Smarty {html_radio} function plugin
 *
 * Type:     function
 * Name:     radio
 * Purpose:  Creates a radio button
 * Input:
 *           - name = the name of the radio button
 *           - value = optional value for the checkbox
 *           - checked = boolean - whether the box is checked or not
 * Author:   Paul Lockaby <paul@paullockaby.com>
 */
function tpl_function_html_radio($params, &$tpl) {
	$name = null;
	$value = '';
	$extra = '';

	foreach($params as $_key => $_value) {
		switch($_key) {
			case 'name':
			case 'value':
				$$_key = $_value;
				break;
			default:
				if(!is_array($_key)) {
					$extra .= ' ' . $_key . '="' . $tpl->_escape_chars($_value) . '"';
				} else {
					$tpl->trigger_error("html_radio: attribute '$_key' cannot be an array");
				}
		}
	}

	if (!isset($name) || empty($name)) {
		$tpl->trigger_error("html_radio: missing 'name' parameter");
		return;
	}

	$toReturn = '<input type="RADIO" name="' . $tpl->_escape_chars($name) . '" value="' . $tpl->_escape_chars($value) . '"';
	if (isset($checked))
		$toReturn . = ' checked';
	$toReturn .= ' ' . $extra . ' />';
	return $toReturn;
}
?>
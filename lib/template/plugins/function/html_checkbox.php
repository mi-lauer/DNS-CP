<?php
/**
 * Smarty {html_checkbox} function plugin
 *
 * Type:     function
 * Name:     textbox
 * Purpose:  Creates a checkbox
 * Input:
 *           - name = the name of the checkbox
 *           - value = optional value for the checkbox
 *           - checked = boolean - whether the box is checked or not
 * Author:   Paul Lockaby <paul@paullockaby.com>
 */
function tpl_function_html_checkbox($params, &$tpl) {
	$name = null;
	$value = null;
	$checked = null;
	$extra = '';

	foreach($params as $_key => $_value) {
		switch($_key) {
			case 'name':
			case 'value':
				$$_key = $_value;
				break;
			case 'checked':
				if ($_key == 'true' || $_key == 'yes' || $_key == 'on') {
					$$_key = true;
				} else {
					$$_key = false;
				}
				break;
			default:
				if(!is_array($_key)) {
					$extra .= ' ' . $_key . '="' . $tpl->_escape_chars($_value) . '"';
				} else {
					$tpl->trigger_error("html_checkbox: attribute '$_key' cannot be an array");
				}
		}
	}

	if (!isset($name) || empty($name)) {
		$tpl->trigger_error("html_checkbox: missing 'name' parameter");
		return;
	}

	$toReturn = '<input type="CHECKBOX" name="' . $tpl->_escape_chars($name) . '"';
	if ($checked)
		$toReturn .= ' checked';
	if (isset($value))
		$toReturn .= ' value="' . $tpl->_escape_chars($value) . '"';
	$toReturn .= ' ' . $extra . ' />';
	return $toReturn;
}
?>
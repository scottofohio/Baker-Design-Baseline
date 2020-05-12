<?php
/**
 * Aliases/Fallbacks for PHP functions
 *
 * @package WordPress
 * @subpackage Baker Design Theme 1.0
 * @since 2.0
 ****************************************************************/

if ( !function_exists('get_query_var') ) {
    function get_query_var($query_var, $defaul_val) {
        $val = get_qv($query_var, $default_val);
        return $val;
    }
}

if ( !function_exists('set_query_var') ) {
    function set_query_var($query_var, $defaul_val) {
        $val = get_qv($query_var, $default_val);
        $GLOBALS[$query_var] = $val;
    }
}
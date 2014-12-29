<?php

/**
 * Model File
 * Handles to database functionality & other functions
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
* Escape Attr
*/
function esb_pg_escape_attr($data){

    if( !empty( $data ) ) {
        $data = esc_attr(stripslashes_deep($data));
    }
    return $data;
}

/**
* Strip Slashes From Array
*/
function esb_pg_escape_slashes_deep($data = array(),$flag=true){

    if($flag != true) {
            $data = esb_pg_nohtml_kses($data);
    }
    $data = stripslashes_deep($data);
    return $data;
}

/**
* Strip Html Tags 
* 
* It will sanitize text input (strip html tags, and escape characters)
*/
function esb_pg_nohtml_kses($data = array()) {

    if ( is_array($data) ) {

            $data = array_map(array($this,'esb_pg_nohtml_kses'), $data);

    } elseif ( is_string( $data ) ) {

            $data = wp_filter_nohtml_kses($data);
    }

    return $data;
}

/**
 * Convert Object To Array
 */
function esb_pg_object_to_array($result) {

    $array = array();
    foreach ($result as $key=>$value)
    {	
        if (is_object($value)) {
            $array[$key]=esb_pg_object_to_array($value);
        } else {
            $array[$key]=$value;
        }
    }
    return $array;
}

/**
 * Get Date Format
 * 
 * Handles to return formatted date which format is set in backend
 */
function esb_pg_get_date_format( $date, $time = false ) {

    $format = $time ? get_option( 'date_format' ).' '.get_option('time_format') : get_option('date_format');
    $date = date_i18n( $format, strtotime($date));
    return $date;
}

/**
 * Get Absulate path
 */
function esb_pg_get_absulate_path( $url ) {
    
    $abs = '';
    if( !empty( $url ) ) {
        
        $upload_path = wp_upload_dir();
        $abs = str_replace($upload_path['baseurl'], $upload_path['basedir'], $url);
    }
    return $abs;
}

?>
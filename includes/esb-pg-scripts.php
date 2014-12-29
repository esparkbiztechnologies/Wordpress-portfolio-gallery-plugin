<?php

/**
 * Scripts File
 * Handles to admin functionality & other functions
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Load Admin styles & scripts
 */
function esb_pg_admin_scripts(){
    
     // Load our admin stylesheet.
     wp_enqueue_style( 'esb-pg-admin-style', ESB_PG_URL . '/css/admin-style.css' );
}

//add action to load scripts and styles for the back end
add_action( 'admin_enqueue_scripts', 'esb_pg_admin_scripts' );

/**
 * Load Public styles & scripts
 */
function esb_pg_public_scripts(){

     // Load our jquery prettyPhoto stylesheet.
     wp_enqueue_style( 'esb-pg-prettyphoto-style', ESB_PG_URL . '/css/prettyPhoto.css' );
     
     // Load our public stylesheet.
     wp_enqueue_style( 'esb-pg-public-style', ESB_PG_URL . '/css/public-style.css' );

     // Load jQuery
     wp_enqueue_script( 'jquery' );

     // Load our jquery prettyPhoto script.
     wp_enqueue_script( 'esb-pg-jquery-prettyphoto-script', ESB_PG_URL . '/js/jquery.prettyPhoto.js' );
     
     // Load our public script.
     wp_enqueue_script( 'esb-pg-public-script', ESB_PG_URL . '/js/public-script.js' );
     wp_localize_script( 'esb-pg-public-script', 'LtPublic', array(
                                                                    'ajaxurl'           => admin_url( 'admin-ajax.php', ( is_ssl() ? 'https' : 'http' ) )
                                                                ) );
}

//add action to load scripts and styles for the front end
add_action( 'wp_enqueue_scripts', 'esb_pg_public_scripts' );

?>
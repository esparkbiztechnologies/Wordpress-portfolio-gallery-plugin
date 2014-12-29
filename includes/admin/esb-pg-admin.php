<?php

/**
 * Admin File
 * Handles to admin functionality & other functions
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Custom Meta box for post type.
 */
function esb_pg_meta_box() {

    add_meta_box( 'esb_pg_portfolio_meta', __( 'Portfolio Options', 'esbpg' ), 'esb_pg_portfolio_meta_options_page', ESB_PG_POST_TYPE, 'normal', 'high' );
    
}

/**
 * Portfolio Meta Options
 */
function esb_pg_portfolio_meta_options_page(){
    
    include ESB_PG_DIR . '/includes/admin/views/esb-pg-portfolio-meta.php';
}

/**
 * Save Meta for post type.
 */
function esb_pg_save_meta( $post_id ) {
    
    $prefix = ESB_PG_META_PREFIX;
    
    /* Save Meta For Portfolio Post Type */
    if(isset( $_POST['post_type'] ) && $_POST['post_type'] == ESB_PG_POST_TYPE ) {
        
        if( isset( $_POST[$prefix.'video_url'] ) ) {
            update_post_meta( $post_id, $prefix.'video_url', esb_pg_escape_slashes_deep( $_POST[$prefix.'video_url'] ) );
        }
        if( isset( $_POST[$prefix.'custom_code'] ) ) {
            update_post_meta( $post_id, $prefix.'custom_code', esb_pg_escape_slashes_deep( $_POST[$prefix.'custom_code'], true ) );
        } 
    }
}

//add action to create custom meta box
add_action( 'admin_init', 'esb_pg_meta_box' );

//add action to save custom meta
add_action( 'save_post', 'esb_pg_save_meta' );

?>
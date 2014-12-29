<?php

/**
 * Custom Post Types & Taxonomies File
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Register a Portfolio post type.
 */
function esb_pg_register_post_type() {
    
    $labels = array(
            'name'               => _x( 'Portfolios', 'esb_portfolio', 'esbpg' ),
            'singular_name'      => _x( 'Portfolio', 'esb_portfolio', 'esbpg' ),
            'menu_name'          => _x( 'Portfolios', 'esb_portfolio', 'esbpg' ),
            'name_admin_bar'     => _x( 'Portfolio', 'esb_portfolio', 'esbpg' ),
            'add_new'            => _x( 'Add New', 'esb_portfolio', 'esbpg' ),
            'add_new_item'       => __( 'Add New Portfolio', 'esbpg' ),
            'new_item'           => __( 'New Portfolio', 'esbpg' ),
            'edit_item'          => __( 'Edit Portfolio', 'esbpg' ),
            'view_item'          => __( 'View Portfolio', 'esbpg' ),
            'all_items'          => __( 'All Portfolios', 'esbpg' ),
            'search_items'       => __( 'Search Portfolio', 'esbpg' ),
            'parent_item_colon'  => __( 'Parent Portfolio:', 'esbpg' ),
            'not_found'          => __( 'No portfolio found.', 'esbpg' ),
            'not_found_in_trash' => __( 'No portfolio found in Trash.', 'esbpg' ),
    );

    $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'portfolio' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail' ),
    );

    register_post_type( ESB_PG_POST_TYPE, $args );
     
}

//Post Type For Portfolio
add_action( 'init', 'esb_pg_register_post_type' );

?>
<?php
/*
Plugin Name: ESB Portfolio Gallery
Plugin URI: https://wordpress.org/plugins/esb-portfolio-gallery/
Description: Display portfolio with popup gallery, also used with shortcode & widget.
Version: 1.0.0
Author: Henry
Author URI: http://esparkinfo.com/
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if( !defined( 'ESB_PG_DIR' ) ) {
    define('ESB_PG_DIR', dirname( __FILE__ ) ); // plugin dir
}
if( !defined( 'ESB_PG_URL' ) ) {
    define('ESB_PG_URL', plugin_dir_url( __FILE__ ) ); // plugin url
}
if( !defined( 'ESB_PG_META_PREFIX' ) ) {
    define( 'ESB_PG_META_PREFIX', '_esb_pg_' ); // meta box prefix
}
if( !defined('ESB_PG_POST_TYPE' ) ) {
    define('ESB_PG_POST_TYPE', 'esb_portfolio' ); // custom post type's slug
}
if( !defined('ESB_PG_BASENAME') ){
    define('ESB_PG_BASENAME', 'esb_portfolio_gallery');  // plugin base name
}
//include post type file
include ESB_PG_DIR . '/includes/esb-pg-post-types.php';

/**
 * Load Text Domain
 *
 * This gets the plugin ready for translation.
 */

function esb_pg_load_textdomain() {

  load_plugin_textdomain( 'esbpg', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

}
add_action( 'init', 'esb_pg_load_textdomain' ); 

/**
 * Activation Hook
 *
 * Register plugin activation hook.
 */
register_activation_hook( __FILE__, 'esb_pg_install' );

/**
 * Deactivation Hook
 *
 * Register plugin deactivation hook.
 */
register_deactivation_hook( __FILE__, 'esb_pg_uninstall');

/**
 * Plugin Setup (On Activation)
 *
 * Does the initial setup,
 * stest default values for the plugin options.
 */
function esb_pg_install() {
    
    global $user_ID;
    
    //register custom post type
    esb_pg_register_post_type();

    //IMP Call of Function
    //Need to call when custom post type is being used in plugin
    flush_rewrite_rules();

    //get option for when plugin is activating first time
    $esb_pg_set_option = get_option( 'esb_pg_set_option' );

    if( empty( $esb_pg_set_option ) ) { //check plugin version option

        $esb_pg_options = array();
        
        //update plugin options
        update_option( 'esb_pg_options', $esb_pg_options );
        
        //update plugin version to option 
        update_option( 'esb_pg_set_option', '1.0' );
    }
}

/**
 * Plugin Setup (On Deactivation)
 *
 * Delete plugin options.
 */
function esb_pg_uninstall() {
    
    //register custom post type
    esb_pg_register_post_type();

    //IMP Call of Function
    //Need to call when custom post type is being used in plugin
    flush_rewrite_rules();
    
}

global $esb_pg_options;
$esb_pg_options = get_option( 'esb_pg_options' );

//include model file
include ESB_PG_DIR . '/includes/esb-pg-model.php';

//include scripts file
include ESB_PG_DIR . '/includes/esb-pg-scripts.php';

//include shortcode file
include ESB_PG_DIR . '/includes/esb-pg-shortcode.php';

//include admin file
include ESB_PG_DIR . '/includes/admin/esb-pg-admin.php';

//include public file
include ESB_PG_DIR . '/includes/esb-pg-public.php';

//Load Order Widget File
require_once( ESB_PG_DIR . '/includes/widgets/class-esb-pg-portfolio.php' );

?>
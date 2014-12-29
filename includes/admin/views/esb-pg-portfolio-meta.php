<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

global $post;

$prefix = ESB_PG_META_PREFIX;

$post_id = $post->ID;

$video_url  = get_post_meta( $post_id, $prefix . 'video_url', true );
$custom_code= get_post_meta( $post_id, $prefix . 'custom_code', true );

?>
<table class="form-table esb-pg-form-table">
    
    <tr>
        <td>
            <label for="<?php echo $prefix ?>video_url"><?php _e( 'Video URL (Youtube, Vimeo)', 'esbpg' ) ?></label>
        </td>
        <td>
            <input type="text" name="<?php echo $prefix ?>video_url" id="<?php echo $prefix ?>video_url" class="regular-text" value="<?php echo esb_pg_escape_attr($video_url); ?>" />
        </td>
    </tr>
    <tr>
        <td>
            <label for="<?php echo $prefix ?>custom_code"><?php _e( 'Custom Embed Code', 'esbpg' ) ?></label>
        </td>
        <td>
            <textarea name="<?php echo $prefix ?>custom_code" id="<?php echo $prefix ?>custom_code" cols="37" rows="4"><?php echo $custom_code; ?></textarea>
        </td>
    </tr>
    
</table>
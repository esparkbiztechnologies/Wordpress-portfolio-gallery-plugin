<?php

/**
 * Custom Shortcodes File
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Display portfolio gallery
 * 
 * Handles to display portfolio gallery with image, video or custom code
 */
function esb_pg_portfolio_gallery( $atts, $content ){
    
    global $post;

    $prefix = ESB_PG_META_PREFIX;

    ob_start();
    
    $reqportfolioargs = array(
                                'post_type'     => ESB_PG_POST_TYPE,
                                'post_status'   => 'publish',
                                'posts_per_page'=> '-1'
                            );

    //fire query in to table for retriving data
    $reqportfolios_query = new WP_Query( $reqportfolioargs );

    if ( $reqportfolios_query->have_posts() ) { 

        $i = 0;
        while ( $reqportfolios_query->have_posts() ) {
            $reqportfolios_query->the_post();
            $i++;

                $video_url  = get_post_meta( $post->ID, $prefix . 'video_url', true );
                $custom_code= get_post_meta( $post->ID, $prefix . 'custom_code', true );

                $image_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );

                if ( strpos($video_url,'youtube' ) !== false ) {

                    $video_embed_url = str_replace('watch?v=', 'embed/', $video_url);
                    
                    $video_id = str_replace('http://www.youtube.com/embed/', '', $video_embed_url);
                    $video_id = str_replace('https://www.youtube.com/embed/', '', $video_id);

                    $image_url = 'http://i1.ytimg.com/vi/'. $video_id .'/mqdefault.jpg';

                    $videophoto_code = '<iframe width="100%" height="350px" src="'.$video_embed_url.'" frameborder="0" allowfullscreen></iframe>';

                } else if( strpos($video_url,'vimeo' ) !== false ) {

                    $video_embed_url = str_replace('vimeo.com/', 'player.vimeo.com/video/', $video_url);

                    $video_id = str_replace('http://vimeo.com/', '', $video_url);
                    $video_id = str_replace('https://vimeo.com/', '', $video_id);
                    $video_embed_url = str_replace('vimeo.com/', 'player.vimeo.com/video/', $video_url);

                    $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_id.php"));

                    if( !empty( $hash[0] ) && !empty( $hash[0]['thumbnail_large'] ) ) {
                        $image_url = $hash[0]['thumbnail_large'];
                    }
                    $videophoto_code = '<iframe width="100%" height="350px" src="'.$video_embed_url.'" frameborder="0" allowfullscreen></iframe>';

                } else if( empty ( $video_url ) && !empty ( $custom_code ) ) {

                    $videophoto_code = $custom_code;
                    
                } else {
                    
                    $videophoto_code = '<img src="'. $image_url .'" alt="" />';
                }
                ?>
                    <div class="esb-pg-videophoto-box-wrap">
                        <a title="<?php the_title() ?>" href="#esb_pg_videophoto_box<?php echo $i ?>" rel="prettyPhoto">
                            <img class="esb-img" src="<?php echo $image_url ?>" alt="" />
                        </a>
                        <div id="esb_pg_videophoto_box<?php echo $i ?>" class="esb-pg-display-none">
                            <?php echo $videophoto_code ?>
                        </div>
                    </div>
                <?php
        }
        echo '<div class="clear"></div>';
        //Reset Query
        wp_reset_query();
    }
    
    return ob_get_clean();
}

//add shortcode for diplay portfolio gallery
add_shortcode( 'esb_pg_portfolio_gallery', 'esb_pg_portfolio_gallery' );

?>
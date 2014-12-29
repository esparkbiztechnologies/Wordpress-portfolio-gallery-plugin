<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

add_action( 'widgets_init', 'esb_pg_portfolio_list_widget' );

/**
 * Register the Portfolio Widget
 */
function esb_pg_portfolio_list_widget() {
    register_widget( 'Esb_Pg_Order' );
}

class Esb_Pg_Order extends WP_Widget {

    /**
     * Widget setup.
     */
    function Esb_Pg_Order() {

        /* Widget settings. */
        $widget_ops = array( 'classname' => 'esb-pg-order', 'description' => __( 'A ESB Portfolio widget, which display portfolio with image, video or custom code.', 'esbpg' ) );

        /* Create the widget. */
        $this->WP_Widget( 'esb-pg-order', __( 'ESB - Portfolio', 'esbpg' ), $widget_ops );

    }

    /**
     * Outputs the content of the widget
     */
    function widget( $args, $instance ) {

        global $post;
        
        extract( $args );

        $prefix = ESB_PG_META_PREFIX;

        echo $before_widget;

        $title      = apply_filters( 'widget_title', $instance['title'] );
        $no_of_port = !empty( $instance['no_of_port'] ) ? $instance['no_of_port'] : '-1';

        if( !empty( $title ) ) {
            
            echo $before_title . $title . $after_title;
        }
        
        $reqportfolioargs = array(
                                    'post_type'     => ESB_PG_POST_TYPE,
                                    'post_status'   => 'publish',
                                    'posts_per_page'=> $no_of_port
                                );

        //fire query in to table for retriving data
        $reqportfolios_query = new WP_Query( $reqportfolioargs );

        if ( $reqportfolios_query->have_posts() ) { 

            while ( $reqportfolios_query->have_posts() ) {
                $reqportfolios_query->the_post();

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
                        <div class="esb-pg-videophoto-box-wrap esb-pg-videophoto-box-widget">
                            <a title="<?php the_title() ?>" href="#esb_pg_videophoto_box<?php echo $i ?>" rel="prettyPhoto">
                                <img src="<?php echo $image_url ?>" alt="" />
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

        echo $after_widget;
    }
	
    /**
     * Updates the widget control options for the particular instance of the widget
     */
    function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        /* Set the instance to the new instance. */
        $instance = $new_instance;

        /* Input fields */
        $instance['title'] 	= strip_tags( $new_instance['title'] );
        $instance['no_of_port'] = strip_tags( $new_instance['no_of_port'] );

        return $instance;

    }
	
    /*
     * Displays the widget form in the admin panel
     */
    function form( $instance ) {

        $defaults = array( 'title' => __( 'Portfolio', 'esbpg' ), 'no_of_port' => '' );

        $instance = wp_parse_args( (array) $instance, $defaults );

        ?>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'esbpg'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'no_of_port' ); ?>"><?php _e( 'No. of Portfolio:', 'esbpg'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id( 'no_of_port' ); ?>" name="<?php echo $this->get_field_name( 'no_of_port' ); ?>" type="text" value="<?php echo $instance['no_of_port']; ?>" />
        </p>

        <?php
    }
}
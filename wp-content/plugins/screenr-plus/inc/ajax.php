<?php
class Screenr_Plus_Ajax {

    public static function init(){

        $action = $_REQUEST['screenr_ajax_action'];
        if( method_exists( 'Screenr_Plus_Ajax', $action ) ) {
            self::$action();
        }

    }

    static function load_portfolio_details( ) {

        $post_id = absint( $_REQUEST['post_id'] );
        ob_start();
        global $post;
        $post_id = apply_filters( 'wpml_object_id', $post_id, 'portfolio', true );
        $post= get_post( $post_id );
        if( $post ) {
            setup_postdata( $post );
            ?>
            <div class="portfolio-row table-row portfolio-ajax-c" data-id="<?php echo get_the_ID(); ?>">
                <div class="portfolio table-col portfolio-ajax-c-inner">
                    <div class="portfolio-content">

                        <a class="portfolio-close" href="#"></a>
                        <div class="container">
                           <div class="cold-md-12">
                               <?php the_content(); ?>
                           </div>
                       </div>

                    </div>
                </div>
            </div>
            <?php
        }
        $content = ob_get_clean();
        wp_send_json_success( $content );
        die();
    }
}

add_action( 'wp_ajax_screenr_plus_ajax', array( 'Screenr_Plus_Ajax', 'init' ) );
add_action( 'wp_ajax_nopriv_screenr_plus_ajax', array( 'Screenr_Plus_Ajax', 'init' ) );

<?php

class Screenr_Plus_Editor
{
    /**
     * Enqueue scripts/styles.
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public static function enqueue() {

        wp_enqueue_script( 'screenr-plus-customizer', SCREENR_PLUS_URL . 'assets/js/customizer.js', array( 'customize-controls', 'wp-color-picker' ) );
        wp_enqueue_style( 'screenr-plus-customizer',  SCREENR_PLUS_URL . 'assets/css/customizer.css' );

        wp_localize_script( 'screenr-plus-customizer', 'SCREENR_PLUS_CUSTOMIZER', array(
            'editor_controls' => apply_filters( 'screenr_editor_controls_keys',
                array(
                    'features_desc'         => 'textarea',
                    'about_desc'            => 'textarea',
                    'services_desc'         => 'textarea',
                    'portfolios_desc'       => 'textarea',
                    'clients_desc'          => 'textarea',
                    'gallery_desc'          => 'textarea',
                    'counter_desc'          => 'textarea',
                    'testimonials_desc'     => 'textarea',
                    'pricing_desc'          => 'textarea',
                    'team_desc'             => 'textarea',
                    'news_desc'             => 'textarea',
                    'contact_desc'          => 'textarea',
                    'contact_content'       => 'textarea',
                    'slider_items'          => 'repeater',
                    'sections_order_styling'=> 'repeater',
                )
            )
        ) );
        if ( ! class_exists( '_WP_Editors' ) ) {
            require(ABSPATH . WPINC . '/class-wp-editor.php');
        }

        add_action( 'customize_controls_print_footer_scripts', array( __CLASS__, 'enqueue_editor' ),  2 );
        add_action( 'customize_controls_print_footer_scripts', array( '_WP_Editors', 'editor_js' ), 50 );
        add_action( 'customize_controls_print_footer_scripts', array( '_WP_Editors', 'enqueue_scripts' ), 1 );
    }

    public  static function enqueue_editor(){
        if( ! isset( $GLOBALS['__wp_mce_editor__'] ) || ! $GLOBALS['__wp_mce_editor__'] ) {
            $GLOBALS['__wp_mce_editor__'] = true;
            ?>
            <script id="_wp-mce-editor-tpl" type="text/html">
                <?php wp_editor('', '__wp_mce_editor__'); ?>
            </script>
            <?php
        }
    }

}


add_action( 'customize_controls_enqueue_scripts', array( 'Screenr_Plus_Editor', 'enqueue' ), 99 );

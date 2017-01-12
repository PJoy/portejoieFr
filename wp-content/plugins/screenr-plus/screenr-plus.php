<?php
/*
Plugin Name: Screenr Plus
Plugin URI: https://www.famethemes.com/plugins/screenr-plus
Description: The Screenr Plus plugin adds powerful premium features to Screenr theme.
Author: famethemes
Author URI:  http://www.famethemes.com/
Version: 1.0.5
Text Domain: screenr-plus
License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

define( 'SCREENR_PLUS_URL',  trailingslashit( plugins_url('', __FILE__) ));
define( 'SCREENR_PLUS_PATH', trailingslashit( plugin_dir_path( __FILE__) ) );


/**
 * Do something when plugin active
 */
function screenr_register_order_styling_sections() {

}
register_activation_hook( __FILE__, 'screenr_register_order_styling_sections' );



/**
 * Class Screenr_PLus
 */
class Screenr_PLus {


    /**
     * Cache section settings
     *
     * @var array
     */
    public $section_settings = array();

    /**
     * Custom CSS code
     *
     * @var string
     */
    public $custom_css = '';


    function __construct(){

        load_plugin_textdomain( 'screenr-plus', false, SCREENR_PLUS_PATH . 'languages' );

        if ( ! function_exists( 'get_plugin_data' ) ) {
            require_once ABSPATH .'wp-admin/includes/plugin.php';
        }
        $plugin_data = get_plugin_data( __FILE__ );
        define( 'SCREENR_PLUS_VERSION', $plugin_data['Version'] );

        add_action( 'screenr_frontpage_section_parts', array( $this, 'load_section_parts' ) );
        add_filter( 'screenr_reepeatable_max_item', array( $this, 'unlimited_repeatable_items' ) );
        add_action( 'screenr_customize_after_register', array( $this, 'plugin_customize' ), 40 );
        add_action( 'wp', array( $this, 'int_setup' ) );
        add_action( 'wp_enqueue_scripts',  array( $this, 'custom_css' ) , 150 );
        add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ), 60 );

        require_once SCREENR_PLUS_PATH.'inc/post-type.php';
        require_once SCREENR_PLUS_PATH.'inc/template-tags.php';
        require_once SCREENR_PLUS_PATH.'inc/typography/helper.php';
        require_once SCREENR_PLUS_PATH.'inc/typography/auto-apply.php';
        require_once SCREENR_PLUS_PATH.'inc/ajax.php';
        require_once SCREENR_PLUS_PATH.'inc/customizer.php';

        /**
         * @todo Include custom template file
         */
        add_filter( 'template_include', array( $this, 'template_include' ) );

        /**
         * @todo add selective refresh
         */
        add_filter( 'screenr_customizer_selective_refresh_sections', array( $this, 'selective_refresh' ), 60 );
        add_action( 'customize_preview_init', array( $this, 'customize_preview_js' ), 70 );


        add_filter( 'screenr_selective_refresh_render_section_content_file',array( $this, 'selective_refresh_file' ), 15, 4 );

        add_filter( 'screenr_page_header_item', array( $this, 'page_header' ) );

        add_filter( 'theme_page_templates', array( $this, 'plugin_templates' ), 35 , 3 );

        add_filter('template_include', array( $this, 'load_plugin_template') );

        // Support slider video
        add_filter('screenr_slider_render_item', array( $this, 'slider_render_item'), 35, 2 );

        add_filter('screenr_localize_script', array( $this, 'localize_script'), 35 );

        add_action( 'after_setup_theme', array( $this, 'setup_theme'), 45 );

        // hook to import data
        add_action( 'ft_demo_import_current_item', array( $this, 'auto_import_id' ), 45 );

    }

    function auto_import_id(){
        return 'screenr-plus';
    }


    function setup_theme(){
        add_image_size( 'screenr-thumbnail-team', 340, 220, true );
    }

    function localize_script( $args ){
        $args['autoplay'] = get_theme_mod( 'slider_autoplay', 7000 );
        $args['speed'] = get_theme_mod( 'slider_speed', 700 );
        $args['effect'] = get_theme_mod( 'slider_effect', 'slide' );
        return $args;
    }

    function slider_render_item( $html, $item  ){
        $item = wp_parse_args( $item, array(
            'layout'        => '',
            'content'       => '',
            'bg_type'       => '',
            'media'         => '',
            'video_mp4'     => '',
            'video_ogv'     => '',
            'video_webm'    => '',
            'position'      => '',
            'pd_top'        => '',
            'pd_bottom'     => '',
        ) );


        $url = screenr_get_media_url( $item['media'] );
        $html = '<div class="swiper-slide slide-align-' . esc_attr($item['position']) . ' slide_content slide_content_' . esc_attr($item['layout']) . '" style="background-image: url(\'' . esc_attr($url) . '\')">';

        if ( $item['bg_type'] == 'video' ) {

            $video = screenr_get_media_url( $item['video_mp4'] );
            $html .='<video muted>';
            if ( $video ) {
                $html .= '<source type="video/mp4" src="' . esc_attr($video) . '" />';
            }
            $video = screenr_get_media_url( $item['video_webm'] );
            if ( $video ) {
                $html .= '<source type="video/webm" src="' . esc_attr($video) . '"/>';

            }
            $video = screenr_get_media_url( $item['video_ogv'] );
            if ( $video ) {
                $html .= '<source type="video/ogv" src="' . esc_attr($video) . '"/>';
            }

            $html .='</video>';

        }

        $style  = '';
        if  ( $item['pd_top'] != '' ) {
            $style .='padding-top: '.floatval( $item['pd_top'] ).'%; ';
        }
        if  ( $item['pd_bottom'] != '' ) {
            $style .='padding-bottom: '.floatval( $item['pd_bottom'] ).'%; ';
        }
        if ( $style != '' ) {
            $style = ' style="'.$style.'" ';
        }
        $html .= '<div class="swiper-slide-intro">';
        $html .= '<div class="swiper-intro-inner"'.$style.'>';
        $content = isset( $item['content_'.$item['layout'] ] ) ? $item['content_'.$item['layout'] ] : '';
        if ( ! $content && $item['layout'] == 'layout_1' ) {
            $content = wp_kses_post(  '<h1><strong>Your business, your website</strong></h1>
                                                    Screenr is a multiuse fullscreen WordPress theme.

                                                    <a class="btn btn-lg btn-theme-primary" href="#features">Get Started</a><a class="btn btn-lg btn-secondary-outline" href="#contact">Contact Now</a>' );

        }
        if ( $content ) {
            $html .= apply_filters( 'the_content', $content );
        }

        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="overlay"></div>';
        $html .= '</div>';
        return $html;
    }

    /**
     * Add custom template to edit page template
     *
     * @param $page_templates
     * @param $WP_Theme
     * @param $post
     * @return mixed
     */
    function plugin_templates( $page_templates, $WP_Theme, $post ){
        $page_templates[ 'template-portfolios.php' ] = esc_html__( 'Projects page', 'screenr' );
        return $page_templates;
    }

    /**
     * Load template from this plugin
     *
     * @param $template
     * @return string
     */
    function load_plugin_template( $template ){
        if ( is_page() ) {
            $tpl = get_page_template_slug();
            if ( $tpl  ) {
                $file = $this->locate_template( array(
                    $tpl,
                    'templates/'.$tpl
                ) );

                if ( $file ) {
                    $template = $file;
                }
            }

        }
        return $template;
    }

    /**
     * Change page header settings
     *
     * @param $item
     * @return mixed
     */
    function page_header( $item ){
        if ( is_singular( 'portfolio' ) ) {
            $item['title'] = get_the_title();
            if ( get_theme_mod( 'show_portfolio_thumb_cover', 1 ) ) {
                the_post();
                if ( has_post_thumbnail() ){
                    $item['image'] = get_the_post_thumbnail_url( null, 'full' );
                }
                rewind_posts();
            }
        } else {
            // Page header cover as features image
            if (is_singular() || is_page() ) {
                if ( get_theme_mod( 'singular_thumb_cover', 1 ) ) {
                    the_post();
                    if (has_post_thumbnail()) {
                        $item['image'] = get_the_post_thumbnail_url(null, 'full');
                    }
                    rewind_posts();
                }
            }
        }

        return $item;
    }

    /**
     * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
     */
    function customize_preview_js() {
        wp_enqueue_script( 'screenr_customizer_preview', SCREENR_PLUS_URL . 'assets/js/customizer-preview.js', array( 'customize-preview', 'customize-selective-refresh' ), false, true );
    }

    /**
     * Filter refresh render file
     *
     * @param $file
     * @param $tpl
     * @param $partial
     * @param $container_context
     * @return string
     */
    function selective_refresh_file( $file, $tpl, $partial, $container_context ){
        $file = $this->locate_template( $tpl );
        return $file;
    }

    /**
     * Add selective refresh settings
     * @param $settings
     */
    function selective_refresh( $settings ) {

        $plus_settings = array(
            array(
                'id' => 'testimonials',
                'settings' => array(
                    'testimonials_items',
                    'testimonials_title',
                    'testimonials_subtitle',
                    'testimonials_desc',
                    'testimonials_layout',
                )
            ),
            array(
                'id' => 'portfolios',
                'settings' => array(
                    'portfolios_title',
                    'portfolios_subtitle',
                    'portfolios_desc',
                    'portfolios_number',
                    'portfolios_orderby',
                    'portfolios_order',
                    'portfolios_slug',
                    'portfolios_ajax',
                    'portfolios_layout',
                )
            ),
            array(
                'id' => 'pricing',
                'settings' => array(
                    'pricing_plans',
                    //'pricing_id',
                    'pricing_title',
                    'pricing_subtitle',
                    'pricing_desc',
                )
            ),
            array(
                'id' => 'cta',
                'settings' => array(
                    //'cta_id',
                    'cta_title',
                    'cta_btn_label',
                    'cta_btn_link',
                )
            ),

            array(
                'id' => 'team',
                'settings' => array(
                    'team_members',
                    //'team_id',
                    'team_title',
                    'team_subtitle',
                    'team_desc',
                    'team_layout',
                )
            ),
            // footer
            array(
                'id' => 'site-footer',
                'selector' => '.site-footer',
                'callback' => 'screenr_plus_footer_credits',
                'settings' => array(
                    'screenr_footer_copyright_text',
                    'screenr_hide_author_link',
                )
            ),

            // Typography
            array(
                'id' => 'wp-typography-print-styles',
                'selector' => '.wp-typography-print-styles',
                'callback' => 'screenr_plus_typo_print_styles_preview',
                'settings' => array(
                    'screenr_typo_p',
                    'screenr_typo_menu',
                    'screenr_typo_heading',
                    'typo_slider_heading',
                    'typo_slider_desc',
                    'typo_slider_btn',
                    'screenr_typo_logo',
                )
            ),
        );

        foreach ( $plus_settings as $s ) {
            $settings[] = $s;
        }

        if ( isset( $settings['gallery'] ) ) {
            $settings['gallery']['settings'] = array(
                'gallery_source',
                'gallery_title',
                'gallery_subtitle',
                'gallery_desc',

                'gallery_source_page',
                'gallery_source_flickr',
                'gallery_api_flickr',
                'gallery_source_facebook',
                'gallery_api_facebook',
                'gallery_source_instagram',
                'gallery_layout',
                'gallery_display',
                'gallery_number',
                'gallery_row_height',
                'gallery_col',
            );
        }

        return $settings;
    }

    /**
     * Load plugin template
     *
     * @param $template
     * @return bool|string
     */
    function template_include( $template ){
        global $post;
        if ( is_singular( 'portfolio' ) ){

            $is_child =  STYLESHEETPATH != TEMPLATEPATH ;
            $template_names = array();
            $template_names[] = 'single-portfolio.php';
            $template_names[] = 'portfolio.php';
            $located = false;

            foreach ( $template_names as $template_name ) {
                if (  !$template_name )
                    continue;

                if ( $is_child && file_exists( STYLESHEETPATH . '/' . $template_name ) ) {  // Child them
                    $located = STYLESHEETPATH . '/' . $template_name;
                    break;
                } elseif ( file_exists( SCREENR_PLUS_PATH .'templates/' . $template_name ) ) { // Check part in the plugin
                    $located = SCREENR_PLUS_PATH .'templates/'. $template_name;
                    break;
                } elseif ( file_exists(TEMPLATEPATH . '/' . $template_name) ) { // current_theme
                    $located = TEMPLATEPATH . '/' . $template_name;
                    break;
                }
            }

            if ( $located ) {
                return $located;
            }
        }
        return $template;
    }


    /**
     * Remove disable setting section when this plugin active
     *
     * @param $wp_customize
     */
    function remove_hide_control_sections( $wp_customize ){

        $hide_controls = array(
            //'slider_disable',
            'features_disable',
            'about_disable',
            'services_disable',
            'clients_disable',
            'videolightbox_disable',
            'counter_disable',
            'news_disable',
            'contact_disable',
        );

        foreach ( $hide_controls as $id ) {
            $wp_customize->remove_setting( $id);
            $wp_customize->remove_control( $id);
        }

    }

    /**
     *  Get default sections settings
     *
     * @return array
     */
    function get_default_sections_settings(){
        return apply_filters( 'screenr_get_default_sections_settings', array(

                array(
                    'title' => esc_html__( 'Features', 'screenr-plus' ),
                    'section_id' => 'features',
                    'show_section' => get_theme_mod( 'screenr_features_disable', '' ) == 1 ?  '': 1,
                    'bg_color' => '',
                    'bg_opacity' => '',
                    'bg_opacity_color' => '',
                    'bg_image' => '',
                    'bg_video' => '',
                    'section_inverse' => '',
                    'enable_parallax' => '',
                    'padding_top' => '',
                    'padding_bottom' => '',
                ),

                array(
                    'title' => esc_html__( 'About', 'screenr-plus' ),
                    'section_id' => 'about',
                    'show_section' => get_theme_mod( 'screenr_about_disable', '' ) == 1 ?  '': 1,
                    'bg_color' => '',
                    'bg_opacity' => '',
                    'bg_opacity_color' => '',
                    'bg_image' => '',
                    'bg_video' => '',
                    'section_inverse' => '',
                    'enable_parallax' => '',
                    'padding_top' => '',
                    'padding_bottom' => '',
                ),

                array(
                    'title' => esc_html__( 'Videolightbox', 'screenr-plus' ),
                    'section_id' => 'videolightbox',
                    'show_section' => get_theme_mod( 'screenr_videolightbox_disable', '' ) == 1 ?  '': 1,
                    'bg_color' => '',
                    'bg_opacity' => '',
                    'bg_opacity_color' => '',
                    'bg_image' => array(
                        'id' => '',
                        'url' => ''
                    ),
                    'bg_video' => '',
                    'section_inverse' => '1',
                    'enable_parallax' => '1',
                    'padding_top' => '',
                    'padding_bottom' => '',
                ),

                array(
                    'title' => esc_html__( 'Gallery', 'screenr-plus' ),
                    'section_id' => 'gallery',
                    'show_section' => get_theme_mod( 'gallery_disable', 1 ) == 1 ?  '': 1,
                    'bg_color' => '',
                    'bg_opacity' => '',
                    'bg_opacity_color' => '',
                    'bg_image' => '',
                    'bg_video' => '',
                    'section_inverse' => '',
                    'enable_parallax' => '',
                    'padding_top' => '',
                    'padding_bottom' => '',
                ),

                array(
                    'title' => esc_html__( 'Services', 'screenr-plus' ),
                    'section_id' => 'services',
                    'show_section' => get_theme_mod( 'screenr_services_id', '' ) == 1 ?  '': 1,
                    'bg_color' => '',
                    'bg_opacity' => '',
                    'bg_opacity_color' => '',
                    'bg_image' => '',
                    'bg_video' => '',
                    'section_inverse' => '',
                    'enable_parallax' => '',
                    'padding_top' => '',
                    'padding_bottom' => '',
                ),

                array(
                    'title' => esc_html__( 'Projects', 'screenr-plus' ),
                    'section_id' => 'portfolios',
                    'show_section' => 1,
                    'bg_color' => '',
                    'bg_opacity' => '',
                    'bg_opacity_color' => '',
                    'bg_image' => '',
                    'bg_video' => '',
                    'section_inverse' => '',
                    'enable_parallax' => '',
                    'padding_top' => '',
                    'padding_bottom' => '',
                ),

                array(
                    'title' => esc_html__( 'Clients', 'screenr-plus' ),
                    'section_id' => 'clients',
                    'show_section' => '1',
                    'bg_color' => '',
                    'bg_opacity' => '',
                    'bg_opacity_color' => '',
                    'bg_image' => '',
                    'bg_video' => '',
                    'section_inverse' => '',
                    'enable_parallax' => '',
                    'padding_top' => '',
                    'padding_bottom' => '',
                ),


                array(
                    'title' => esc_html__( 'Counter', 'screenr-plus' ),
                    'section_id' => 'counter',
                    'show_section' => get_theme_mod( 'screenr_counter_disable', '' ) == 1 ?  '': 1,
                    'bg_color' => '',
                    'bg_opacity' => '',
                    'bg_opacity_color' => '',
                    'bg_image' => '',
                    'bg_video' => '',
                    'section_inverse' => '',
                    'enable_parallax' => '',
                    'padding_top' => '',
                    'padding_bottom' => '',
                ),

                array(
                    'title' => esc_html__( 'Testimonials', 'screenr-plus' ),
                    'section_id' => 'testimonials',
                    'show_section' => get_theme_mod( 'testimonials_disable', '' ) == 1 ?  '': 1,
                    'bg_color' => '',
                    'bg_opacity' => '',
                    'bg_opacity_color' => '',
                    'bg_image' => '',
                    'bg_video' => '',
                    'section_inverse' => '',
                    'enable_parallax' => '',
                    'padding_top' => '',
                    'padding_bottom' => '',
                ),

                array(
                    'title' => esc_html__( 'Call to Action', 'screenr-plus' ),
                    'section_id' => 'cta',
                    'show_section' => 1,
                    'bg_color' => '',
                    'bg_opacity' => '',
                    'bg_opacity_color' => '',
                    'bg_image' => '',
                    'bg_video' => '',
                    'section_inverse' => '1',
                    'enable_parallax' => '',
                    'padding_top' => '',
                    'padding_bottom' => '',
                ),

                array(
                    'title' => esc_html__( 'Pricing', 'screenr-plus' ),
                    'section_id' => 'pricing',
                    'show_section' => get_theme_mod( 'pricing_disable', '' ) == 1 ?  '': 1,
                    'bg_color' => '',
                    'bg_opacity' => '',
                    'bg_opacity_color' => '',
                    'bg_image' => '',
                    'bg_video' => '',
                    'section_inverse' => '',
                    'enable_parallax' => '',
                    'padding_top' => '',
                    'padding_bottom' => '',
                ),

                array(
                    'title' => esc_html__( 'Team', 'screenr-plus' ),
                    'section_id' => 'team',
                    'show_section' => get_theme_mod( 'team_disable', '' ) == 1 ?  '': 1,
                    'bg_color' => '',
                    'bg_opacity' => '',
                    'bg_opacity_color' => '',
                    'bg_image' => '',
                    'bg_video' => '',
                    'section_inverse' => '',
                    'enable_parallax' => '',
                    'padding_top' => '',
                    'padding_bottom' => '',
                ),

                array(
                    'title' => esc_html__( 'News', 'screenr-plus' ),
                    'section_id' => 'news',
                    'show_section' => get_theme_mod( 'screenr_news_disable', '' ) == 1 ?  '': 1,
                    'bg_color' => '',
                    'bg_opacity' => '',
                    'bg_opacity_color' => '',
                    'bg_image' => '',
                    'bg_video' => '',
                    'section_inverse' => '',
                    'enable_parallax' => '',
                    'padding_top' => '',
                    'padding_bottom' => '',
                ),

                array(
                    'title' => esc_html__( 'Contact', 'screenr-plus' ),
                    'section_id' => 'contact',
                    'show_section' => get_theme_mod( 'screenr_contact_disable', '' ) == 1 ?  '': 1,
                    'bg_color' => '',
                    'bg_opacity' => '',
                    'bg_opacity_color' => '',
                    'bg_image' => '',
                    'bg_video' => '',
                    'section_inverse' => '',
                    'enable_parallax' => '',
                    'padding_top' => '',
                    'padding_bottom' => '',
                ),


            )
        );
    }


    /**
     * Add more customize
     *
     * @param $wp_customize
     */
    function plugin_customize( $wp_customize ){

        $this->remove_hide_control_sections( $wp_customize );
        include_once SCREENR_PLUS_PATH.'inc/typography/typography.php';
        include_once SCREENR_PLUS_PATH.'inc/customizer-settings.php';
    }

    /**
     * Unlimited repeatable items
     *
     * @param $number
     * @return int
     */
    function unlimited_repeatable_items( $number ){
        return 99999;
    }

    /**
     * Get section settings data
     *
     * @return array
     */
    function get_sections_settings(){
        if ( ! empty( $this->section_settings ) ) {
            return $this->section_settings;
        }

        $sections = get_theme_mod( 'sections_order_styling', '' );

        if ( ! is_array( $sections ) ) {
            $sections = json_decode( $sections, true );
            if ( ! is_array( $sections ) ) {
                $sections = array();
            }
        }

        if ( empty( $sections ) || ! is_array( $sections ) ) {
            $sections = $this->get_default_sections_settings();
        }

        $this->section_settings = array();

        foreach( $sections as $k => $v ) {
            if ( ! $v['section_id'] ) {
                $v['section_id'] = sanitize_title( $v['title'] );
            }

            if ( ! $v['section_id'] ) {
                $v['section_id'] = uniqid('section-');
            }

            if ( $v['section_id'] != '' && ( ! isset( $v['add_buy'] ) ||  $v['add_buy'] != 'click' ) ) {
                $this->section_settings[  $v['section_id'] ] =  $v;
            } else {
                $this->section_settings[  ] =  $v;
            }
        }

        return $this->section_settings ;
    }

    /**
     * Get media from a variable
     *
     * @param array $media
     * @return false|string
     */
    static function get_media_url( $media = array() ){
        $media = wp_parse_args( $media, array('url' => '', 'id' => '') );
        $url = '';
        if ( $media['id'] != '' ) {
            $url = wp_get_attachment_url($media['id']);
        }
        if ( $url == '' && $media['url'] != '') {
            $url = $media['url'];
        }
        return $url;
    }

    function hex_to_rgb( $colour ) {
        if ( $colour[0] == '#' ) {
            $colour = substr( $colour, 1 );
        }
        if ( strlen( $colour ) == 6 ) {
            list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
        } elseif ( strlen( $colour ) == 3 ) {
            list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
        } else {
            return false;
        }
        $r = hexdec( $r );
        $g = hexdec( $g );
        $b = hexdec( $b );
        return array( 'r' => $r, 'g' => $g, 'b' => $b );
    }

    function check_hex( $color ){

        $color = ltrim( $color, '#' );
        if ( '' === $color ){
            return '';
        }

        // 3 or 6 hex digits, or the empty string.
        if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', '#' . $color ) ) {
            return '#' . $color;
        }

        return '';
    }

    function hex_to_rgba( $hex_color, $alpha = 1 ) {
        if ( $this->is_rgb( $hex_color ) ) {
            return $hex_color;
        }
        if ( $hex_color = $this->check_hex( $hex_color ) ) {
            $rgb = $this->hex_to_rgb( $hex_color );
            $rgb['a' ] = $alpha;
            return 'rgba('.join(',', $rgb ).')';
        } else {
            return '';
        }
    }

    function is_rgb( $color ){
        return strpos( trim( $color ), 'rgb' ) !== false ?  true : false;
    }

    /**
     * Check to load css, js, and more...
     */
    function int_setup() {
        if (  empty( $this->section_settings ) ) {
            $this->get_sections_settings();
        }

        $style = array();


        foreach ( $this->section_settings as $section ) {
            $section = wp_parse_args( $section, array(
                'section_id' => '',
                'show_section' => '',
                'bg_color' => '',
                'bg_type' => '',
                'bg_opacity' => '',
                'bg_opacity_color' => '',
                'bg_image' => '',
                'bg_video' => '',
                'bg_video_webm' => '',
                'bg_video_ogv' => '',
                'enable_parallax' => '',
                'padding_top' => '',
                'padding_bottom' => '',
            ) );

            if ( $section['padding_top'] != '' ) {
                if ( strpos( $section['padding_top'], '%' ) !== false ) {
                    $section['padding_top'] = intval( $section['padding_top'] ).'%';
                } else {
                    $section['padding_top'] = intval( $section['padding_top'] ).'px';
                }
                $style[ $section['section_id'] ][] = "padding-top: {$section['padding_top']};";
            }

            if ( $section['padding_bottom'] != '' ) {
                if ( strpos( $section['padding_bottom'], '%' ) !== false ) {
                    $section['padding_bottom'] = intval( $section['padding_bottom'] ).'%';
                } else {
                    $section['padding_bottom'] = intval( $section['padding_bottom'] ).'px';
                }

                $style[ $section['section_id'] ][] = "padding-bottom: {$section['padding_bottom']};";

            }

            switch ($section['bg_type']) {

                case 'video':

                    if ( $this->is_rgb( $section['bg_opacity_color'] ) ) {
                        $bg_opacity_color = $section['bg_opacity_color'];
                    } else {
                        $bg_opacity_color = $this->hex_to_rgba( $section['bg_opacity_color'] , .4 );
                    }
                    $this->custom_css .= " .section-{$section['section_id']}::before{background-color: {$bg_opacity_color}; } \n ";

                    break;

                case 'image':

                    if ( $this->is_rgb( $section['bg_opacity_color'] ) ) {
                        $bg_opacity_color = $section['bg_opacity_color'];
                    } else {
                        $bg_opacity_color = $this->hex_to_rgba( $section['bg_opacity_color'] , .4 );
                    }

                    $image = $this->get_media_url($section['bg_image']);

                    if ( $image && ! $bg_opacity_color ) {
                        $style[$section['section_id']]['bg'] = "background-color: #{$bg_opacity_color};";
                        // check background image and not parallax enable
                        if ($section['enable_parallax'] != 1 && $image) {
                            $style[$section['section_id']][] = "background-image: url(\"{$image}\");";
                        }
                    } else if ( $image && $bg_opacity_color ) {
                        $this->custom_css .=".bgimage-{$section['section_id']} {background-image: url(\"{$image}\");}";
                        $style[$section['section_id']][] = "background-color: {$bg_opacity_color}";
                    }


                    if (  $section['enable_parallax'] == 1 ) {
                        $this->custom_css .= " .parallax-{$section['section_id']} .parallax-mirror::before{background-color: {$bg_opacity_color}; } \n ";
                    }

                    break;

                default: // Background color

                    if ( $section['bg_color'] ) {
                        if ($this->is_rgb($section['bg_color'])) {
                            $bg_color = $section['bg_color'];
                        } else {
                            $bg_color = $this->hex_to_rgba($section['bg_color'], 1);
                        }

                        $style[$section['section_id']]['bg'] = "background-color: {$bg_color};";
                    }

            }

        }

        foreach ( $style as $k => $code ) {
            if ( ! empty( $code ) ) {
                $this->custom_css .= " .section-{$k}{ ".join( ' ', $code )." } \n ";
            }
        }
    }

    /**
     * Load CSS, JS for frontend
     */
    function frontend_scripts(){

        if ( file_exists( SCREENR_PLUS_PATH.'screenr-plus.css' ) ) {
            wp_register_style('screenr-plus-style', SCREENR_PLUS_URL . 'screenr-plus.css', array( 'screenr-style' ) );
            wp_enqueue_style('screenr-plus-style');
        }

        /**
         * Plugin style
         */
        wp_enqueue_script( 'screenr-plus', SCREENR_PLUS_URL.'assets/js/screenr-plus.js', array( 'jquery' ), SCREENR_PLUS_VERSION , true );
        wp_localize_script( 'jquery' , 'Screenr_Plus', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'browser_warning'=> esc_html__( ' Your browser does not support the video tag. I suggest you upgrade your browser.', 'screenr-plus' )
        ) );
    }

    /**
     * Print CSS in header tag
     */
    function custom_css(){
        if ( $this->custom_css ) {
            wp_add_inline_style( 'screenr-style', $this->custom_css  );
        }
    }

    /**
     * Change onepage section classes
     *
     * @param $class
     * @param $section_id
     * @return array|string
     */
    function filter_section_class( $class, $section_id ){

        if (  empty( $this->section_settings ) ) {
            $this->get_sections_settings();
        }

        if ( isset( $this->section_settings[ $section_id ] ) ) {
            $class = explode( " ", $class );

            $class['section-'.$section_id ] = 'section-'.$section_id ;

            if ( isset( $this->section_settings[ $section_id ]['section_inverse'] ) && $this->section_settings[ $section_id ]['section_inverse'] ) {
                if ( ! in_array( 'section-inverse', $class ) ) {
                    $class[] =  'section-inverse';
                }
            } else {
                if( ( $key = array_search( 'section-inverse' , $class ) ) !== false ) {
                    unset( $class[ $key ] );
                }
            }
            $class = array_unique( $class );
            $class  = join( ' ', $class );
        }

        return $class;
    }

    function load_section_part( $section ){
        $file_name = 'section-parts/section-' . $section['section_id'] . ".php";
        if ( ! $this->locate_template( $file_name, true, false ) ) {

            $section =  wp_parse_args( $section, array(
                'section_id' => '',
                'subtitle' => '',
                'title' => '',
                'content' => '',
                'desc' => '',
                'hide_title' => '',
            ) );
            ?>
            <section id="<?php if ( $section['section_id'] != '' ) echo esc_attr( $section['section_id'] ); ?>" <?php do_action( 'screenr_section_atts', $section['section_id'] ); ?> class="<?php echo esc_attr( apply_filters( 'screenr_section_class', 'section-'.$section['section_id'].' onepage-section section-meta section-padding', $section['section_id'] ) ); ?>">
                <?php do_action( 'screenr_section_before_inner', $section['section_id'] ); ?>
                <div class="container">
                    <?php if (  $section['title'] || $section['subtitle'] || $section['desc'] || ( ! $section['hide_title'] && $section['title'] ) ) { ?>
                        <?php if ( ( $section['title'] && ! $section['hide_title'] ) || $section['subtitle']  || $section['desc']  ) { ?>
                            <div class="section-title-area">
                                <?php if ( $section['subtitle'] != '' ) echo '<h5 class="section-subtitle">' . esc_html( $section['subtitle'] ) . '</h5>'; ?>
                                <?php if ( ! $section['hide_title'] ) { ?>
                                    <?php if ( $section['title'] ) echo '<h2 class="section-title">' . esc_html( $section['title'] ) . '</h2>'; ?>
                                <?php } ?>
                                <?php if ( $section['desc'] ) {
                                    echo '<div class="section-desc">' . apply_filters( 'the_content', $section['desc'] ) . '</div>';
                                } ?>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <div class="section-content-area custom-section-content"><?php echo apply_filters( 'the_content', $section['content'] ); ?></div>
                </div>
                <?php do_action( 'screenr_section_after_inner', $section['section_id'] ); ?>
            </section>
            <?php

        }

    }

    /**
     * Load section parts
     *
     * @param $sections
     */
    function load_section_parts(  ){

        $sections = $this->get_sections_settings();
        /**
         * Section: Hero
         */

        /**
         * Hook before section
         */
        do_action('screenr_before_section_hero' );
        do_action( 'screenr_before_section_part', 'slider' );

        $this->locate_template('section-parts/section-slider.php', true, false );

        /**
         * Hook after section
         */
        do_action('screenr_after_section_part', 'slider' );
        do_action('screenr_after_section_hero' );


        if ( is_array( $sections ) ) {
            add_filter( 'screenr_section_class', array( $this, 'filter_section_class' ), 15, 2 );
            foreach ( $sections as $index => $section ) {
                //$GLOBALS['current_section'] = $section;
                $section = wp_parse_args( $section,
                    array(
                        'section_id' => '',
                        'show_section' => '',
                        'add_buy' => '',
                        'content' => '',
                        'bg_color' => '',
                        'bg_type' => '',
                        'bg_opacity' => '',
                        'bg_image' => '',
                        'bg_video_webm' => '',
                        'bg_video_ogv' => '',
                        'enable_parallax' => '',
                    )
                );

                // make sure we not disable from theme template
                add_filter( 'theme_mod_screenr_'.$section['section_id'].'_disable', '__return_false', 99 );
                // If disabled section the code this line below will handle this
                if ( $section['show_section'] ) {
                    if ( $section['section_id'] != '' ) {
                        do_action('screenr_before_section_'.$section['section_id'] );
                        do_action('screenr_before_section_part', $section['section_id'] );


                        switch ( $section['bg_type'] ) {

                            case 'video':
                                $video_url =  $this->get_media_url( $section['bg_video'] );
                                $video_webm_url =  $this->get_media_url( $section['bg_video_webm'] );
                                $video_ogv_url =  $this->get_media_url( $section['bg_video_ogv'] );
                                $image = $this->get_media_url( $section['bg_image'] );

                                if (  $video_url || $video_webm_url || $video_ogv_url ) {
                                    ?>
                                <div class="video-section"
                                     data-mp4="<?php echo esc_url( $video_url ); ?>"
                                     data-webm="<?php echo esc_url( $video_webm_url ); ?>"
                                     data-ogv="<?php echo esc_url( $video_ogv_url ); ?>"
                                     data-bg="<?php echo esc_attr( $image ); ?>">
                                    <?php
                                }

                                $this->load_section_part( $section );

                                if ( $video_url || $video_webm_url || $video_ogv_url ) {
                                    echo '</div>'; // End video-section
                                }

                                break;
                            case 'image':

                                $image = $this->get_media_url( $section['bg_image'] );
                                $alpha = $this->hex_to_rgba( $section['bg_opacity_color'], .3 );
                                if ( $section['enable_parallax'] == 1 ) {
                                    echo '<div id="parallax-'.esc_attr( $section['section_id'] ).'" class="parallax-'.esc_attr( $section['section_id'] ).' parallax-window" data-over-scroll-fix="true" data-z-index="1" data-speed="0.3" data-image-src="'.esc_attr( $image ).'" data-parallax="scroll" data-position="center" data-bleed="0">';
                                } else if ( $image && $alpha ) { // image bg
                                    echo '<div id="bgimage-'.esc_attr( $section['section_id'] ).'" class="bgimage-alpha bgimage-'.esc_attr( $section['section_id'] ).'">';
                                }

                                $this->load_section_part( $section );

                                if ( $section['enable_parallax'] == 1 ) {
                                    echo '</div>'; // End parallax
                                } else if ( $image && $alpha ) {
                                    echo '</div>'; // // image bg
                                }

                                break;
                            default:

                                $this->load_section_part( $section );

                        }


                        do_action('screenr_after_section_part', $section['section_id']);
                        do_action('screenr_after_section_'.$section['section_id'] );
                    }
                }
            }
            remove_filter( 'screenr_section_class', array( $this, 'filter_section_class' ), 15, 2 );
        }
    }

    /**
     * Retrieve the name of the highest priority template file that exists.
     *
     * Searches in the STYLESHEETPATH before TEMPLATEPATH so that themes which
     * inherit from a parent theme can just overload one file.
     *
     * @since 2.7.0
     *
     * @param string|array $template_names Template file(s) to search for, in order.
     * @param bool         $load           If true the template file will be loaded if it is found.
     * @param bool         $require_once   Whether to require_once or require. Default true. Has no effect if $load is false.
     * @return string The template filename if one is located.
     */
    function locate_template( $template_names, $load = false, $require_once = true ) {
        $located = '';

        $is_child =  STYLESHEETPATH != TEMPLATEPATH ;
        foreach ( (array) $template_names as $template_name ) {

            if (  !$template_name )
                continue;

            if ( $is_child && file_exists( STYLESHEETPATH . '/' . $template_name ) ) {  // Child them
                $located = STYLESHEETPATH . '/' . $template_name;
                break;

            } elseif ( file_exists( SCREENR_PLUS_PATH  . $template_name ) ) { // Check part in the plugin
                $located = SCREENR_PLUS_PATH . $template_name;
                break;
            } elseif ( file_exists(TEMPLATEPATH . '/' . $template_name) ) { // current_theme
                $located = TEMPLATEPATH . '/' . $template_name;
                break;
            }
        }

        if ( $load && '' != $located ) {
            load_template( $located, $require_once );
        }
        return $located;
    }
}

/**
 * call plugin
 */
function screenr_plus_setup(){
    new Screenr_PLus();
}
add_action( 'plugins_loaded', 'screenr_plus_setup' );

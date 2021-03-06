<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Screenr
 */


/**
 * Filter content just like `the_content`
 *
 * @see WP_Embed
 * @see wp_make_content_images_responsive
 * @see wptexturize
 * @see convert_smilies
 * @see convert_chars
 * @see wpautop
 * @see shortcode_unautop
 * @see do_shortcode
 * @see capital_P_dangit
 */
global $wp_embed;
add_filter( 'screenr_content_text', array( $wp_embed, 'autoembed' ), 8 );
add_filter( 'screenr_content_text', array( $wp_embed, 'run_shortcode' ), 9 );
add_filter( 'screenr_content_text', 'wp_make_content_images_responsive', 10 );
add_filter( 'screenr_content_text', 'wptexturize', 12 );
add_filter( 'screenr_content_text', 'convert_smilies', 13 );
add_filter( 'screenr_content_text', 'convert_chars', 14 );
add_filter( 'screenr_content_text', 'wpautop', 15 );
add_filter( 'screenr_content_text', 'shortcode_unautop', 16 );
add_filter( 'screenr_content_text', 'do_shortcode', 17 );
add_filter( 'screenr_content_text', 'capital_P_dangit', 18 );


/**
 * Filter the except length to 50 characters.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function screenr_excerpt_length( $length = '' ) {

    if ( isset( $GLOBALS['screenr_excerpt_length'] ) && $GLOBALS['screenr_excerpt_length'] > 0 ) {
        return $GLOBALS['screenr_excerpt_length'];
    } else {
        return 50;
    }
}
add_filter( 'excerpt_length', 'screenr_excerpt_length', 99 );

/**
 * Filter the excerpt "read more" string.
 *
 * @param string $more "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */
function screenr_excerpt_more( $more = '' ) {
    return '...';
}
add_filter( 'excerpt_more', 'screenr_excerpt_more' );

/**
 * Add custom excerpt length
 * @param $length
 */
function screenr_add_excerpt_length( $length ){
    $length = absint( $length );
    $GLOBALS['screenr_excerpt_length'] = $length;
}

/**
 * REMOVE custom excerpt length
 */
function screenr_remove_excerpt_length (){
    if ( isset( $GLOBALS['screenr_excerpt_length'] ) ) {
        unset( $GLOBALS['screenr_excerpt_length'] );
    }
}


/**
 * Get media from a variable
 *
 * @param array $media
 * @return false|string
 */
if ( ! function_exists( 'screenr_get_media_url' ) ) {
    function screenr_get_media_url($media = array())
    {
        $media = wp_parse_args($media, array('url' => '', 'id' => ''));
        $url = '';
        if ($media['id'] != '') {
            $url = wp_get_attachment_url($media['id']);
        }
        if ($url == '' && $media['url'] != '') {
            $url = $media['url'];
        }
        return $url;
    }
}
if ( ! function_exists( 'screenr_rgb2hex' ) ) {
    function screenr_rgb2hex( $rgb )
    {
        return '#' . sprintf('%02x', $rgb['r']) . sprintf('%02x', $rgb['g']) . sprintf('%02x', $rgb['b']);
    }
}

function screenr_color_alpha_parse( $color_alpha ){
    $s = str_replace( array( 'rgba', '(', ')', ';' ), '', $color_alpha );
    $arr = explode(',', $s );
    $r = false;
    if ( count( $arr ) > 2 ) {
        $r = array(
            'color' => array(
                'r' => $arr[0],
                'g' => $arr[1],
                'b' => $arr[2],
            ),
            'alpha' => 1,
        );

        if ( count( $arr ) > 3 ) {
            $r['opacity'] = floatval( $arr[3] );
        }
    }

    return $r;
}


/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function screenr_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

    if ( get_theme_mod( 'screenr_hide_sitetitle' ) ) {
        $classes[] = 'no-site-title';
    } else {
        $classes[] = 'has-site-title';
    }

    if ( get_theme_mod( 'screenr_hide_tagline' ) ) {
        $classes[] = 'no-site-tagline';
    } else {
        $classes[] = 'has-site-tagline';
    }

    if ( get_option( 'header_layout' ) != 'default' ) {
        $classes[] = 'header-layout-fixed';
    }

    if ( is_page() ) {
        if( is_page_template( 'templates/full-width-page.php' ) ) {
            $classes[] = 'full-width-page';
        }
    }

	return $classes;
}
add_filter( 'body_class', 'screenr_body_classes' );


/**
 * Add custom css from theme options
 *
 */
function screenr_custom_style(){
    $css = '';

    $layout = get_theme_mod( 'header_layout' );
    ob_start();

if ( $layout != 'transparent' ) {
     /**
     * Header background
     */
    $header_bg_color =  get_theme_mod( 'header_bg_color' );
    if ( $header_bg_color ) {
        ?>
        .site-header, .is-fixed .site-header.header-fixed.transparent {
            background: #<?php echo esc_attr( $header_bg_color ); ?>;
            border-bottom: 0px none;
        }
    <?php
    } // END $header_bg_color

    /**
     * Menu color
     */
    $menu_color =  get_theme_mod( 'menu_color' );
    if ( $menu_color ) {
        ?>
        .nav-menu > li > a{
            color: #<?php echo esc_attr( $menu_color ); ?>;
        }

        <?php
    } // END $menu_color

    /**
     * Menu hover color
     */
    $menu_hover_color =  get_theme_mod( 'menu_hover_color' );
    if ( $menu_hover_color ) {
        ?>
        .nav-menu > li > a:hover,
        .nav-menu > li.current-menu-item > a {
            color: #<?php echo esc_attr( $menu_hover_color ); ?>;
            -webkit-transition: all 0.5s ease-in-out;
            -moz-transition: all 0.5s ease-in-out;
            -o-transition: all 0.5s ease-in-out;
            transition: all 0.5s ease-in-out;
        }
        <?php
        } // END $menu_hover_color

        /**
         * Menu hover background color
         */
        $menu_hover_bg =  get_theme_mod( 'menu_hover_bg_color' );
        if ( $menu_hover_bg ) {
            ?>
        @media screen and (min-width: 1140px) {
            .nav-menu > li:last-child > a {
                padding-right: 17px;
            }

            .nav-menu > li > a:hover,
            .nav-menu > li.current-menu-item > a {
                background: #<?php echo esc_attr( $menu_hover_bg ); ?>;
                -webkit-transition: all 0.5s ease-in-out;
                -moz-transition: all 0.5s ease-in-out;
                -o-transition: all 0.5s ease-in-out;
                transition: all 0.5s ease-in-out;
            }
        }

        <?php
        } // END $menu_hover_bg


} else { // header transparent mod


    /**
     * Header background
     */
    $header_bg_color =  get_theme_mod( 'header_t_bg_color' );
    if ( $header_bg_color ) {
    ?>
    .site-header.header-fixed.transparent {
        background-color: <?php echo esc_attr( $header_bg_color ); ?>;
        border-bottom: 0px none;
    }
    <?php
    } // END $header_bg_color

    /**
     * Menu color
     */
    $menu_color =  get_theme_mod( 'menu_t_color' );
    if ( $menu_color ) {
        ?>
        .nav-menu > li > a,
        .no-scroll .sticky-header.transparent .nav-menu > li > a,
        .sticky-header.transparent .nav-menu > li > a {
            color: #<?php echo esc_attr( $menu_color ); ?>;
        }

        <?php
    } // END $menu_color

    /**
     * Menu hover color
     */
    $menu_hover_color =  get_theme_mod( 'menu_t_hover_color' );
    if ( $menu_hover_color ) {
        ?>
        .nav-menu > li > a:hover,
        .nav-menu > li.current-menu-item > a,
        .no-scroll .sticky-header.transparent .nav-menu > li.current-menu-item > a,
        .sticky-header.transparent .nav-menu > li.current-menu-item > a {
            color: #<?php echo esc_attr( $menu_hover_color ); ?>;
            -webkit-transition: all 0.5s ease-in-out;
            -moz-transition: all 0.5s ease-in-out;
            -o-transition: all 0.5s ease-in-out;
            transition: all 0.5s ease-in-out;
        }
        .sticky-header.transparent .nav-menu > li:hover > a::after, .sticky-header.transparent .nav-menu > li.current-menu-item > a::after {
            border-bottom-color: #<?php echo esc_attr( $menu_hover_color ); ?>;
        }
    <?php
    } // END $menu_hover_color

    $menu_border_color = get_theme_mod( 'menu_t_hover_border_color' );
    if ( $menu_border_color ) {
        ?>
        .sticky-header.transparent .nav-menu > li:hover > a::after,
        .sticky-header.transparent .nav-menu > li.current-menu-item > a::after {
            border-bottom-color: #<?php  echo esc_attr( $menu_border_color ); ?>;
        }
        <?php
    }

    /**
     * Menu hover background color
     */
    $menu_hover_bg =  get_theme_mod( 'menu_t_hover_bg_color' );
    if ( $menu_hover_bg ) {
        ?>
        @media screen and (min-width: 1140px) {
            .nav-menu > li:last-child > a {
                padding-right: 17px;
            }

            .nav-menu > li > a:hover,
            .nav-menu > li.current-menu-item > a {
                background: #<?php echo esc_attr( $menu_hover_bg ); ?>;
                -webkit-transition: all 0.5s ease-in-out;
                -moz-transition: all 0.5s ease-in-out;
                -o-transition: all 0.5s ease-in-out;
                transition: all 0.5s ease-in-out;
            }
        }
    <?php
    } // END $menu_hover_bg


} // end header & menu


    /**
     * Reponsive Mobie button color
     */
    $menu_button_color =  get_theme_mod( 'menu_toggle_button_color' );
    if ( $menu_button_color ) {
        ?>
    #nav-toggle span,
    #nav-toggle span::before,
    #nav-toggle span::after,
    #nav-toggle.nav-is-visible span::before,
    #nav-toggle.nav-is-visible span::after,

    .transparent #nav-toggle span,
    .transparent #nav-toggle span::before,
    .transparent #nav-toggle span::after,
    .transparent #nav-toggle.nav-is-visible span::before,
    .transparent #nav-toggle.nav-is-visible span::after
    {
        background-color: #<?php echo esc_attr( $menu_button_color ); ?>;
    }

    <?php
    }

    /**
     * Site Title
     */
    $logo_text_color =  get_theme_mod( 'logo_text_color' );
    if ( $logo_text_color ) {
    ?>
    .site-branding .site-title,
    .site-branding .site-text-logo,
    .site-branding .site-title a,
    .site-branding .site-text-logo a,
    .site-branding .site-description,
    .transparent .site-branding .site-description,
    .transparent .site-branding .site-title a {
        color: #<?php echo esc_attr( $logo_text_color ); ?>;
    }

    <?php
    }

    $slider_overlay_color =  get_theme_mod( 'slider_overlay_color' );
    $c =  screenr_color_alpha_parse( $slider_overlay_color );
    if ( $slider_overlay_color && $c ) {
    ?>
    .swiper-slider .swiper-slide .overlay {
        background-color: <?php echo screenr_rgb2hex( $c['color'] ); ?>;
        opacity: <?php echo esc_attr( $c['opacity'] ); ?>;
    }
    <?php
    }

    $v_overlay = get_theme_mod( 'videolightbox_overlay' );
    if ( $v_overlay ){
    ?>
    .parallax-window.parallax-videolightbox .parallax-mirror::before{
        background-color: <?php echo esc_attr( $v_overlay ); ?>;
    }
    <?php
    }

    // Page header
    $page_header_bg_overlay =  get_theme_mod( 'page_header_bg_overlay' );
    $bg_cover = get_theme_mod( 'page_header_bg_color', '000000' );
    $c =  screenr_color_alpha_parse( $page_header_bg_overlay );
    if ( $c ){
    ?>
    #page-header-cover.swiper-slider .swiper-slide .overlay {
        background-color: <?php echo screenr_rgb2hex( $c['color'] ); ?>;
        opacity: <?php echo $c['opacity']; ?>;
    }
    <?php
    }
    ?>
    #page-header-cover.swiper-slider.no-image .swiper-slide .overlay {
        background-color: #<?php echo esc_attr( $bg_cover ); ?>;
        opacity: 1;
    }
    <?php
    $footer_w_bg = get_theme_mod( 'footer_widgets_bg' );
    if ( $footer_w_bg ) {
    ?>
    .footer-widgets {
        background-color: #<?php echo esc_attr( $footer_w_bg ); ?>;
    }
    <?php } ?>

    <?php
    $footer_w_color = get_theme_mod( 'footer_widgets_color' );
    if ( $footer_w_color ) {
    ?>
    .footer-widgets, .footer-widgets caption {
        color: #<?php echo esc_attr( $footer_w_color ); ?>;
    }
    <?php } ?>

    <?php
    $footer_widgets_heading = get_theme_mod( 'footer_widgets_heading' );
    if ( $footer_widgets_heading ) {
    ?>
    .footer-widgets .widget-title, .site-footer .sidebar .widget .widget-title {
        color: #<?php echo esc_attr( $footer_widgets_heading ); ?>;
    }
    <?php } ?>

    <?php
    $footer_w_link_color = get_theme_mod( 'footer_widgets_link_color' );
    if ( $footer_w_link_color ) {
    ?>
    .footer-widgets a, .footer-widgets .sidebar .widget a{
        color: #<?php echo esc_attr( $footer_w_link_color ); ?>;
    }
    <?php } ?>

    <?php
    $footer_w_link_hover_color = get_theme_mod( 'footer_widgets_link_hover_color' );
    if ( $footer_w_link_hover_color ) {
    ?>
    .footer-widgets a:hover, .footer-widgets .sidebar .widget a:hover{
    color: #<?php echo esc_attr( $footer_w_link_hover_color ); ?>;
    }
    <?php } ?>

    <?php
    $footer_copyright_border_top = get_theme_mod( 'footer_copyright_border_top' );
    if ( $footer_copyright_border_top ) {
    ?>
    .site-footer .site-info{
        border-top-color: #<?php echo esc_attr( $footer_copyright_border_top ); ?>;
    }
    <?php } ?>

    <?php
    $footer_c_bg = get_theme_mod( 'footer_copyright_bg' );
    if ( $footer_c_bg ) {
    ?>
    .site-footer .site-info {
        background-color: #<?php echo esc_attr( $footer_c_bg ); ?>;
    }
    <?php } ?>

    <?php
    $footer_c_color = get_theme_mod( 'footer_copyright_color' );
    if ( $footer_c_color ) {
    ?>
    .site-footer .site-info, .site-footer .site-info a {
        color: #<?php echo esc_attr( $footer_c_color ); ?>;
    }
    <?php
    }

    $primary = get_theme_mod( 'primary_color' );
    if ( $primary ) {
        ?>
        input[type="reset"], input[type="submit"], input[type="submit"],
        .btn-theme-primary,
        .btn-theme-primary-outline:hover,
        .features-content .features__item,
        .nav-links a:hover,
        .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce button.button.alt
        {
            background-color: #<?php echo esc_attr( $primary ); ?>;
        }
        textarea:focus,
        input[type="date"]:focus,
        input[type="datetime"]:focus,
        input[type="datetime-local"]:focus,
        input[type="email"]:focus,
        input[type="month"]:focus,
        input[type="number"]:focus,
        input[type="password"]:focus,
        input[type="search"]:focus,
        input[type="tel"]:focus,
        input[type="text"]:focus,
        input[type="time"]:focus,
        input[type="url"]:focus,
        input[type="week"]:focus {
            border-color: #<?php echo esc_attr( $primary ); ?>;
        }

        a,
        .screen-reader-text:hover,
        .screen-reader-text:active,
        .screen-reader-text:focus,
        .header-social a,
        .nav-menu li.current-menu-item > a,
        .nav-menu a:hover,
        .nav-menu ul li a:hover,
        .nav-menu li.onepress-current-item > a,
        .nav-menu ul li.current-menu-item > a,
        .nav-menu > li a.menu-actived,
        .nav-menu.nav-menu-mobile li.nav-current-item > a,
        .site-footer a,
        .site-footer .btt a:hover,
        .highlight,
        .entry-meta a:hover,
        .entry-meta i,
        .sticky .entry-title:after,
        #comments .comment .comment-wrapper .comment-meta .comment-time:hover, #comments .comment .comment-wrapper .comment-meta .comment-reply-link:hover, #comments .comment .comment-wrapper .comment-meta .comment-edit-link:hover,
        .sidebar .widget a:hover,
        .services-content .service-card-icon i,
        .contact-details i,
        .contact-details a .contact-detail-value:hover, .contact-details .contact-detail-value:hover,
        .btn-theme-primary-outline
        {
            color: #<?php echo esc_attr( $primary ); ?>;
        }

        .entry-content blockquote {
            border-left: 3px solid #<?php echo esc_attr( $primary ); ?>;
        }

        .btn-theme-primary-outline, .btn-theme-primary-outline:hover {
            border-color: #<?php echo esc_attr( $primary ); ?>;
        }
        .section-news .entry-grid-elements {
            border-top-color: #<?php echo esc_attr( $primary ); ?>;
        }
        <?php
    }

    $gallery_spacing = absint( get_theme_mod( 'gallery_spacing', 20 ) );
    ?>
    .gallery-carousel .g-item{
        padding: 0px <?php echo intval( $gallery_spacing / 2 ); ?>px;
    }
    .gallery-carousel {
        margin-left: -<?php echo intval( $gallery_spacing / 2 ); ?>px;
        margin-right: -<?php echo intval( $gallery_spacing / 2 ); ?>px;
    }
    .gallery-grid .g-item, .gallery-masonry .g-item .inner {
        padding: <?php echo intval( $gallery_spacing / 2 ); ?>px;
    }
    .gallery-grid, .gallery-masonry {
        margin: -<?php echo intval( $gallery_spacing / 2 ); ?>px;
    }
    <?php


    $css = ob_get_clean();
    $custom = get_option( 'screenr_custom_css' );
    if ( $custom ){
        $css.= "\n/* --- Begin custom CSS --- */\n". $custom."\n/* --- End custom CSS --- */\n";
    }
    $css = apply_filters( 'screenr_custom_style', $css );

    if ( screenr_is_selective_refresh() ) {
        return $css;
    } else {
        wp_add_inline_style( 'screenr-style', $css );
    }
}

add_action( 'wp_enqueue_scripts', 'screenr_custom_style', 55 );


/**
 * Setup page header cover
 *
 * @return bool
 */
function screenr_page_header_cover()
{

    if ( is_page_template( 'template-frontpage.php' ) ) {
        return false;
    }

    $image = $title = $desc = '';

    if ( is_singular() && ! is_attachment() ) {
        if ( is_single() ) {
            $title = esc_html( get_theme_mod( 'page_blog_title', esc_html__( 'The Blog', 'screenr' ) ) );
        } else {
            $title = get_the_title();
        }
    } elseif ( is_search() ) {
        $title = sprintf( esc_html__( 'Search Results for: %s', 'screenr' ), '<span>' . esc_html( get_search_query() ) . '</span>' );
    } elseif ( ( is_home() || is_front_page() ) && ! is_attachment() ) {
        $title = esc_html( get_theme_mod( 'page_blog_title', esc_html__( 'The Blog', 'screenr' ) ) );
    } elseif ( is_404() ) {
        $title = sprintf( esc_html__( '%s 404 Not Found!', 'screenr' ), '<i class="fa fa-frown-o"></i><br>' );
    } else {
        //$title = get_the_archive_title();
        $desc  = get_the_archive_description();
        $title = $desc;
    }

    if ( ! $image ) {
        $image = get_header_image();
    }

    $is_parallax  = true;
    $item = array(
        'position'  => 'center',
        'pd_top'    => get_theme_mod( 'page_header_pdtop') == '' ? 13 : get_theme_mod( 'page_header_pdtop'),
        'pd_bottom' => get_theme_mod( 'page_header_pdbottom' ) == '' ? 13 : get_theme_mod( 'page_header_pdbottom' ) ,
        'title'     => $title,
        'desc'      => $desc,
        'image'     => $image,
    );

    $classes = array(
        'section-slider',
        'swiper-slider',
    );

    if ( $is_parallax ) {
        $classes[] = 'fixed';
    }

    $item = apply_filters( 'screenr_page_header_item', $item );

    if ( $item['image'] ) {
        $classes[] = 'has-image';
    } else {
        $classes[] = 'no-image';
    }

    $classes = apply_filters( 'screenr_page_header_cover_class', $classes );

    ?>
    <section id="page-header-cover" class="<?php echo esc_attr(  join( ' ', $classes ) ); ?>" >
        <div class="swiper-container" data-autoplay="0">
            <div class="swiper-wrapper">
                <?php

                $style = "";
                if ( $item['image'] ) {
                    $style = ' style="background-image: url(\''.esc_url( $item['image'] ).'\');" ';
                }

                $html = '<div class="swiper-slide slide-align-'.esc_attr( $item['position'] ).'"'.$style.'>';

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
                if ( $item['title'] ) {
                    $html .= '<h1 class="swiper-slide-heading">'.wp_kses_post( $item['title'] ).'</h1>';
                }
                if ( $item['desc'] ) {
                    //$html .= '<div class="swiper-slide-desc">'.apply_filters( 'screenr_content_text', $item['desc'] ).'</div>';
                }

                $html .= '</div>';
                $html .= '</div>';
                $html .= '<div class="overlay"></div>';
                $html .= '</div>';

                echo $html;
                ?>
            </div>
        </div>
    </section>
    <?php
}

add_action( 'screenr_after_site_header', 'screenr_page_header_cover' );


if ( ! function_exists( 'screenr_admin_scripts' ) ) {
    /**
     * Enqueue scripts for admin page only: Theme info page
     */
    function screenr_admin_scripts($hook)
    {
        if ($hook === 'widgets.php' || $hook === 'appearance_page_ft_screenr') {
            wp_enqueue_style('screenr-admin-css', get_template_directory_uri() . '/assets/css/admin.css');
            // Add recommend plugin css
            wp_enqueue_style( 'plugin-install' );
            wp_enqueue_script( 'plugin-install' );
            wp_enqueue_script( 'updates' );
            add_thickbox();
        }
    }
}
add_action( 'admin_enqueue_scripts', 'screenr_admin_scripts' );



/**
 * Output the status of widets for footer column.
 *
 */
function screenr_sidebar_desc( $sidebar_id ) {

    $desc           = '';
    $column         = str_replace( 'footer-', '', $sidebar_id );
    $footer_columns = absint( get_theme_mod( 'footer_layout', 4 ) );

    if ( $column > $footer_columns ) {
        $desc = esc_html__( 'This widget area is currently disabled. You can enable it Customizer &rarr; Theme Options &rarr; Footer section.', 'screenr' );
    }

    return esc_html( $desc );
}

function screenr_get_default_slider_content(){
    $slider_content = wp_kses_post(
        sprintf(
            '<h1><strong>%1$s</strong></h1>'
            ."\n\n". '%2$s'."\n\n".'<a class="btn btn-lg btn-theme-primary" href="#features">%3$s</a> <a class="btn btn-lg btn-secondary-outline" href="#contact">%4$s</a>',
            esc_html__( 'Your business, your website', 'screenr' ),
            esc_html__( 'Screenr is a multiuse fullscreen WordPress theme.', 'screenr' ),
            esc_html__( 'Get Started', 'screenr' ),
            esc_html__( 'Contact Now', 'screenr' )
        )
    );

    return $slider_content;
}


/**
 * Add footer theme info
 */
function screenr_footer_credits(){
    ?>
    <div class="site-info">
        <div class="container">
            <div class="row">
                <div class="col-md-6" style="text-align: left">
                    <?php  echo '&copy; 2009 - '.date_i18n('Y').' | <a href="https://portejoie.fr">Pierre Portejoie, Développeur Freelance</a><br>SIRET : 814 447 298 00013'?>
                </div><!-- .site-copyright -->
                <div class="col-md-6" style="text-align: right">
                    <?php echo '<a href="'.get_home_url().'/plan-du-site">Plan du site</a> | <a rel="nofollow" target="_blank" href="http://pjoy.fr/files/PIERRE_PORTEJOIE_CV_16_09_FR.pdf">CV</a> <br>  <a href="https://portejoie.fr/mentions-legales/">Mentions légales</a> | <a href="https://portejoie.fr/#contact">Demander un devis</a>' ?>
                </div>
            </div>
        </div>
    </div><!-- .site-info -->
    <?php
}
add_action( 'screenr_footer', 'screenr_footer_credits' );

/**
 * Get Plus version
 *
 * @return string
 */
function screenr_get_plus_url(){
    return 'https://www.famethemes.com/plugins/screenr-plus/';
}

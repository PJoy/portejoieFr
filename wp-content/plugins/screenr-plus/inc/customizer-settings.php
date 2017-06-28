<?php

// Remove upsell controls
$wp_customize->remove_section( 'front_page_sections_order_styling' );
$wp_customize->remove_section( 'screenr_plus_upgrade' );
$wp_customize->remove_section( 'premium_section_projects' );
$wp_customize->remove_section( 'premium_section_testimonials' );
$wp_customize->remove_section( 'premium_section_team' );
$wp_customize->remove_section( 'premium_section_pricing' );
$wp_customize->remove_section( 'premium_section_cta' );
$wp_customize->remove_section( 'screenr_typography_plus' );

$wp_customize->remove_control( 'footer_copyright_editor_message' );

// Theme Footer
// Copyright text option
$wp_customize->add_setting( 'screenr_footer_copyright_text',
    array(
        'sanitize_callback' => 'screenr_sanitize_text',
        'transport'         => 'postMessage',
        'default'           => ''
    )
);

$wp_customize->add_control(
    'screenr_footer_copyright_text',
    array(
        'label'       => esc_html__('Footer Copyright', 'screenr-plus'),
        'section'     => 'page_footer_settings',
        'type'        => 'textarea',
        'description' => esc_html__('Arbitrary text or HTML.', 'screenr-plus')
    )
);

// Disable theme author link
$wp_customize->add_setting( 'screenr_hide_author_link',
    array(
        'sanitize_callback' => 'screenr_sanitize_checkbox',
        'transport'         => 'postMessage',
        'default'           => 0,
    )
);
$wp_customize->add_control( 'screenr_hide_author_link',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Hide theme author link?', 'screenr-plus'),
        'section'     => 'page_footer_settings',
        'description' => esc_html__('Check this box to hide theme author link.', 'screenr-plus')
    )
);

// Page header cover
$wp_customize->add_setting( 'singular_thumb_cover',
    array(
        'sanitize_callback' => 'screenr_sanitize_checkbox',
        'transport'         => 'postMessage',
        'default'           => 1,
    )
);
$wp_customize->add_control( 'singular_thumb_cover',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Use portfolio featured thumbnail as header cover image', 'screenr-plus'),
        'section'     => 'header_image',
    )
);

// Portfolio
$wp_customize->add_section(
    'screenr_portfolio_options',
    array(
        'panel'    => 'screenr_options',
        'title'    => esc_html__( 'Portfolio', 'screenr-plus' ),
    )
);

$wp_customize->add_setting( 'show_portfolio_controls',
    array(
        'sanitize_callback' => 'screenr_sanitize_checkbox',
        'transport'         => 'postMessage',
        'default'           => 1,
    )
);
$wp_customize->add_control( 'show_portfolio_controls',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Show controls on single project/portfolio ?', 'screenr-plus'),
        'section'     => 'screenr_portfolio_options',
        'description' => esc_html__('Check show next, previous,.. button at the bottom of single portfolio page.', 'screenr-plus')
    )
);

$wp_customize->add_setting( 'show_portfolio_thumb_cover',
    array(
        'sanitize_callback' => 'screenr_sanitize_checkbox',
        'transport'         => 'postMessage',
        'default'           => 1,
    )
);
$wp_customize->add_control( 'show_portfolio_thumb_cover',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Use portfolio featured thumbnail as header cover image', 'screenr-plus'),
        'section'     => 'screenr_portfolio_options',
    )
);

// Project page link
$wp_customize->add_setting( 'portfolios_page_link',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
        'transpot'           => 'postMessage',
    )
);
$wp_customize->add_control( 'portfolios_page_link',
    array(
        'label' 		=> esc_html__('Link to projects page', 'screenr-plus'),
        'section' 		=> 'screenr_portfolio_options',
    )
);


// Number portfolios to show
$wp_customize->add_setting( 'portfolios_page_number',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 12,
    )
);
$wp_customize->add_control( 'portfolios_page_number',
    array(
        'label' 		=> esc_html__('Number portfolios to show', 'screenr-plus'),
        'section' 		=> 'screenr_portfolio_options',
        'description'   => '',
    )
);

// Project order by
$wp_customize->add_setting( 'portfolios_page_orderby',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 'ID',
    )
);

$wp_customize->add_control( 'portfolios_page_orderby',
    array(
        'label' 		=> esc_html__('Order By', 'screenr-plus'),
        'section' 		=> 'screenr_portfolio_options',
        'description'   => '',
        'type'          => 'select',
        'choices'       => array(
            'ID' => esc_html__( 'ID', 'screenr-plus' ),
            'title' => esc_html__( 'Title', 'screenr-plus' ),
            'date' => esc_html__( 'Date', 'screenr-plus' ),
            'rand' => esc_html__( 'Random', 'screenr-plus' ),
        ),
    )
);

// Project layouts
$wp_customize->add_setting( 'portfolios_page_layout',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '3',
    )
);

$wp_customize->add_control( 'portfolios_page_layout',
    array(
        'label' 		=> esc_html__('Layout columns', 'screenr-plus'),
        'section' 		=> 'screenr_portfolio_options',
        'description'   => '',
        'type'          => 'select',
        'choices'       => array(
            '2' => 2,
            '3' => 3,
            '4' => 4,
            '5' => 5,
            '5' => 6,
        ),
    )
);

// Project order
$wp_customize->add_setting( 'portfolios_page_order',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 'DESC',
    )
);

$wp_customize->add_control( 'portfolios_page_order',
    array(
        'label' 		=> esc_html__('Order', 'screenr-plus'),
        'section' 		=> 'screenr_portfolio_options',
        'description'   => '',
        'type'          => 'select',
        'choices'       => array(
            'DESC' => esc_html__( 'Descending', 'screenr-plus' ),
            'ASC' => esc_html__( 'Ascending', 'screenr-plus' ),
        ),
    )
);


// Ajax view portfolios
$wp_customize->add_setting( 'portfolios_page_ajax',
    array(
        'sanitize_callback' => 'screenr_sanitize_checkbox',
        'default'           => 0,
    )
);
$wp_customize->add_control( 'portfolios_page_ajax',
    array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Use ajax for load project details', 'screenr-plus'),
        'section'     => 'screenr_portfolio_options',
    )
);


// Project slug
$wp_customize->add_setting( 'portfolios_slug',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 'portfolio',
        'transpot'           => 'postMessage',
    )
);
$wp_customize->add_control( 'portfolios_slug',
    array(
        'label' 		=> esc_html__('Projects slug', 'screenr-plus'),
        'section' 		=> 'screenr_portfolio_options',
        'description'   => esc_html__( 'If you change this option please go to Settings > Permalinks and refresh your permalink structure before your custom post type will show the correct structure.', 'screenr-plus' ),
    )
);


// Typography
// Register typography control JS template.
$wp_customize->register_control_type( 'Screenr_Customize_Typography_Control' );

$wp_customize->add_panel(
    'screenr_typo',
    array(
        'priority' => 140,
        'title' => esc_html__( 'Typography', 'screenr-plus' )
    )
);

// For P tag
$wp_customize->add_section(
    'screenr_typography_section',
    array( 'panel'=> 'screenr_typo',
        'title' => esc_html__( 'Paragraphs', 'screenr-plus' ), 'priority' => 5, )
);

// Add the `<p>` typography settings.
// @todo Better sanitize_callback functions.
$wp_customize->add_setting(
    'screenr_typo_p',
    array(
        'sanitize_callback' => 'screenr_sanitize_typography_field',
        'transport' => 'postMessage'
    )
);

$wp_customize->add_control(
    new Screenr_Customize_Typography_Control(
        $wp_customize,
        'screenr_typo_p',
        array(
            'label'       => esc_html__( 'Paragraph Typography', 'screenr-plus' ),
            'description' => esc_html__( 'Select how you want your paragraphs to appear.', 'screenr-plus' ),
            'section'       => 'screenr_typography_section',
            'css_selector'       => 'body, body p', // css selector for live view
            'fields' => array(
                'font-family'     => '',
                'color'           => '',
                'font-style'      => '', // italic
                'font-weight'     => '',
                'font-size'       => '',
                'line-height'     => '',
                'letter-spacing'  => '',
                'text-transform'  => '',
                'text-decoration' => '',
            )
        )
    )
);

// For Menu
$wp_customize->add_section(
    'screenr_typo_logo_section',
    array(
        'panel'=> 'screenr_typo',
        'title' => esc_html__( 'Site Title', 'screenr-plus' ),
        'priority' => 5,
    )
);

// Add the menu typography settings.
// @todo Better sanitize_callback functions.
$wp_customize->add_setting(
    'screenr_typo_logo',
    array(
        'sanitize_callback' => 'screenr_sanitize_typography_field',
        'transport' => 'postMessage'
    )
);

$wp_customize->add_control(
    new Screenr_Customize_Typography_Control(
        $wp_customize,
        'screenr_typo_logo',
        array(
            'label'       => esc_html__( 'Site Title', 'screenr-plus' ),
            'description' => esc_html__( 'Apply only when logo image not use.', 'screenr-plus' ),
            'section'       => 'screenr_typo_logo_section',
            'fields' => array(
                'font-family'     => '',
                //'color'           => '',
                'font-style'      => '', // italic
                'font-weight'     => '',
                'font-size'       => '',
                //'line-height'     => '',
                'letter-spacing'  => '',
                'text-transform'  => '',
                'text-decoration' => '',
            )
        )
    )
);



// For Menu
$wp_customize->add_section(
    'screenr_typo_menu_section',
    array(
        'panel'=> 'screenr_typo',
        'title' => esc_html__( 'Menu', 'screenr-plus' ),
        'priority' => 10,
    )
);

// Add the menu typography settings.
// @todo Better sanitize_callback functions.
$wp_customize->add_setting(
    'screenr_typo_menu',
    array(
        'sanitize_callback' => 'screenr_sanitize_typography_field',
        'transport' => 'postMessage'
    )
);

$wp_customize->add_control(
    new Screenr_Customize_Typography_Control(
        $wp_customize,
        'screenr_typo_menu',
        array(
            'label'       => esc_html__( 'Menu Typography', 'screenr-plus' ),
            'description' => esc_html__( 'Select how you want your Menu to appear.', 'screenr-plus' ),
            'section'       => 'screenr_typo_menu_section',
            'fields' => array(
                'font-family'     => '',
                //'color'           => '',
                'font-style'      => '', // italic
                'font-weight'     => '',
                'font-size'       => '',
                //'line-height'     => '',
                'letter-spacing'  => '',
                'text-transform'  => '',
                'text-decoration' => '',
            )
        )
    )
);

// For Heading
$wp_customize->add_section(
    'screenr_typo_heading_section',
    array(
        'panel'=> 'screenr_typo',
        'title' => esc_html__( 'Heading', 'screenr-plus' ),
        'priority' => 15,
    )
);

// Add the menu typography settings.
// @todo Better sanitize_callback functions.
$wp_customize->add_setting(
    'screenr_typo_heading',
    array(
        'sanitize_callback' => 'screenr_sanitize_typography_field',
        'transport' => 'postMessage'
    )
);

$wp_customize->add_control(
    new Screenr_Customize_Typography_Control(
        $wp_customize,
        'screenr_typo_heading',
        array(
            'label'       => esc_html__( 'Heading Typography', 'screenr-plus' ),
            'description' => esc_html__( 'Select how you want your Heading to appear.', 'screenr-plus' ),
            'section'       => 'screenr_typo_heading_section',
            'fields' => array(
                'font-family'     => '',
                //'color'           => '',
                //'font-size'       => false, // italic
                'font-style'      => '', // italic
                'font-weight'     => '',
                'line-height'     => '',
                'letter-spacing'  => '',
                'text-transform'  => '',
                'text-decoration' => '',
            )
        )
    )
);

// For Slider
$wp_customize->add_section(
    'screenr_typo_slider_section',
    array(
        'panel'=> 'screenr_typo',
        'title' => esc_html__( 'Hero Slider', 'screenr-plus' ),
    )
);

$wp_customize->add_setting(
    'typo_slider_heading',
    array(
        'sanitize_callback' => 'screenr_sanitize_typography_field',
        'transport' => 'postMessage'
    )
);

$wp_customize->add_control(
    new Screenr_Customize_Typography_Control(
        $wp_customize,
        'typo_slider_heading',
        array(
            'label'       => esc_html__( 'Heading Typography', 'screenr-plus' ),
            'description' => esc_html__( 'Select how you want your Heading to appear.', 'screenr-plus' ),
            'section'       => 'screenr_typo_slider_section',
            'fields' => array(
                'font-family'     => '',
                //'color'           => '',
                'font-size'       => '',
                'font-style'      => '',
                'font-weight'     => '',
                'line-height'     => '',
                'letter-spacing'  => '',
                'text-transform'  => '',
                'text-decoration' => '',
            )
        )
    )
);

$wp_customize->add_setting(
    'typo_slider_desc',
    array(
        'sanitize_callback' => 'screenr_sanitize_typography_field',
        'transport' => 'postMessage'
    )
);

$wp_customize->add_control(
    new Screenr_Customize_Typography_Control(
        $wp_customize,
        'typo_slider_desc',
        array(
            'label'       => esc_html__( 'Description Typography', 'screenr-plus' ),
            'description' => esc_html__( 'Select how you want your description to appear.', 'screenr-plus' ),
            'section'       => 'screenr_typo_slider_section',
            'fields' => array(
                'font-family'     => '',
                //'color'           => '',
                'font-size'       => '',
                'font-style'      => '',
                'font-weight'     => '',
                'line-height'     => '',
                'letter-spacing'  => '',
                'text-transform'  => '',
                'text-decoration' => '',
            )
        )
    )
);

$wp_customize->add_setting(
    'typo_slider_btn',
    array(
        'sanitize_callback' => 'screenr_sanitize_typography_field',
        'transport' => 'postMessage'
    )
);

$wp_customize->add_control(
    new Screenr_Customize_Typography_Control(
        $wp_customize,
        'typo_slider_btn',
        array(
            'label'       => esc_html__( 'Buttons Typography', 'screenr-plus' ),
            'description' => esc_html__( 'Select how you want your buttons to appear.', 'screenr-plus' ),
            'section'       => 'screenr_typo_slider_section',
            'fields' => array(
                'font-family'     => '',
            )
        )
    )
);

// end typo


// Order and styling
$wp_customize->add_section( 'screenr_section_order' ,
    array(
        'priority'    => 151,
        'title'       => esc_html__( 'Sections Order & Styling', 'screenr-plus' ),
        'description' => '',
        'active_callback' => ( function_exists( 'screenr_showon_frontpage' ) ) ? 'screenr_showon_frontpage' : false
    )
);


$wp_customize->add_setting(
    'sections_order_styling',
    array(
        //'default' => json_encode( $this->get_default_sections_settings() ),
        'sanitize_callback' => 'screenr_sanitize_repeatable_data_field',
        'transport' => 'refresh', // refresh or postMessage
    ) );

$wp_customize->add_control(
    new Screenr_Customize_Repeatable_Control(
        $wp_customize,
        'sections_order_styling',
        array(
            'label' 		=> esc_html__('Sections Order & Styling', 'screenr-plus'),
            'description'   => '',
            'section'       => 'screenr_section_order',
            'live_title_id' => 'title', // apply for unput text and textarea only
            'title_format'  => esc_html__('[Custom Section]: [live_title]', 'screenr-plus'), // [live_title]
            'changeable'    => 'no', // Can Remove, add new button  default yes
            'defined_values'   => $this->get_default_sections_settings(),
            'id_key'    => 'section_id',
            'default_empty_title'  => esc_html__('Untitled', 'screenr-plus'), // [live_title]
            'fields'    => array(
                'add_by' => array(
                    'type'  =>'add_by',
                ),
                'title' => array(
                    'title' => esc_html__('Title', 'screenr-plus'),
                    'type'  =>'hidden',
                    'desc'  => ''
                ),
                'section_id' => array(
                    'title' => esc_html__('Section ID', 'screenr-plus'),
                    'type'  =>'hidden',
                    'desc'  => ''
                ),
                'show_section' => array(
                    'title' => esc_html__('Show this section', 'screenr-plus'),
                    'type'  =>'checkbox',
                    'default'  =>'1',
                ),
                'section_inverse' => array(
                    'title' => esc_html__('Inverted Style', 'screenr-plus'),
                    'desc'  => esc_html__('Make this section darker', 'screenr-plus'),
                    'type'  =>'checkbox',
                ),
                'hide_title' => array(
                    'title' => esc_html__('Hide section title', 'screenr-plus'),
                    'type'  =>'checkbox',
                    'desc'  => '',
                    'required' => array( 'add_by', '=', 'click' ) ,
                ),
                'subtitle' => array(
                    'title' => esc_html__('Subtitle', 'screenr-plus'),
                    'type'  =>'text',
                    'required' => array( 'add_by', '=', 'click' ) ,
                ),
                'desc' => array(
                    'title' => esc_html__('Section Description', 'screenr-plus'),
                    'type'  =>'editor',
                    'required' => array( 'add_by', '=', 'click' ) ,
                ),
                'content' => array(
                    'title' => esc_html__('Section Content', 'screenr-plus'),
                    'type'  =>'editor',
                    'required' => array( 'add_by', '=', 'click' ) ,
                ),
                'bg_type' => array(
                    'title' => esc_html__('Background Type', 'screenr-plus'),
                    'type'  =>'select',
                    'options'  => array(
                        'color' => esc_html__('Color', 'screenr-plus'),
                        'image' => esc_html__('Image', 'screenr-plus'),
                        'video' => esc_html__('Video', 'screenr-plus'),
                    ),
                ),
                'bg_color' => array(
                    'title' => esc_html__('Background Color', 'screenr-plus'),
                    'type'  =>'coloralpha',
                    'required' => array( 'bg_type', '=', 'color' ) ,
                ),
                'bg_image' => array(
                    'title' => esc_html__('Background Image', 'screenr-plus'),
                    'type'  =>'media',
                    'required' => array( 'bg_type', 'in', array( 'video', 'image' ) ) ,
                ),
                'enable_parallax' => array(
                    'title' => esc_html__('Enable Parallax', 'screenr-plus'),
                    'desc'  => esc_html__('Required background image and Inverted Style is checked', 'screenr-plus'),
                    'type'  =>'checkbox',
                    'required' => array( 'bg_type', '=', 'image' ) ,
                ),
                'bg_video' => array(
                    'title' => esc_html__('Background video(.MP4)', 'screenr-plus'),
                    'type'  =>'media',
                    'media'  =>'video',
                    'required' => array( 'bg_type', '=', 'video' ) ,
                    //'desc' => esc_html__('Select your video background', 'screenr-plus'),
                ),
                'bg_video_webm' => array(
                    'title' => esc_html__('Background video(.WEBM)', 'screenr-plus'),
                    'type'  =>'media',
                    'media'  =>'video',
                    'required' => array( 'bg_type', '=', 'video' ) ,
                    //'desc' => esc_html__('Select your video background', 'screenr-plus'),
                ),
                'bg_video_ogv' => array(
                    'title' => esc_html__('Background video(.OGV)', 'screenr-plus'),
                    'type'  =>'media',
                    'media'  =>'video',
                    'required' => array( 'bg_type', '=', 'video' ) ,
                    //'desc' => esc_html__('Select your video background', 'screenr-plus'),
                ),

                'bg_opacity_color' => array(
                    'title' => esc_html__('Overlay Color', 'screenr-plus'),
                    'type'  =>'coloralpha',
                    'required' => array( 'bg_type', 'in', array( 'video', 'image' ) ) ,
                ),

                /*
                'bg_opacity' => array(
                    'title' => esc_html__('Overlay Color Opacity', 'screenr-plus'),
                    'type'  =>'text',
                    'desc' => esc_html__('Enter a float number between 0.1 to 0.9', 'screenr-plus'),
                ),
                */

                'padding_top' => array(
                    'title' => esc_html__('Section Padding Top', 'screenr-plus'),
                    'type'  =>'text',
                    'desc' => esc_html__('Eg. 50px, 30%, leave empty for default value', 'screenr-plus'),
                ),
                'padding_bottom' => array(
                    'title' => esc_html__('Section Padding Bottom', 'screenr-plus'),
                    'type'  =>'text',
                    'desc' => esc_html__('Eg. 50px, 30%, leave empty for default value', 'screenr-plus'),
                ),

            ),
        )
    )
);

/*------------------------------------------------------------------------*/
/*  Section: Slider
/*------------------------------------------------------------------------*/
$wp_customize->remove_control( 'slider_items' );
$wp_customize->add_control(
    new Screenr_Customize_Repeatable_Control(
        $wp_customize,
        'slider_items',
        array(
            'label'     => esc_html__('Hero Items', 'screenr-plus'),
            'description'   => '',
            'section'       => 'section_slider',
            'live_title_id' => 'title', // apply for input text and textarea only
            'title_format'  => esc_html__('[live_title]', 'screenr-plus'), // [live_title]
            'max_item'      => 1, // Maximum item can add
            'limited_msg' 	=> wp_kses_post( 'Upgrade to <a target="_blank" href="#">Screenr Plus</a> to able add video background and enable sliders.', 'screenr-plus' ),
            'fields'    => array(
                'layout' => array(
                    'title' => esc_html__('Content layout', 'screenr-plus'),
                    'type'  =>'select',
                    'options' => apply_filters( 'screenr_slider_content_layout', array(
                        'layout_1' => esc_html__('Layout 1', 'screenr-plus'),
                        'layout_2' => esc_html__('Layout 2', 'screenr-plus'),
                    ) )
                ),
                'content_layout_1' => array(
                    'title' => esc_html__('Content layout 1', 'screenr-plus'),
                    'type'  =>'editor',
                    'mod'   =>'html',
                    'default' => wp_kses_post( '<h1><strong>Your business, your website</strong></h1>
                                                    Screenr is a multiuse fullscreen WordPress theme.

                                                    <a class="btn btn-lg btn-theme-primary" href="#features">Get Started</a><a class="btn btn-lg btn-secondary-outline" href="#contact">Contact Now</a>'
                    ),
                    "required" => array( 'layout', '=', 'layout_1' )
                ),
                'content_layout_2' => array(
                    'title' => esc_html__('Content layout 2', 'screenr-plus'),
                    'type'  =>'editor',
                    'mod'   =>'html',
                    'default' => '',
                    "required" => array( 'layout', '=', 'layout_2' )
                ),

                'bg_type' => array(
                    'title' => esc_html__('Media type', 'screenr'),
                    'type'  =>'select',
                    'options' => apply_filters( 'screenr_slider_content_layout', array(
                        'image' => esc_html__('Image', 'screenr-plus'),
                        'video' => esc_html__('Video', 'screenr-plus'),
                    ) )
                ),

                'media' => array(
                    'title' => esc_html__('Image', 'screenr-plus'),
                    'type'  =>'media',
                    'default' => array(
                        'url' => '',
                        'id' => ''
                    ),
                ),

                'video_mp4' => array(
                    'title' => esc_html__('Video (.mp4)', 'screenr-plus'),
                    'type'  =>'media',
                    'default' => array(
                        'url' => '',
                        'id' => ''
                    ),
                    "required" => array( 'bg_type', '=', array( 'video' )  )
                ),

                'video_ogv' => array(
                    'title' => esc_html__('Video (.ogv)', 'screenr-plus'),
                    'type'  =>'media',
                    'default' => array(
                        'url' => '',
                        'id' => ''
                    ),
                    "required" => array( 'bg_type', '=', array( 'video' )  )
                ),

                'video_webm' => array(
                    'title' => esc_html__('Video (.webm)', 'screenr-plus'),
                    'type'  =>'media',
                    'default' => array(
                        'url' => '',
                        'id' => ''
                    ),
                    "required" => array( 'bg_type', '=', array( 'video' )  )
                ),


                'position' => array(
                    'title' => esc_html__('Content align', 'screenr-plus'),
                    'type'  =>'select',
                    'options' => array(
                        'center' => esc_html__('Center', 'screenr-plus'),
                        'left' => esc_html__('Left', 'screenr-plus'),
                        'right' => esc_html__('Right', 'screenr-plus'),
                    )
                ),

            ),

        )
    )
);
// Slider autoplay
$wp_customize->add_setting( 'slider_autoplay',
    array(
        'sanitize_callback' => 'screenr_sanitize_text',
        'default'           => 7000,
    )
);
$wp_customize->add_control( 'slider_autoplay',
    array(
        'label'     => esc_html__('Autoplay', 'screenr-plus'),
        'section' 		=> 'section_slider',
        'priority'      => 70,
        'description'   => esc_html__( 'delay between transitions (in ms). If this parameter is not specified, auto play will be disabled', 'screenr-plus' ),
    )
);

// Slider speed
$wp_customize->add_setting( 'slider_speed',
    array(
        'sanitize_callback' => 'screenr_sanitize_text',
        'default'           => 700,
    )
);
$wp_customize->add_control( 'slider_speed',
    array(
        'label'     => esc_html__('Speed', 'screenr-plus'),
        'section' 		=> 'section_slider',
        'priority'      => 73,
        'description'   => esc_html__( 'Duration of transition between slides (in ms)', 'screenr-plus' ),
    )
);

// Slider effect
$wp_customize->add_setting( 'slider_effect',
    array(
        'sanitize_callback' => 'screenr_sanitize_text',
        'default'           => 'slide',
    )
);
$wp_customize->add_control( 'slider_effect',
    array(
        'label'     => esc_html__('Effect', 'screenr-plus'),
        'section' 		=> 'section_slider',
        'priority'      => 76,
        'type'          => 'select',
        'choices'       => array(// "slide", "fade", "cube", "coverflow" or "flip"
            'slide' => esc_html__( 'slide', 'screenr-plus' ),
            'fade' => esc_html__( 'fade', 'screenr-plus' ),
            'cube' => esc_html__( 'cube', 'screenr-plus' ),
            'coverflow' => esc_html__( 'coverflow', 'screenr-plus' ),
            'flip' => esc_html__( 'flip', 'screenr-plus' ),
        ),
    )
);





/*------------------------------------------------------------------------*/
/*  Section: Testimonials
/*------------------------------------------------------------------------*/

$wp_customize->add_section( 'screenr_testimonials' ,
    array(

        'title'       => esc_html__( 'Testimonials', 'screenr-plus' ),
        'description' => '',
        'panel'       => 'front_page_sections',
        'priority'    => 16,
    )
);

// Group Heading
$wp_customize->add_control( new Screenr_Group_Settings_Heading_Control( $wp_customize, 'testi_setting_group_heading',
        array(
            'priority'    => 1,
            'type' 			=> 'group_heading_top',
            'title'			=> esc_html__( 'Section Settings', 'screenr' ),
            'section' 		=> 'screenr_testimonials'
        )
    )
);

// Section ID
$wp_customize->add_setting( 'testimonials_id',
    array(
        'sanitize_callback' => 'screenr_sanitize_text',
        'default'           => esc_html__('testimonials', 'screenr-plus'),
    )
);
$wp_customize->add_control( 'testimonials_id',
    array(
        'label'     => esc_html__('Section ID:', 'screenr-plus'),
        'section' 		=> 'screenr_testimonials',
        'description'   => esc_html__( 'The section id, we will use this for link anchor.', 'screenr-plus' ),
    )
);

// Title
$wp_customize->add_setting( 'testimonials_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__('Testimonials', 'screenr-plus'),
    )
);
$wp_customize->add_control( 'testimonials_title',
    array(
        'label'     => esc_html__('Section Title', 'screenr-plus'),
        'section' 		=> 'screenr_testimonials',
        'description'   => '',
    )
);

// Sub Title
$wp_customize->add_setting( 'testimonials_subtitle',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__('Section subtitle', 'screenr-plus'),
    )
);
$wp_customize->add_control( 'testimonials_subtitle',
    array(
        'label'     => esc_html__('Section Subtitle', 'screenr-plus'),
        'section' 		=> 'screenr_testimonials',
        'description'   => '',
    )
);

// Description
$wp_customize->add_setting( 'testimonials_desc',
    array(
        'sanitize_callback' => 'screenr_sanitize_text',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'testimonials_desc',
    array(
        'label' 		=> esc_html__('Section Description', 'screenr-plus'),
        'section' 		=> 'screenr_testimonials',
        'description'   => '',
        'type'          => 'textarea',
    )
);

// Testimonials content
$wp_customize->add_control( new Screenr_Group_Settings_Heading_Control( $wp_customize, 'testi_content_group_heading',
        array(
            'priority'      => 30,
            'type' 			=> 'group_heading',
            'title'			=> esc_html__( 'Section content', 'screenr' ),
            'section' 		=> 'screenr_testimonials'
        )
    )
);

$wp_customize->add_setting(
    'testimonials_items',
    array(
        'default' => array(
            array(
                'title' 		=> esc_html__( 'Praesent placerat', 'screenr-plus' ),
                'name' 			=> esc_html__( 'Alexander Rios', 'screenr-plus' ),
                'subtitle' 		=> esc_html__( 'Founder & CEO', 'screenr-plus' ),
                'style'         => 'light',
                'image' 		=> array(
                    'url' => SCREENR_PLUS_URL . 'assets/images/testimonial_1.jpg',
                    'id'  => ''
                ),
                'content' 		=> esc_html__( 'Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat.', 'screenr-plus' ),

            ),
            array(
                'title' 		=> esc_html__( 'Cras iaculis', 'screenr-plus' ),
                'name' 			=> esc_html__( 'Alexander Max', 'screenr-plus' ),
                'subtitle' 		=> esc_html__( 'Founder & CEO', 'screenr-plus' ),
                'style'         => 'light',
                'image' 		=> array(
                    'url' => SCREENR_PLUS_URL . 'assets/images/testimonial_2.jpg',
                    'id'  => ''
                ),
                'content' 		=> esc_html__( 'Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue eu vulputate.', 'screenr-plus' ),

            ),
            array(
                'title' 		=> esc_html__( 'Fusce lobortis', 'screenr-plus' ),
                'name' 			=> esc_html__( 'Peter Mendez', 'screenr-plus' ),
                'subtitle' 		=> esc_html__( 'Example Company', 'screenr-plus' ),
                'style'         => 'light',
                'image' 		=> array(
                    'url' => SCREENR_PLUS_URL . 'assets/images/testimonial_3.jpg',
                    'id'  => ''
                ),
                'content' 		=> esc_html__( 'Sed adipiscing ornare risus. Morbi est est, blandit sit amet, sagittis vel, euismod vel, velit. Pellentesque egestas sem. Suspendisse commodo ullamcorper magna egestas sem.', 'screenr-plus' ),
            ),
        ),
        'sanitize_callback' => 'screenr_sanitize_repeatable_data_field',
        'transport' => 'refresh', // refresh or postMessage
    ) );

$wp_customize->add_control(
    new Screenr_Customize_Repeatable_Control(
        $wp_customize,
        'testimonials_items',
        array(
            'priority'      => 35,
            'label'         => esc_html__('Testimonials', 'screenr-plus'),
            'description'   => '',
            'section'       => 'screenr_testimonials',
            'live_title_id' => 'title', // apply for unput text and textarea only
            'title_format'  => esc_html__( '[live_title]', 'screenr-plus'), // [live_title]
            'max_item'      => 3, // Maximum item can add

            'fields'    => array(
                'title' => array(
                    'title' => esc_html__('Title', 'screenr-plus'),
                    'type'  =>'text',
                    'desc'  => '',
                    'default'  => esc_html__('Testimonial title', 'screenr-plus'),
                ),
                'name' => array(
                    'title' => esc_html__('Name', 'screenr-plus'),
                    'type'  =>'text',
                    'desc'  => '',
                    'default'  => esc_html__('User name', 'screenr-plus'),
                ),
                'image' => array(
                    'title' => esc_html__('Avatar', 'screenr-plus'),
                    'type'  =>'media',
                    'desc'  => esc_html__( 'Suggestion: 100x100px square image.', 'screenr-plus' ),
                    'default' => array(
                        'url' => SCREENR_PLUS_URL.'assets/images/testimonial_1.jpg',
                        'id' => ''
                    )
                ),
                'subtitle' => array(
                    'title' => esc_html__('Subtitle', 'screenr-plus'),
                    'type'  =>'textarea',
                    'default'  => esc_html__('Example Company', 'screenr-plus'),
                ),
                'content' => array(
                    'title' => esc_html__('Content', 'screenr-plus'),
                    'type'  =>'textarea',
                    'default'  => esc_html__('Whatever your user say', 'screenr-plus'),
                ),

                'style' => array(
                    'title' => esc_html__('Style', 'screenr-plus'),
                    'type'  =>'select',
                    'default'  => 'light',
                    'options' => array(
                        'theme-primary' => esc_html__( 'Theme default', 'screenr-plus' ),
                        'light' => esc_html__( 'Light', 'screenr-plus' ),
                        'primary' => esc_html__( 'Primary', 'screenr-plus' ),
                        'success' => esc_html__( 'Success', 'screenr-plus' ),
                        'info' => esc_html__( 'Info', 'screenr-plus' ),
                        'warning' => esc_html__( 'Warning', 'screenr-plus' ),
                        'danger' => esc_html__( 'Danger', 'screenr-plus' ),
                    )
                ),
            ),

        )
    )
);


// Testi layout
$wp_customize->add_setting( 'testimonials_layout',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 3,
    )
);

$wp_customize->add_control( 'testimonials_layout',
    array(
        'label' 		=> esc_html__('Number of item per row', 'screenr-plus'),
        'section' 		=> 'screenr_testimonials',
        'priority'      => 45,
        'description'   => '',
        'type'          => 'select',
        'choices'       => array(
            '2' => 2,
            '3' => 3,
            '4' => 4,
        ),
    )
);


/*------------------------------------------------------------------------*/
/*  Section: Project
/*------------------------------------------------------------------------*/

$wp_customize->add_section( 'screenr_portfolios' ,
    array(
        'title'       => esc_html__( 'Projects', 'screenr-plus' ),
        'panel'       => 'front_page_sections',
        'priority'    => 12,
    )
);

// Group Heading
$wp_customize->add_control( new Screenr_Group_Settings_Heading_Control( $wp_customize, 'portfolios_setting_group_heading',
        array(
            'priority'    => 1,
            'type' 			=> 'group_heading_top',
            'title'			=> esc_html__( 'Section Settings', 'screenr' ),
            'section' 		=> 'screenr_portfolios'
        )
    )
);

// Project ID
$wp_customize->add_setting( 'portfolios_id',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 'portfolios',
    )
);
$wp_customize->add_control( 'portfolios_id',
    array(
        'label' 		=> esc_html__('Section ID', 'screenr-plus'),
        'section' 		=> 'screenr_portfolios',
        'description'   => '',
    )
);

// Project title
$wp_customize->add_setting( 'portfolios_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__( 'Featured Projects', 'screenr-plus' ),
    )
);
$wp_customize->add_control( 'portfolios_title',
    array(
        'label' 		=> esc_html__('Section Title', 'screenr-plus'),
        'section' 		=> 'screenr_portfolios',
        'description'   => '',
    )
);

// Project subtitle
$wp_customize->add_setting( 'portfolios_subtitle',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__( 'Some of our works', 'screenr-plus' ),
    )
);
$wp_customize->add_control( 'portfolios_subtitle',
    array(
        'label' 		=> esc_html__('Section subtitle', 'screenr-plus'),
        'section' 		=> 'screenr_portfolios',
        'description'   => '',
    )
);

// Description
$wp_customize->add_setting( 'portfolios_desc',
    array(
        'sanitize_callback' => 'screenr_sanitize_text',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'portfolios_desc',
    array(
        'label' 		=> esc_html__('Section Description', 'screenr-plus'),
        'section' 		=> 'screenr_portfolios',
        'description'   => '',
        'type'          => 'textarea',
    )
);

// Group Heading
$wp_customize->add_control( new Screenr_Group_Settings_Heading_Control( $wp_customize, 'portfolios_content_group_heading',
        array(
            'priority'    => 35,
            'type' 			=> 'group_heading',
            'title'			=> esc_html__( 'Section Content', 'screenr-plus' ),
            'section' 		=> 'screenr_portfolios'
        )
    )
);

// Number portfolios to show
$wp_customize->add_setting( 'portfolios_number',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '6',
    )
);
$wp_customize->add_control( 'portfolios_number',
    array(
        'label' 		=> esc_html__('Number portfolios to show', 'screenr-plus'),
        'section' 		=> 'screenr_portfolios',
        'priority'      => 40,
        'description'   => '',
    )
);

// Project order by
$wp_customize->add_setting( 'portfolios_orderby',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 'date',
    )
);

$wp_customize->add_control( 'portfolios_orderby',
    array(
        'label' 		=> esc_html__('Order By', 'screenr-plus'),
        'section' 		=> 'screenr_portfolios',
        'priority'      => 45,
        'description'   => '',
        'type'          => 'select',
        'choices'       => array(
            'ID' => esc_html__( 'ID', 'screenr-plus' ),
            'title' => esc_html__( 'Title', 'screenr-plus' ),
            'date' => esc_html__( 'Date', 'screenr-plus' ),
            'rand' => esc_html__( 'Random', 'screenr-plus' ),
        ),
    )
);

// Project layouts
$wp_customize->add_setting( 'portfolios_layout',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '3',
    )
);

$wp_customize->add_control( 'portfolios_layout',
    array(
        'label' 		=> esc_html__('Layout columns', 'screenr-plus'),
        'section' 		=> 'screenr_portfolios',
        'priority'      => 50,
        'description'   => '',
        'type'          => 'select',
        'choices'       => array(
            '2' => 2,
            '3' => 3,
            '4' => 4,
            '5' => 5,
            '5' => 6,
        ),
    )
);

// Project order
$wp_customize->add_setting( 'portfolios_order',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 'DESC',
    )
);

$wp_customize->add_control( 'portfolios_order',
    array(
        'label' 		=> esc_html__('Order', 'screenr-plus'),
        'section' 		=> 'screenr_portfolios',
        'description'   => '',
        'type'          => 'select',
        'priority'      => 55,
        'choices'       => array(
            'DESC' => esc_html__( 'Descending', 'screenr-plus' ),
            'ASC' => esc_html__( 'Ascending', 'screenr-plus' ),
        ),
    )
);


// Ajax view portfolios
$wp_customize->add_setting( 'portfolios_ajax',
    array(
        'sanitize_callback' => 'screenr_sanitize_checkbox',
        'default'           => 0,
    )
);
$wp_customize->add_control( 'portfolios_ajax',
    array(
        'type'        => 'checkbox',
        'priority'    => 60,
        'label'       => esc_html__('Use ajax for load project details', 'screenr-plus'),
        'section'     => 'screenr_portfolios',
    )
);


// end project

/*------------------------------------------------------------------------*/
/*  Section: Pricing Table
/*------------------------------------------------------------------------*/

$wp_customize->add_section( 'screenr_pricing' ,
    array(
        //'priority'    => 3,
        'title'       => esc_html__( 'Pricing', 'screenr-plus' ),
        'panel'       => 'front_page_sections',
        'priority'    => 18,
    )
);

// Group Heading
$wp_customize->add_control( new Screenr_Group_Settings_Heading_Control( $wp_customize, 'pricing_setting_group_heading',
        array(
            'priority'    => 1,
            'type' 			=> 'group_heading_top',
            'title'			=> esc_html__( 'Section Settings', 'screenr' ),
            'section' 		=> 'screenr_pricing'
        )
    )
);

// Pricing ID
$wp_customize->add_setting( 'pricing_id',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 'pricing',
    )
);
$wp_customize->add_control( 'pricing_id',
    array(
        'label' 		=> esc_html__('Section ID', 'screenr-plus'),
        'section' 		=> 'screenr_pricing',
        'description'   => '',
    )
);

// Project title
$wp_customize->add_setting( 'pricing_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__( 'Pricing Table', 'screenr-plus' ),
    )
);
$wp_customize->add_control( 'pricing_title',
    array(
        'label' 		=> esc_html__('Section Title', 'screenr-plus'),
        'section' 		=> 'screenr_pricing',
        'description'   => '',
    )
);

// Project subtitle
$wp_customize->add_setting( 'pricing_subtitle',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__( 'Responsive pricing section', 'screenr-plus' ),
    )
);
$wp_customize->add_control( 'pricing_subtitle',
    array(
        'label' 		=> esc_html__('Section Subtitle', 'screenr-plus'),
        'section' 		=> 'screenr_pricing',
        'description'   => '',
    )
);

// Description
$wp_customize->add_setting( 'pricing_desc',
    array(
        'sanitize_callback' => 'screenr_sanitize_text',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'pricing_desc',
    array(
        'label' 		=> esc_html__('Section Description', 'screenr-plus'),
        'section' 		=> 'screenr_pricing',
        'description'   => '',
        'type'          => 'textarea',
    )
);

// Group Heading
$wp_customize->add_control( new Screenr_Group_Settings_Heading_Control( $wp_customize, 'pricing_content_group_heading',
        array(
            'priority'    => 35,
            'type' 			=> 'group_heading',
            'title'			=> esc_html__( 'Section Content', 'screenr' ),
            'section' 		=> 'screenr_pricing'
        )
    )
);


$wp_customize->add_setting(
    'pricing_plans',
    array(
        'default' => array(
                array(
                    'title' => esc_html__( 'Freelancer', 'screenr-plus' ),
                    'code'  => esc_html__( '$', 'screenr-plus' ),
                    'price'  => '9.90',
                    'subtitle' => esc_html__( 'Perfect for single freelancers who work by themselves', 'screenr-plus' ),
                    'content' => esc_html__( "Support Forum \nFree hosting\n 1 hour of support\n 40MB of storage space", 'screenr-plus' ),
                    'label' => esc_attr__( 'Choose Plan', 'screenr-plus' ),
                    'link' => '#',
                    'button' => 'btn-theme-primary',
                ),
                array(
                    'title' => esc_html__( 'Small Business', 'screenr-plus' ),
                    'code'  => esc_html__( '$', 'screenr-plus' ),
                    'price'  => '29.9',
                    'subtitle' => esc_html__( 'Suitable for small businesses with up to 5 employees', 'screenr-plus' ),
                    'content' => esc_html__( "Support Forum \nFree hosting\n 10 hour of support\n 1GB of storage space", 'screenr-plus' ),
                    'label' => esc_attr__( 'Choose Plan', 'screenr-plus' ),
                    'link' => '#',
                    'button' => 'btn-success',
                ),
                array(
                    'title' => esc_html__( 'Larger Business', 'screenr-plus' ),
                    'code'  => esc_html__( '$', 'screenr-plus' ),
                    'price'  => '59.90',
                    'subtitle' => esc_html__( 'Great for large businesses with more than 5 employees', 'screenr-plus' ),
                    'content' => esc_html__( "Support Forum \nFree hosting\n Unlimited hours of support\n Unlimited storage space", 'screenr-plus' ),
                    'label' => esc_attr__( 'Choose Plan', 'screenr-plus' ),
                    'link' => '#',
                    'button' => 'btn-theme-primary',
                ),

        ),
        'sanitize_callback' => 'screenr_sanitize_repeatable_data_field',
        'transport' => 'refresh', // refresh or postMessage
    ) );


$wp_customize->add_control(
    new Screenr_Customize_Repeatable_Control(
        $wp_customize,
        'pricing_plans',
        array(
            'label'     	=> esc_html__('Pricing Plans', 'screenr-plus'),
            'priority'      => 40,
            'description'   => '',
            'section'       => 'screenr_pricing',
            'live_title_id' => 'title', // apply for unput text and textarea only
            'title_format'  => esc_html__('[live_title]', 'screenr-plus'), // [live_title]
            'max_item'      => 4, // Maximum item can add

            'fields'    => array(
                'title' => array(
                    'title' => esc_html__('Title', 'screenr-plus'),
                    'type'  =>'text',
                    'desc'  => '',
                    'default' => esc_html__( 'Your service title', 'screenr-plus' ),
                ),
                'price' => array(
                    'title' => esc_html__('Price', 'screenr-plus'),
                    'type'  =>'text',
                    'default' => esc_html__( '99', 'screenr-plus' ),
                ),
                'code' => array(
                    'title' => esc_html__('Currency code', 'screenr-plus'),
                    'type'  =>'text',
                    'default' => esc_html__( '$', 'screenr-plus' ),
                ),
                'subtitle' => array(
                    'title' => esc_html__('Subtitle', 'screenr-plus'),
                    'type'  =>'text',
                    'desc'  => '',
                    'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit', 'screenr-plus' ),
                ),
                'content'  => array(
                    'title' => esc_html__('Option list', 'screenr-plus'),
                    'desc'  => esc_html__('Earch option per line', 'screenr-plus'),
                    'type'  =>'textarea',
                    'default' => esc_html__( "Option 1\n Option 2\n Option 3\n Option 4", 'screenr-plus' ),
                ),
                'label' => array(
                    'title' => esc_html__('Button label', 'screenr-plus'),
                    'type'  =>'text',
                    'desc'  => '',
                    'default' =>  esc_html__('Choose Plan', 'screenr-plus'),
                ),
                'link' => array(
                    'title' => esc_html__('Button Link', 'screenr-plus'),
                    'type'  =>'text',
                    'desc'  => '',
                    'default' => '#',
                ),
                'button'  => array(
                    'title' => esc_html__('Button style', 'screenr-plus'),
                    'type'  =>'select',
                    'options' => array(
                        'btn-theme-primary' => esc_html__('Theme default', 'screenr-plus'),
                        'btn-default' => esc_html__('Button', 'screenr-plus'),
                        'btn-primary' => esc_html__('Primary', 'screenr-plus'),
                        'btn-success' => esc_html__('Success', 'screenr-plus'),
                        'btn-info' => esc_html__('Info', 'screenr-plus'),
                        'btn-warning' => esc_html__('Warning', 'screenr-plus'),
                        'btn-danger' => esc_html__('Danger', 'screenr-plus'),
                    )
                ),
            ),

        )
    )
);
// end pricing

/*------------------------------------------------------------------------*/
/*  Section: cta
/*------------------------------------------------------------------------*/

$wp_customize->add_section( 'screenr_cta' , array(
        'title'       => esc_html__( 'Call to Action', 'screenr-plus' ),
        'panel'       => 'front_page_sections',
        'priority'    => 17,
    )
);

// Group Heading
$wp_customize->add_control( new Screenr_Group_Settings_Heading_Control( $wp_customize, 'cta_setting_group_heading',
        array(
            'priority'    => 1,
            'type' 			=> 'group_heading_top',
            'title'			=> esc_html__( 'Section Settings', 'screenr' ),
            'section' 		=> 'screenr_cta'
        )
    )
);

// Section ID
$wp_customize->add_setting( 'cta_id',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 'section-cta',
    )
);
$wp_customize->add_control( 'cta_id',
    array(
        'label' 		=> esc_html__('Section ID', 'screenr-plus'),
        'section' 		=> 'screenr_cta',
    )
);

// Title
$wp_customize->add_setting( 'cta_title',
    array(
        'sanitize_callback' => 'screenr_sanitize_text',
        'default'           => esc_html__( 'Use these ribbons to display calls to action mid-page.' , 'screenr-plus' ),
    )
);
$wp_customize->add_control( 'cta_title',
    array(
        'label' 		=> esc_html__('Title', 'screenr-plus'),
        'section' 		=> 'screenr_cta',
    )
);

// Button label
$wp_customize->add_setting( 'cta_btn_label',
    array(
        'sanitize_callback' => 'screenr_sanitize_text',
        'default'           => esc_html__( 'Button Text' , 'screenr-plus' ),
    )
);
$wp_customize->add_control( 'cta_btn_label',
    array(
        'label' 		=> esc_html__('Button Text', 'screenr-plus'),
        'section' 		=> 'screenr_cta',
    )
);

// Button link
$wp_customize->add_setting( 'cta_btn_link',
    array(
        'sanitize_callback' => 'screenr_sanitize_text',
        'default'           => '',
    )
);
$wp_customize->add_control( 'cta_btn_link',
    array(
        'label' 		=> esc_html__('Button Link', 'screenr-plus'),
        'section' 		=> 'screenr_cta',
    )
);
// EN Add cta


/*------------------------------------------------------------------------*/
/*  Section: Team
/*------------------------------------------------------------------------*/

$wp_customize->add_section( 'screenr_team' ,
    array(
        'title'       => esc_html__( 'Team', 'screenr-plus' ),
        'panel'       => 'front_page_sections',
        'priority'    => 19,
    )
);

// Group Heading
$wp_customize->add_control( new Screenr_Group_Settings_Heading_Control( $wp_customize, 'team_setting_group_heading',
        array(
            'priority'    => 1,
            'type' 			=> 'group_heading_top',
            'title'			=> esc_html__( 'Section Settings', 'screenr' ),
            'section' 		=> 'screenr_team'
        )
    )
);

// Section ID
$wp_customize->add_setting( 'team_id',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 'team',
    )
);
$wp_customize->add_control( 'team_id',
    array(
        'label' 		=> esc_html__('Section ID', 'screenr-plus'),
        'section' 		=> 'screenr_team',
    )
);

// Title
$wp_customize->add_setting( 'team_title',
    array(
        'sanitize_callback' => 'screenr_sanitize_text',
        'default'           => esc_html__('Our Team', 'screenr-plus'),
    )
);
$wp_customize->add_control( 'team_title',
    array(
        'label' 		=> esc_html__('Section Title', 'screenr-plus'),
        'section' 		=> 'screenr_team',
    )
);

// clients subtitle
$wp_customize->add_setting( 'team_subtitle',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => esc_html__('Section subtitle', 'screenr-plus'),
    )
);
$wp_customize->add_control( 'team_subtitle',
    array(
        'label' 		=> esc_html__('Section subtitle', 'screenr-plus'),
        'section' 		=> 'screenr_team',
        'description'   => '',
    )
);

// Description
$wp_customize->add_setting( 'team_desc',
    array(
        'sanitize_callback' => 'screenr_sanitize_text',
        'default'           => '',
    )
);
$wp_customize->add_control(
    'team_desc',
    array(
        'label' 		=> esc_html__('Section Description', 'screenr-plus'),
        'section' 		=> 'screenr_team',
        'description'   => '',
        'type'          => 'textarea',

    )
);

// Group Heading
$wp_customize->add_control( new Screenr_Group_Settings_Heading_Control( $wp_customize, 'team_content_group_heading',
        array(
            'priority'    => 35,
            'type' 			=> 'group_heading',
            'title'			=> esc_html__( 'Section Settings', 'screenr' ),
            'section' 		=> 'screenr_team'
        )
    )
);

$wp_customize->add_setting(
    'team_members',
    array(
        'default' => screenr_plus_get_default_team_members(),
        'sanitize_callback' => 'screenr_sanitize_repeatable_data_field',
        'transport' => 'refresh', // refresh or postMessage
    ) );


$wp_customize->add_control(
    new Screenr_Customize_Repeatable_Control(
        $wp_customize,
        'team_members',
        array(
            'label'     	=> esc_html__('Members', 'screenr-plus'),
            'description'   => '',
            'section'       => 'screenr_team',
            'priority'      => 45,
            'live_title_id' => 'title', // apply for unput text and textarea only
            'title_format'  => esc_html__('[live_title]', 'screenr-plus'), // [live_title]
            'max_item'      => 4, // Maximum item can add

            'fields'    => array(
                'title' => array(
                    'title' => esc_html__('Name', 'screenr-plus'),
                    'type'  =>'text',
                    'desc'  => '',
                ),
                'avatar' => array(
                    'title' => esc_html__('User image', 'screenr-plus'),
                    'type'  =>'media',
                    'desc'  => '',
                ),
                'position' => array(
                    'title' => esc_html__('Position', 'screenr-plus'),
                    'type'  =>'text',
                    'desc'  => '',
                ),
                'desc' => array(
                    'title' => esc_html__('Description', 'screenr-plus'),
                    'type'  =>'textarea',
                    'desc'  => '',
                ),
                'link' => array(
                    'title' => esc_html__('Custom Link', 'screenr-plus'),
                    'type'  =>'text',
                    'desc'  => '',
                ),
                'url' => array(
                    'title' => esc_html__('Website', 'screenr-plus'),
                    'type'  =>'text',
                    'desc'  => '',
                ),
                'facebook' => array(
                    'title' => esc_html__('Facebook', 'screenr-plus'),
                    'type'  =>'text',
                    'desc'  => '',
                ),
                'twitter' => array(
                    'title' => esc_html__('Twitter', 'screenr-plus'),
                    'type'  =>'text',
                    'desc'  => '',
                ),
                'google_plus' => array(
                    'title' => esc_html__('Google+', 'screenr-plus'),
                    'type'  =>'text',
                    'desc'  => '',
                ),
                'linkedin' => array(
                    'title' => esc_html__('linkedin', 'screenr-plus'),
                    'type'  =>'text',
                    'desc'  => '',
                ),
            ),

        )
    )
);


// Team layout
$wp_customize->add_setting( 'team_layout',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => 3,
    )
);

$wp_customize->add_control( 'team_layout',
    array(
        'label' 		=> esc_html__('Team Layout Setting', 'screenr-plus'),
        'section' 		=> 'screenr_team',
        'description'   => '',
        'type'          => 'select',
        'choices'       => array(
            '2' => esc_html__( '2 Columns', 'screenr-plus' ),
            '3' => esc_html__( '3 Columns', 'screenr-plus' ),
            '4' => esc_html__( '4 Columns', 'screenr-plus' ),
        ),
    )
);

// END team


// Gallery

// Source facebook settings
$wp_customize->add_setting( 'gallery_source_facebook',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
    )
);
$wp_customize->add_control( 'gallery_source_facebook',
    array(
        'label'     	=> esc_html__('Facebook Fan Page Album', 'screenr-plus'),
        'priority'      => 36,
        'section' 		=> 'section_gallery',
        'description'   => esc_html__('Enter Facebook fan page album ID or album URL here. Your album should publish to load data.', 'screenr-plus'),
    )
);

// Source FB API settings
$wp_customize->add_setting( 'gallery_api_facebook',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
    )
);
$wp_customize->add_control( 'gallery_api_facebook',
    array(
        'label'     	=> esc_html__('Facebook API', 'screenr-plus'),
        'section' 		=> 'section_gallery',
        'priority'      => 37,
        'description'   => sprintf( esc_html__('Paste your Facebook Token here, example: {App_ID}|{App_Secret}. Click %1$s to create an app.', 'screenr-plus'), '<a target="_blank" href="https://developers.facebook.com/apps/">'.esc_html( 'here', 'screenr-plus' ).'</a>' ),
    )
);

// Source flickr settings
$wp_customize->add_setting( 'gallery_source_flickr',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
    )
);
$wp_customize->add_control( 'gallery_source_flickr',
    array(
        'label'     	=> esc_html__('Flickr Username or ID', 'screenr-plus'),
        'section' 		=> 'section_gallery',
        'priority'      => 38,
        'description'   => esc_html__('Flickr Username or ID here, Required Flickr API.', 'screenr-plus'),
    )
);

// Source flickr API settings
$wp_customize->add_setting( 'gallery_api_flickr',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
    )
);
$wp_customize->add_control( 'gallery_api_flickr',
    array(
        'label'     	=> esc_html__('Flickr API key', 'screenr-plus'),
        'section' 		=> 'section_gallery',
        'priority'      => 39,
        'description'   => esc_html__('Paste your Flickr API key here.', 'screenr-plus'),
    )
);


// Source instagram settings
$wp_customize->add_setting( 'gallery_source_instagram',
    array(
        'sanitize_callback' => 'sanitize_text_field',
        'default'           => '',
    )
);
$wp_customize->add_control( 'gallery_source_instagram',
    array(
        'label'     	=> esc_html__('Instagram Username', 'screenr-plus'),
        'section' 		=> 'section_gallery',
        'priority'      => 40,
        'description'   => esc_html__('Enter your Instagram username here.', 'screenr-plus'),
    )
);

// End Gallery



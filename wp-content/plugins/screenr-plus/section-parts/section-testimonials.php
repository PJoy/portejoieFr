<?php

$testimonials = get_theme_mod(
    'testimonials_items',
    array(
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
                'url' => SCREENR_PLUS_URL . '/assets/images/testimonial_3.jpg',
                'id'  => ''
            ),
            'content' 		=> esc_html__( 'Sed adipiscing ornare risus. Morbi est est, blandit sit amet, sagittis vel, euismod vel, velit. Pellentesque egestas sem. Suspendisse commodo ullamcorper magna egestas sem.', 'screenr-plus' ),
        ),

    )
);

if ( is_string( $testimonials ) ) {
    $testimonials = json_decode( $testimonials );
}

if ( is_array( $testimonials ) && ! empty( $testimonials ) ) {

    $title      = get_theme_mod( 'testimonials_title', esc_html__( 'Testimonials', 'screenr-plus' ) );
    $subtitle   = get_theme_mod( 'testimonials_subtitle', esc_html__( 'Section subtitle', 'screenr-plus' ) );
    $desc       = get_theme_mod( 'testimonials_desc' );

    $classes = 'screenr-testimonials section-testimonials section-padding section-inverse section-padding-lg';
    ?>
    <?php if ( ! screenr_is_selective_refresh() ) { ?>
        <section id="<?php echo esc_attr( get_theme_mod( 'testimonials_id', 'testimonials' ) ); ?>" class="<?php echo esc_attr( apply_filters( 'screenr_section_class', $classes, 'testimonials' ) ); ?>">
    <?php } ?>

    <?php
    if ( $title || $subtitle || $desc ) {
        ?>
        <div class="container">
            <div class="section-title-area">
                <?php if ( $subtitle ) { ?><div class="section-subtitle"><?php echo esc_html( $subtitle ); ?></div><?php } ?>
                <?php if ( $title ) { ?><h2 class="section-title"><?php echo esc_html( $title ); ?></h2><?php } ?>
                <?php if ( $desc ) { ?><div class="section-desc"><?php echo do_shortcode( apply_filters( 'the_content', $desc ) ); ?></div><?php } ?>
            </div>
        </div>
        <?php
    }
    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                $rows  = array();
                $col = get_theme_mod( 'testimonials_layout', 3 );

                ?>
                <div class="card-deck-wrapper">
                    <?php
                    $row_index = 0 ;
                    foreach ( $testimonials as $testimonial ) {
                        if ( ! isset( $rows[ $row_index ] ) ) {
                            $rows[ $row_index ] = array();
                        }

                        if ( count( $rows[ $row_index ] ) >=  $col ) {
                            $row_index ++ ;
                            $rows[ $row_index ] = array();
                        }
                        $testimonial = wp_parse_args( $testimonial, array(
                            'title' 		=> '',
                            'name' 			=> '',
                            'subtitle' 		=> '',
                            'style'         => 'theme-primary',
                            'image' 		=> array(
                                'url' => '',
                                'id'  => ''
                            ),
                            'content' 		=> '',
                        ) );


                        $image = screenr_get_media_url( $testimonial['image'] );
                        if ( $image == '' ){
                            $image = SCREENR_PLUS_URL.'assets/images/testimonial_1.jpg';
                        }

                        $classes = array('card');
                        if ( 'light' != $testimonial['style'] ){
                            $classes[] = 'card-inverse';
                        }
                        $classes[] =  'card-'.$testimonial['style'];

                        $t = '';
                        $t .= '<div class="'.esc_attr( join( ' ', $classes ) ).'">';
                        $t .= '<div class="card-block">';
                        $t .= '<div class="tes_author">';

                        if ( $image != '' ) {
                            $t .= '<img src="'.esc_url( $image ).'" alt="" />';
                        }
                        if ( $image != '' ) {
                            $t .= '<cite class="tes__name">'.esc_html( $testimonial['name'] ).'<div>'.wp_kses_post( $testimonial['subtitle'] ) .'</div></cite>';
                        }

                        $t .= ' </div>';

                        $t .='<h5 class="card-title">'.esc_html( $testimonial['title'] ).'</h5>';
                        $t .='<p class="card-text">'.wp_kses_post( $testimonial['content'] ) .'</p>';

                        $t .= ' </div>';
                        $t .= ' </div>';

                        $rows[ $row_index ][ ] =  $t;

                    }

                    foreach ( $rows as $r ) {
                        echo '<div class="card-deck wow slideInUp">';
                        echo join( "\n\t", $r );
                        echo '</div>';
                    }

                    ?>
                </div>


            </div>
        </div>
    </div>
    <?php if ( ! screenr_is_selective_refresh() ) { ?>
        </section>
    <?php } ?>
<?php }
wp_reset_postdata();
?>

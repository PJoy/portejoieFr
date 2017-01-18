<?php

$args = array(
    'post_type' => 'portfolio',
    'post_status' => 'publish',
    'posts_per_page' => get_theme_mod( 'portfolios_number', 6 ),
    'order' =>  get_theme_mod( 'portfolios_order', 'DESC' ),
    'orderby' => get_theme_mod( 'portfolios_orderby', 'date' ),
    'suppress_filters' => 0,
);

$the_query = new WP_Query( $args );
global $post;
if ( $the_query->have_posts() ) {
    $layout = absint( get_theme_mod( 'portfolios_layout', 3 ) );
    if ( $layout == 0 ){
        $layout = 3;
    }
    $title      = get_theme_mod( 'portfolios_title', esc_html__( 'Featured Projects', 'screenr' ) );
    $subtitle   = get_theme_mod( 'portfolios_subtitle', esc_html__( 'Some of our works', 'screenr' ) );
    $desc       = get_theme_mod( 'portfolios_desc' );
    $classes    = 'screenr-portfolios section-portfolios section-padding section-padding-lg screenr-section';

    $num_post = count ( $the_query->get_posts() );

    $is_ajax = get_theme_mod( 'portfolios_ajax' );
    if ( ! screenr_is_selective_refresh() ) {
        ?>
        <section id="<?php echo esc_attr( get_theme_mod( 'portfolios_id', 'portfolios' ) ); ?>" class="<?php echo esc_attr( apply_filters( 'screenr_section_class', $classes, 'portfolios' ) ); ?>">
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
    <div class="portfolios-content table-portfolio portfolios-<?php echo esc_attr( $layout ); ?>-columns n-<?php echo esc_attr( $num_post ); ?>">
        <div class="portfolio-row table-row">
            <?php
            $count = 0;
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                $count ++;
                ?>
                <div data-id="<?php echo get_the_ID(); ?>" <?php post_class( 'portfolio table-col '.( $is_ajax ? 'ajax' : '' ) ); ?>>
                    <a class="portfolio-link" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php esc_attr( get_the_title() ); ?>"></a>
                    <?php if (has_post_thumbnail()) :
                        ?>
                        <div class="portfolio-thumb-wrapper">
                            <div class="portfolio-thumb" style="background-image:url('<?php the_post_thumbnail_url( 'screenr-blog-grid' ); ?>');" >
                                <div class="loading-icon">
                                    <div class="spinner"></div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="portfolio-elements">
                        <?php
                        echo get_the_term_list( get_the_ID(), 'portfolio_cat', '<div class="portfolio-cat">', ', ', '</div>' );
                        ?>
                        <?php the_title('<h2 class="portfolio-title">', '</h2>'); ?>
                    </div>
                </div>
                <?php

                if ( $count % $layout == 0 && $count < $args['posts_per_page'] ) {
                    echo '</div><!-- /.portfolio-row  -->'."\n";
                    echo '<div class="portfolio-row table-row">'."\n";
                }

            }

            ?>
        </div><!-- /.project-row  -->
    </div><!-- /.portfolios-content -->
    <?php if ( ! screenr_is_selective_refresh() ) { ?>
        </section>
    <?php } ?>
    <?php
    wp_reset_postdata();
}

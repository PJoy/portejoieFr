<?php
/**
 *Template Name: Projects page
 */

get_header();
?>
<div id="content" class="site-content portfolios-pages">
    <div id="content-inside" class="container no-sidebar">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" >
                <?php
                $is_ajax = get_theme_mod( 'portfolios_page_ajax' );
                $layout = get_theme_mod( 'portfolios_page_layout', 3 );
                global $wp_query, $paged;
                $args = array(
                    'post_type' => 'portfolio',
                    'paged' => $paged,
                    'post_status' => 'publish',
                    'posts_per_page' => get_theme_mod( 'portfolios_page_number', 12 ),
                    'order' =>  get_theme_mod( 'portfolios_page_order', 'DESC' ),
                    'orderby' => get_theme_mod( 'portfolios_page_orderby', 'ID' ),
                    'suppress_filters' => 0,
                );

                $wp_query = new WP_Query( $args );
                $num_post = count( $wp_query->get_posts() );

                ?>
                <div class="portfolios-content table-portfolio portfolios-<?php echo esc_attr( $layout ); ?>-columns n-<?php echo esc_attr( $num_post ); ?>">
                    <div class="portfolio-row table-row">
                        <?php
                        $count = 0;
                        while ( $wp_query->have_posts() ) {
                            $wp_query->the_post();
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
                                    <?php the_title('<h3 class="portfolio-title">', '</h3>'); ?>
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

                <?php

                the_posts_navigation( array(
                    'prev_text'          => __( 'Older projects', 'screenr-plus' ),
                    'next_text'          => __( 'Newer projects', 'screenr-plus' ),
                    'screen_reader_text' => __( 'Projects navigation', 'screenr-plus' ),
                ) );

                wp_reset_query();
                ?>
            </main><!-- #main -->
        </div><!-- #primary -->
    </div><!--#content-inside -->
</div><!-- #content -->

<?php get_footer();

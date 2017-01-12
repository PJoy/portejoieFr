<?php
/**
 * The template for displaying all single portfolio.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Screenr
 */

get_header(); ?>

<div id="content" class="site-content">

    <div id="content-inside" class="container no-sidebar">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" role="main">

                <div class="row">
                    <div class="col-md-12">
                    <?php while ( have_posts() ) : the_post(); ?>

                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <div class="entry-content">
                                <?php
                                the_content();

                                wp_link_pages( array(
                                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'screenr-plus' ),
                                    'after'  => '</div>',
                                ) );
                                ?>
                            </div><!-- .entry-content -->

                        </article><!-- #post-## -->
                    <?php endwhile; // End of the loop. ?>
                    </div>
                </div>

            </main><!-- #main -->
        </div><!-- #primary -->

    </div><!--#content-inside -->
    <?php if ( get_theme_mod( 'show_portfolio_controls', 1 ) ) { ?>
    <div class="portfolio-controls">
        <div class="container">
            <div class="portfolio-nav">
                <?php
                previous_post_link( '<div class="previous">%link</div>', '<span class="icon"><span></span></span>'.esc_html__( 'Previous Project', 'screenr-plus' ).'</span>' );

                $link =  get_theme_mod( 'portfolios_page_link' );
                if ( $link ) {
                    ?>
                    <a class="back-to-list" title="<?php echo esc_attr__( 'Back to projects page', 'screenr-plus' ); ?>" href="<?php echo esc_url( $link ); ?>">
                        <span class="btl">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </a>
                    <?php
                }
                next_post_link( '<div class="next">%link</div>', '<span>'.esc_html__( 'Next Project', 'screenr-plus' ).'</span> <span class="icon"><span></span></span>' );
                ?>
            </div>
        </div>
    </div>
    <?php } ?>

</div><!-- #content -->

<?php get_footer(); ?>

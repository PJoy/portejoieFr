<?php
$id       = get_theme_mod( 'pricing_id', esc_html__('pricing', 'screenr-plus') );
$title    = get_theme_mod( 'pricing_title', esc_html__('Pricing Table', 'screenr-plus' ));
$subtitle = get_theme_mod( 'pricing_subtitle', esc_html__('Responsive pricing section', 'screenr-plus' ));
$desc     = get_theme_mod( 'pricing_desc' )
?>
<?php if ( ! screenr_is_selective_refresh() ){ ?>
<section <?php if ( $id ) { ?>id="<?php echo esc_attr( $id ); ?>" <?php } ?> class="<?php echo esc_attr( apply_filters( 'screenr_section_class', 'section-pricing section-padding-lg screenr-section', 'pricing' ) ); ?>">
    <?php } ?>
    <?php do_action( 'screenr_section_before_inner', 'pricing' ); ?>
    <div class="container">
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
        <div class="pricing-table row">
            <?php

            $plans = get_theme_mod( 'pricing_plans' );

            if ( is_string( $plans ) ) {
                $plans = json_decode( $plans , true );
            }

            if ( empty( $plans ) || ! is_array( $plans ) ) {
                $plans = array(
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

                );
            }

            $class = 'col-md-6 col-lg-4';
            $n = count( $plans );
            if ( $n == 4  ){
                $class = 'col-md-6 col-lg-3';
            } else if ( $n == 3  ){
                $class = 'col-md-6 col-lg-4';
            } else if ( $n == 2  ){
                $class = 'col-md-6 col-lg-6';
            } else if ( $n == 1 ){
                $class = 'col-md-12 col-lg-12';
            }

            ?>
            <div class="pricing">

                <?php
                foreach ( $plans as $plan ){

                    $plan = wp_parse_args( $plan,array(
                        'title' => '',
                        'code'  => '',
                        'price'  => '',
                        'subtitle' => '',
                        'content' => '',
                        'label' => esc_attr__( 'Choose Plan', 'screenr-plus' ),
                        'link' => '#',
                        'button' => 'btn-theme-primary'
                    ) );

                    ?>
                    <div class="<?php echo esc_attr( $class ); ?> wow slideInUp">
                        <div class="pricing__item">
                            <h3 class="pricing__title"><?php echo esc_html( $plan['title'] ); ?></h3>
                            <div class="pricing__price"><span class="pricing__currency"><?php echo esc_html( $plan['code'] ); ?></span><?php echo esc_html( $plan['price'] ); ?></div>
                            <div class="pricing__sentense"><?php echo esc_html( $plan['subtitle'] ); ?></div>
                            <ul class="pricing__feature-list">
                                <?php
                                $list =  explode("\n", $plan['content'] );
                                $list = array_filter( $list );
                                foreach ( $list as $l ) {
                                    $l = trim( $l );
                                    if ( $l ){
                                        echo '<li>'.esc_html( $l ).'</li>';
                                    }
                                }
                                ?>
                            </ul>
                            <div class="pricing__button">
                                <a href="<?php echo esc_url( $plan['link'] ); ?>" class="btn <?php echo esc_attr( $plan['button'] ); ?> btn-lg btn-block"><?php echo esc_html( $plan['label'] ); ?></a>
                            </div>
                        </div>
                    </div>
                <?php } ?>


            </div>
        </div>

    </div>
    <?php do_action( 'screenr_section_after_inner', 'pricing' ); ?>
    <?php if ( ! screenr_is_selective_refresh() ){ ?>
</section>
<?php } ?>

<?php
$id       = get_theme_mod( 'cta_id', 'section-cta' );
$title    = get_theme_mod( 'cta_title', __('Use these ribbons to display calls to action mid-page.', 'screenr-plus' ));
$label    = get_theme_mod( 'cta_btn_label', __('Button text', 'screenr-plus' ));
$link     = get_theme_mod( 'cta_btn_link', '#' );
?>
<?php if ( ! screenr_is_selective_refresh() ){ ?>
<section <?php if ( $id ) { ?>id="<?php echo esc_attr( $id ); ?>" <?php } ?> class="<?php echo esc_attr( apply_filters( 'screenr_section_class', 'section-cta section-padding section-inverse screenr-section', 'cta' ) ); ?>">
    <?php } ?>
    <?php do_action( 'screenr_section_before_inner', 'cta' ); ?>

    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-9 cta-heading">
                <h2><?php echo esc_html( $title ); ?></h2>
            </div>
            <div class="col-md-12 col-lg-3 cta-button-area">
                <a href="<?php echo esc_url( $link ); ?>" class="btn btn-lg btn-theme-primary-outline"><?php echo esc_html( $label ); ?></a>
            </div>
        </div>
    </div>

    <?php do_action( 'screenr_section_after_inner', 'cta' ); ?>
    <?php if ( ! screenr_is_selective_refresh() ){ ?>
</section>
<?php } ?>

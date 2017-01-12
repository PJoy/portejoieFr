<?php
$members = get_theme_mod( 'team_members', screenr_plus_get_default_team_members() );
if ( ! empty( $members ) ) {

    $id       = get_theme_mod( 'team_id', esc_html__('team', 'screenr') );
    $title    = get_theme_mod( 'team_title', esc_html__('Our Team', 'screenr' ));
    $subtitle = get_theme_mod( 'team_subtitle', esc_html__('Section subtitle', 'screenr' ));
    $desc     = get_theme_mod( 'team_desc' );
    $layout   = intval( get_theme_mod( 'team_layout', 3 ) );
    if ( $layout <= 0 ){
        $layout = 3;
    }
    $class_num = round( 12 / $layout );
    ?>
        <?php if ( ! screenr_is_selective_refresh() ){ ?>
        <section id="<?php echo esc_attr( $id ); ?>" <?php do_action('screenr_section_atts', 'team'); ?>
            class="<?php echo esc_attr(apply_filters('screenr_section_class', 'section-team section-padding-lg section-meta screenr-section', 'team')); ?>">
        <?php } ?>
        <?php do_action('screenr_section_before_inner', 'team'); ?>
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
            </div>

            <div class="container">
                <div class="row">
                    <div class="team-member-wrapper team-layout-<?php echo esc_attr( $layout ); ?>">
                        <?php
                        if ( ! empty( $members ) ) {
                            $n = 0;

                            foreach ( $members as $member ) {
                                $member = wp_parse_args( $member, array(
                                    'avatar'  =>array(),
                                    'title'  => '',
                                    'position'  => '',
                                    'desc'  => '',
                                    'link'  => '',
                                ));

                                $link = isset( $member['link'] ) ?  $member['link'] : '';

                                $media = wp_parse_args($member['avatar'], array('url' => '', 'id' => ''));
                                $image = '';
                                if ($media['id'] != '') {
                                    $image_attributes = wp_get_attachment_image_src( $media['id'], 'screenr-thumbnail-team' );
                                    if ( $image_attributes ) {
                                        $image = $image_attributes[0];
                                    }
                                }
                                if ($image == '' && $media['url'] != '') {
                                    $image = $media['url'];
                                }

                                $n ++ ;
                                ?>
                                <div class="member-item col-sm-12 col-md-6 col-lg-<?php echo esc_attr( $class_num ); ?>">
                                    <div class="team-member">
                                        <div class="team-member-img">
                                            <img src="<?php echo esc_url( $image ); ?>" alt="">
                                            <?php do_action( 'screenr_section_team_member_media', $member ); ?>
                                        </div>
                                        <h4 class="team-member-name">
                                            <?php if ( $link ) { ?><a href="<?php echo esc_url( $link ); ?>"><?php } ?>
                                                <?php echo esc_html( $member['title'] ); ?>
                                            <?php if ( $link ) { ?></a><?php } ?>
                                        </h4>
                                        <div class="team-member-position"><?php echo esc_html( $member['position']  ); ?></div>
                                        <div class="team-member-description">
                                            <p><?php echo esc_html( $member['desc'] ); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php


                            } // end foreach
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php do_action('screenr_section_after_inner', 'team'); ?>
        <?php if ( ! screenr_is_selective_refresh() ){ ?>
        </section>
        <?php } ?>
    <?php
}

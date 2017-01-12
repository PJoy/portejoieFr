<?php

function screenr_is_video_file( $file ){
    $ext = strtolower( end( explode( '', $file ) ) );

    if ( in_array( $ext, array( 'mp4', 'ogv', 'webm' ) ) ) {

    }
}


function screenr_plus_team_member_socials( $member ){
    $member = wp_parse_args(
        $member,
        array(
            'url' => '',
            'facebook' => '',
            'twitter' => '',
            'google_plus' => '',
            'linkedin' => '',
        )
    );
    ?>

    <div class="team-social-wrapper">
        <div class="team-member-social">

            <?php if ( $member['url'] != '' ) { ?>
                <a href="<?php echo esc_url( $member['url'] ); ?>"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-globe fa-stack-1x"></i></span></a>
            <?php } ?>
            <?php if ( $member['twitter'] != '' ) { ?>
                <a href="<?php echo esc_url( $member['twitter'] ); ?>"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-twitter fa-stack-1x"></i></span></a>
            <?php } ?>
            <?php if (  $member['facebook'] != '' ) { ?>
                <a href="<?php echo esc_url( $member['facebook'] ); ?>"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-facebook fa-stack-1x"></i></span></a>
            <?php } ?>
            <?php if ( $member['google_plus'] != '' ) { ?>
                <a href="<?php echo esc_url($member['google_plus']); ?>"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-google-plus fa-stack-1x"></i></span></a>
            <?php } ?>
            <?php if ( $member['linkedin'] != '' ) { ?>
                <a href="<?php echo esc_url($member['linkedin']); ?>"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-linkedin fa-stack-1x"></i></span></a>
            <?php } ?>
            <!--
            <a href="#"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-globe fa-stack-1x"></i></span></a>
            <a href="#"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-twitter fa-stack-1x"></i></span></a>
            <a href="#"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-facebook fa-stack-1x"></i></span></a>
            <a href="#"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-google-plus fa-stack-1x"></i></span></a>
            <a href="#"><span class="fa-stack fa-lg"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-linkedin fa-stack-1x"></i></span></a>
            -->
        </div>
    </div>

    <?php
}

add_action( 'screenr_section_team_member_media', 'screenr_plus_team_member_socials' );

/**
 * Add docs links
 */
function screenr_plus_dashboard_theme_links(){
    ?>
    <p>
        <a href="http://docs.famethemes.com/category/74-screenr-plus" target="_blank" class="button button-primary"><?php esc_html_e('Screenr Plus Documentation', 'screenr-plus'); ?></a>
    </p>
    <?php
}
add_action( 'screenr_dashboard_theme_links', 'screenr_plus_dashboard_theme_links' );

/**
 * Change theme footer info
 */
function screenr_plus_footer_credits(){

    $c = get_theme_mod( 'screenr_footer_copyright_text' );
    if ( ! $c ) {
        $c = sprintf( esc_html__('Copyright %1$s %2$s %3$s. All Rights Reserved.', 'screenr'), '&copy;', date_i18n('Y'), get_bloginfo() );
    }
    $h = get_theme_mod( 'screenr_hide_author_link', 0 );
    if ( $c || !$h ) {
        ?>
        <div id="footer-site-info" class="site-info">
            <div class="container">
                <div class="site-copyright">
                    <?php echo wp_kses_post( $c ); ?>
                    <?php ; ?>
                </div><!-- .site-copyright -->
                <div class="theme-info <?php echo ( $h ) ? 'screen-reader-text' : ''; ?>">
                    <?php printf( esc_html__('%1$s by %2$s', 'screenr'), '<a href="https://www.famethemes.com/themes/screenr">Screenr parallax theme</a>', 'FameThemes'); ?>
                </div>
            </div>
        </div><!-- .site-info -->
        <?php
    }
    ?>
    <?php
}

/**
 * Chang theme footer info
 *
 * @todo Remove default theme hook
 * @todo Add new plugin hook
 */
function screenr_plus_change_theme_footer_info(){
    remove_action( 'screenr_footer', 'screenr_footer_credits' );
    add_action( 'screenr_footer', 'screenr_plus_footer_credits' );
}
//add_action( 'wp_loaded', 'screenr_plus_change_theme_footer_info'  );


function screenr_plus_get_default_team_members(){
    $members = array(
        array(
            'title' => esc_html__( 'Alexander Rios', 'screenr-plus' ),
            'position' => esc_html__( 'Founder & CEO', 'screenr-plus' ),
            'desc' => esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit aenean commodo ligula.', 'screenr-plus' ),
            'avatar' => array(
                'url' => SCREENR_PLUS_URL.'assets/images/team1.jpg',
                'id' => '',
            )
        ),
        array(
            'title' => esc_html__( 'Sean Weaver', 'screenr-plus' ),
            'position' => esc_html__( 'Senior Designer', 'screenr-plus' ),
            'desc' => esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit aenean commodo ligula.', 'screenr-plus' ),
            'avatar' => array(
                'url' => SCREENR_PLUS_URL.'assets/images/team2.jpg',
                'id' => '',
            )
        ),
        array(
            'title' => esc_html__( 'George Wells', 'screenr-plus' ),
            'position' => esc_html__( 'User Experience', 'screenr-plus' ),
            'desc' => esc_html__( 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit aenean commodo ligula.', 'screenr-plus' ),
            'avatar' => array(
                'url' => SCREENR_PLUS_URL.'assets/images/team3.jpg',
                'id' => '',
            )
        )
    );
    return apply_filters( 'screenr_plus_get_default_team_members', $members );
}

/**
 * Add more primary color for plugin
 *
 * @param $css
 * @return string
 */
function screenr_plus_custom_css( $css ){
    $primary = get_theme_mod( 'primary_color' );
    if ( $primary ) {
        $css .= '
        .portfolio-content .portfolio-close:hover::before, .portfolio-content .portfolio-close:hover::after,
        .portfolio-controls .previous:hover .icon:before, .portfolio-controls .previous:hover .icon:after,
        .portfolio-controls .previous:hover .icon span,
        .portfolio-controls .next:hover .icon:before, .portfolio-controls .next:hover .icon:after,
        .portfolio-controls .next:hover .icon span,
        .portfolio-controls .back-to-list:hover .btl span {
            background-color: #'.esc_attr( $primary ).';
        }
        .portfolio-controls a:hover,
        .team-member .team-member-img .team-social-wrapper .team-member-social a:hover i.fa-stack-1x {
            color: #'.esc_attr( $primary ).';
        }
        .card-theme-primary {
            background-color: #'.esc_attr( $primary ).';
            border-color: #'.esc_attr( $primary ).';
        }
        .pricing__item:hover {
            border-top-color: #'.esc_attr( $primary ).';
        }
    ';
    }
    return $css;
}

add_filter( 'screenr_custom_style', 'screenr_plus_custom_css' );




// based on https://gist.github.com/cosmocatalano/4544576
if ( ! function_exists( 'screenr_plus_scrape_instagram' ) ) {
    function screenr_plus_scrape_instagram( $username )
    {
        $username = strtolower($username);
        $username = str_replace('@', '', $username);

        $remote = wp_remote_get('http://instagram.com/' . trim($username));
        if ( is_wp_error( $remote ) ) {
            return false;
        }
        if ( 200 != wp_remote_retrieve_response_code($remote) ) {
            return false;
        }

        $shards = explode('window._sharedData = ', $remote['body']);
        $insta_json = explode(';</script>', $shards[1]);
        $insta_array = json_decode($insta_json[0], TRUE);
        if ( ! $insta_array )
            return  false;
        if (isset($insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'])) {
            $images = $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
        } else {
            return false;
        }
        if ( ! is_array( $images ) ) {
            return false;
        }

        $instagram = array();
        foreach ($images as $image) {
            $image['thumbnail_src'] = preg_replace('/^https?\:/i', '', $image['thumbnail_src']);
            $image['display_src'] = preg_replace('/^https?\:/i', '', $image['display_src']);
            // handle both types of CDN url
            if ((strpos($image['thumbnail_src'], 's640x640') !== false)) {
                $image['thumbnail'] = str_replace('s640x640', 's160x160', $image['thumbnail_src']);
                $image['small'] = str_replace('s640x640', 's320x320', $image['thumbnail_src']);
            } else {
                $urlparts = wp_parse_url($image['thumbnail_src']);
                $pathparts = explode('/', $urlparts['path']);
                array_splice($pathparts, 3, 0, array('s160x160'));
                $image['thumbnail'] = '//' . $urlparts['host'] . implode('/', $pathparts);
                $pathparts[3] = 's320x320';
                $image['small'] = '//' . $urlparts['host'] . implode('/', $pathparts);
            }
            $image['large'] = $image['thumbnail_src'];
            if ($image['is_video'] == true) {
                $type = 'video';
            } else {
                $type = 'image';
            }
            $caption = esc_html__('Instagram Image', 'onepress');
            if (!empty($image['caption'])) {
                $caption = $image['caption'];
            }
            $instagram[] = array(
                'title' => $caption,
                'link' => trailingslashit('//instagram.com/p/' . $image['code']),
                'time' => $image['date'],
                'comments' => $image['comments']['count'],
                'likes' => $image['likes']['count'],
                //'thumbnail' => $image['thumbnail'],
                'thumbnail' => $image['large'],
                'small' => $image['small'],
                //'full' => $image['large'],
                'full' => $image['display_src'],
                'original' => $image['display_src'],
                'type' => $type
            );
        }
        return $instagram;
    }
}


if ( ! function_exists( 'screenr_plus_get_section_gallery_data' ) ) {
    /**
     * Get Gallery data
     *
     * @since 1.2.6
     *
     * @return array
     */
    function screenr_plus_get_section_gallery_data()
    {

        $source = get_theme_mod( 'gallery_source', 'page' );
        $data =  apply_filters( 'screenr_plus_get_section_gallery_data', false );
        if ( $data ) {
            return $data;
        }
        $data = array();
        $number_item = 100;

        $transient_expired = 6 * HOUR_IN_SECONDS;

        switch ( $source ) {
            case 'instagram':

                //Example:  https://www.instagram.com/taylorswift/media/
                $user_id = wp_strip_all_tags( get_theme_mod( 'gallery_source_instagram' ) );
                if ( ! $user_id ) {
                    return $data;
                }
                // Check cache
                //delete_transient( 'onepress_gallery_'.$source.'_'.$user_id );
                $data = get_transient( 'screenr_gallery_'.$source.'_'.$user_id );
                if ( false !== $data && is_array( $data ) ) {
                    return $data;
                }
                $data = screenr_plus_scrape_instagram( $user_id );

                if ( ! empty( $data ) ) {
                    set_transient('screenr_gallery_' . $source . '_' . $user_id, $data, $transient_expired);
                } else {
                    delete_transient( 'screenr_gallery_'.$source.'_'.$user_id );
                }

                break;
            case 'flickr':

                $api_key = get_theme_mod( 'gallery_api_flickr', 'a68c0befe246035b74a8f67943da7edc' );
                if ( ! $api_key ) {
                    return $data;
                }
                $user_id = wp_strip_all_tags( get_theme_mod( 'gallery_source_flickr' ) );
                if ( ! $user_id ) {
                    return $data;
                }

                // Check cache
                $data = get_transient( 'screenr_gallery_'.$source.'_'.$user_id );
                if ( false !== $data && is_array( $data ) ) {
                    return $data;
                }

                $flickr_api_url = 'https://api.flickr.com/services/rest/';
                // @see https://www.flickr.com/services/api/explore/flickr.people.getPhotos
                $url = add_query_arg( array(
                    'method' => 'flickr.people.getPhotos',
                    'api_key' => $api_key,
                    'user_id' => $user_id,
                    'per_page' => $number_item,
                    'format' => 'json',
                    'nojsoncallback' => '1',
                ), $flickr_api_url );

                $res = wp_remote_get( $url );
                if ( wp_remote_retrieve_response_code( $res ) == 200 ) {
                    $res_data = wp_remote_retrieve_body( $res );
                    $res_data = json_decode( $res_data, true );
                    if ( $res_data['stat'] == 'ok' && $res_data['photos']['photo'] ) {

                        foreach ( $res_data['photos']['photo'] as $k => $photo ) {
                            $image_get_url = add_query_arg( array(
                                'method' => 'flickr.photos.getSizes',
                                'api_key' => $api_key,
                                'photo_id' => $photo['id'],
                                'format' => 'json',
                                'nojsoncallback' => '1',
                            ), $flickr_api_url );

                            $img_res = wp_remote_get( $image_get_url );
                            if ( wp_remote_retrieve_response_code( $img_res ) == 200 ) {
                                $img_res = wp_remote_retrieve_body($img_res);
                                $img_res = json_decode($img_res, true);
                                if( isset( $img_res['sizes'] ) && $img_res['stat'] == 'ok' ) {

                                    $img_full = false;
                                    $tw = 0;
                                    $images = array();
                                    foreach ( $img_res['sizes']['size'] as $img ){
                                        if ( $tw < $img['width'] ) {
                                            $tw = $img['width'];
                                            $img_full = $img['source'];
                                        }
                                        $images[ $img['label'] ] = $img['source'];
                                    }

                                    $data[$photo['id']] = array(
                                        'id' => $photo['id'],
                                        'thumbnail' => $img_full,
                                        'full' => $img_full,
                                        'sizes' => $images,
                                        'title' => $photo['title'],
                                        'content' => ''
                                    );
                                }
                            }
                        }
                    }
                }

                if ( ! empty( $data ) ) {
                    set_transient( 'screenr_gallery_'.$source.'_'.$user_id, $data, $transient_expired );
                } else {
                    delete_transient( 'screenr_gallery_'.$source.'_'.$user_id );
                }


                break;
            case 'facebook':
                $album_id = false;
                $album_url = get_theme_mod( 'gallery_source_facebook', '' );
                if ( is_numeric( $album_url ) ) {
                    $album_id = absint( $album_url );
                } else {
                    preg_match( '/a\.(.*?)\.(.*?)/', $album_url, $arr );
                    if ( $arr ) {
                        $album_id = $arr[1];
                    }
                }

                if ( ! $album_id ) {
                    $tpl = explode( "album_id",  $album_url );
                    $album_id = end( $tpl );
                    $album_id = str_replace( '=', '', $album_id );
                }

                if ( ! $album_id ) {
                    return false;
                }
                $token = get_theme_mod( 'gallery_api_facebook', '1813325532276774|c0e7681c4a5727a6ca5d31020d0b44b0' );
                if ( ! $token ) {
                    return false;
                }

                // Check cache
                $data = get_transient( 'screenr_gallery_'.$source.'_'.$album_id );
                if ( false !== $data && is_array( $data ) ) {
                    return $data;
                }

                $url = 'https://graph.facebook.com/v2.7/'.$album_id;
                $url = add_query_arg( array(
                    'fields' => 'photos.limit('.$number_item.'){images,link,name,picture,width}',
                    'access_token' => $token ,
                ), $url );

                $res = wp_remote_get( $url );
                if ( wp_remote_retrieve_response_code( $res ) == 200 ) {
                    $res_data = wp_remote_retrieve_body( $res );
                    $res_data = json_decode( $res_data, true );

                    if ( isset( $res_data['photos'] ) && isset( $res_data['photos']['data'] ) ) {
                        foreach ( $res_data['photos']['data'] as $k => $photo ) {

                            $img_full = false;
                            $tw = 0;
                            foreach ( $photo['images'] as $img ){
                                if ( $tw < $img['width'] ) {
                                    $tw = $img['width'];
                                    $img_full = $img['source'];
                                }
                            }
                            $data[ $photo['id'] ] = array(
                                'id'        => $photo['id'],
                                'thumbnail' => $img_full,
                                'full'      => $img_full,
                                'title'     => isset( $photo['name'] ) ? $photo['name'] : '',
                                'content'  => ''
                            );
                        }

                    }
                }

                if ( ! empty( $data ) ) {
                    set_transient('screenr_gallery_' . $source . '_' . $album_id, $data, $transient_expired);
                } else {
                    delete_transient( 'screenr_gallery_'.$source.'_'.$album_id );
                }

                break;
            case "page":
                $page_id = get_theme_mod( 'gallery_source_page' );
                $images = '';
                if ( $page_id ) {
                    $gallery = get_post_gallery( $page_id , false );
                    if ( $gallery ) {
                        $images = $gallery['ids'];
                    }
                }

                $image_thumb_size = apply_filters( 'screenr_gallery_page_img_size', 'screenr-service-small' );

                if ( ! empty( $images ) ) {
                    $images = explode( ',', $images );
                    foreach ( $images as $post_id ) {
                        $post = get_post( $post_id );
                        if ( $post ) {
                            $img_thumb = wp_get_attachment_image_src($post_id, $image_thumb_size );
                            if ($img_thumb) {
                                $img_thumb = $img_thumb[0];
                            }

                            $img_full = wp_get_attachment_image_src($post_id, 'full');
                            if ($img_full) {
                                $img_full = $img_full[0];
                            }

                            if ( $img_thumb && $img_full ) {
                                $data[ $post_id ] = array(
                                    'id'        => $post_id,
                                    'thumbnail' => $img_thumb,
                                    'full'      => $img_full,
                                    'title'     => $post->post_title,
                                    'content'   => $post->post_content,
                                );
                            }
                        }
                    }
                }

                break;
        }

        return $data;

    }
}

add_filter( 'screenr_get_section_gallery_data', 'screenr_plus_get_section_gallery_data' );


(function($, window, undefined) {

    $.fn.objectFitPolyfill = function(options) {

        // If the browser does support object-fit, we don't need to continue
        if ('objectFit' in document.documentElement.style !== false) {
           return;
        }

        // Setup options
        var settings = $.extend({
            "fit": "cover",
            "fixContainer": false,
        }, options);

        return this.each(function() {

            var $image = $(this);
            var $container = $image.parent();

            var coverAndPosition = function() {
                // If necessary, make the parent container work with absolutely positioned elements
                if (settings.fixContainer) {
                    $container.css({
                        "position": "relative",
                        "overflow": "hidden",
                    });
                }

                // Mathematically figure out which side needs covering, and add CSS positioning & centering
                $image.css({
                    "position": "absolute",
                    "height": $container.outerHeight(),
                    "width": "auto"
                });

                if (
                    settings.fit === "cover"   && $image.width() < $container.outerWidth() ||
                    settings.fit === "contain" && $image.width() > $container.outerWidth()
                ) {
                    $image.css({
                        "top": "50%",
                        "left": 0,
                        "height": "auto",
                        "width": $container.outerWidth(),
                        "marginLeft": 0,
                    }).css("marginTop", $image.height() / -2);
                } else {
                    $image.css({
                        "top": 0,
                        "left": "50%",
                        "marginTop": 0,
                    }).css("marginLeft", $image.width() / -2);
                }
            };

            // Init - wait for the image to be done loading first, otherwise dimensions will return 0
            $image.on("load", function(){
                coverAndPosition();
            });
            // IE will sometimes get cache-happy and not register onload.
            coverAndPosition();

            // Recalculate widths & heights on window resize
            $(window).resize(function() {
                coverAndPosition();
            });

        });

    };

})(jQuery, window);


jQuery( document ).ready( function( $ ){

    var isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };
    var is_mobile =  isMobile.any();
    if ( is_mobile ) {
        $( '.swiper-slider video').remove();
    }

    /**
     * Section video
     */

    $( '.video-section').each( function(){
        var $s = $( this);
        var fallback = $s.attr( 'data-fallback' ) || 'true';
        var bg = $s.attr('data-bg') || '';
        if ( is_mobile && bg !== '' && fallback !== 'false' ) {
            if ( bg ) {
                $( '.fill-width', $s).remove();
                $s.addClass( 'video-bg' );
                $s.css( 'backgroundImage', "url('"+bg+"')" );
            }
        } else {
            var video_mp4   = $s.attr('data-mp4')  || '',
                video_webm  = $s.attr('data-webm') || '',
                video_ogv   = $s.attr('data-ogv')  || '';

            if ( video_mp4 || video_webm || video_ogv ) {
                var $v = $( '<video autoplay loop muted class="fill-width">' );
                $v.html( Screenr_Plus.browser_warning );
                if ( video_mp4 ) {
                    $v.append( $( ' <source type="video/mp4"/>' ).attr( 'src', video_mp4 ) );
                }
                if ( video_webm ) {
                    $v.append( $( ' <source type="video/webm"/>' ).attr( 'src', video_webm ) );
                }
                if ( video_ogv ) {
                    $v.append( $( ' <source type="video/ogv"/>' ).attr( 'src', video_ogv ) );
                }
                $s.prepend( $v );
                $v.objectFitPolyfill();
            }
        }

    } );




    // Project ajax
    if ( typeof window.portfolios === "undefined" ) {
        window.portfolios = {};
    }

    var setup_ajax_portfolio = function (  ){

        var width = $( '.portfolios-content' ).width();
        var col_width = $( '.portfolios-content .portfolio-row > .portfolio').eq( 0).outerWidth() ;
        $('.portfolio-ajax-c .portfolio-content' ).css( 'margin-right', '' );
        $( '.portfolio-ajax-c' ).each( function(){
            var item_parent =  $( this );
            item_parent.fitVids();
            $('.portfolio-content', item_parent ).css( 'margin-right', - ( width - col_width ) + 'px');
        } );
    };

    $( window ).on( 'resize', function(){
        setTimeout( setup_ajax_portfolio , 50 );
    } );

    $( 'body' ).on( 'click', '.portfolio-close', function( e ){
        e.preventDefault();
        var parent = $( this ).closest( '.portfolio-row' );
        var pre_p = parent.prev();

        $( '.portfolio.ajax' ).removeClass( 'active' ).find( '.arrow' ).remove();
        $( '.portfolio-ajax-c' ).each( function (){
            var next_parent = $( this );
            $( '.portfolio-content', next_parent ) .slideUp( 400, function(){
                next_parent.remove();
            });
        } );

        if ( pre_p.length > 0 ) {
            $('html, body').animate({
                scrollTop: pre_p.offset().top - $('#masthead').height() - $('#wpadminbar').height()
            }, 500, function(){
                $( window).trigger( 'resize' );
            } );
        }

    } );


    $( 'body' ).on( 'click', '.portfolio.ajax', function( e ){
        e.preventDefault();
        var item = $( this );
        var id = item.attr( 'data-id' ) || 0;
        var item_parent = item.closest('.portfolio-row');
        $( '.portfolio-ajax-c' ).each( function (){
            var next_parent = $( this );
            $( '.portfolio-content', next_parent ) .slideUp( 200, function(){
                next_parent.remove();
            });
        } );
        $( '.portfolio.ajax' ).removeClass( 'active' ).find( '.arrow' ).remove();
        item.addClass( 'loading' );
        if ( ! window.portfolios[ id ] ) {
            var data = {
                'post_id': id,
                'screenr_ajax_action': 'load_portfolio_details',
                'action': 'screenr_plus_ajax'
            };

            $.get( Screenr_Plus.ajax_url, data, function (response) {
                if ( response.success ) {
                    window.portfolios[id] = response.data;
                    if (item_parent.length > 0 ) {
                        var c = $( window.portfolios[id] );
                        c.find( '.portfolio-content' ).hide();
                        c.insertAfter(item_parent);
                        c.find( '.portfolio-content' ).slideDown( 400 );
                        item.removeClass('loading');
                        item.addClass( 'active' );
                        setup_ajax_portfolio();
                        $( 'body' ).trigger( 'portfolio_details_loaded' );
                        $( window).trigger( 'resize' );

                        $('html, body').animate({
                            scrollTop: c.offset().top - $( '#masthead').height() - $( '#wpadminbar').height()
                        }, 500, function(){
                            $( window).trigger( 'resize' );
                        } );
                    }
                }
            });
        } else {
            if ( item_parent.length > 0 ) {
                var c = $( window.portfolios[id] );
                c.find( '.portfolio-content' ).hide();
                c.insertAfter(item_parent);
                c.find( '.portfolio-content' ).slideDown( 400 );
                item.removeClass('loading');
                item.addClass( 'active' );
                setup_ajax_portfolio();
                $( 'body' ).trigger( 'portfolio_details_loaded' );
                $( window).trigger( 'resize' );

                $('html, body').animate({
                    scrollTop: c.offset().top - $( '#masthead').height() - $( '#wpadminbar').height()
                }, 500, function(){
                    $( window).trigger( 'resize' );
                }  );
            }
        }

    } );




} );

// WP EDITOR plugin -----------------------------

(function ( $ ) {

    window._wpEditor = {
        init: function( id , content, settings ){
            var _id = '__wp_mce_editor__';
            var _tpl =  $( '#_wp-mce-editor-tpl').html();
            if (  typeof content === "undefined"  ){
                content = '';
            }

            if (  typeof window.tinyMCEPreInit.mceInit[ _id ]  !== "undefined" ) {

                var tmceInit = _.clone( window.tinyMCEPreInit.mceInit[_id] );
                var qtInit = _.clone( window.tinyMCEPreInit.qtInit[_id] );

                tmceInit = $.extend( tmceInit , settings.tinymce );
                qtInit   = $.extend( qtInit , settings.qtag );

                var tpl = _tpl.replace( new RegExp(_id,"g"), id );
                var template =  $( tpl );
                template.find( 'textarea').removeAttr( 'rows').removeAttr( 'cols' );
                $( "#"+id ).replaceWith( template );
                // set content
                $( '#'+id ).val( content );

                $wrap = tinymce.$( '#wp-' + id + '-wrap' );

                tmceInit.body_class = tmceInit.body_class.replace(new RegExp(_id,"g"), id );
                tmceInit.selector   = tmceInit.selector.replace(new RegExp(_id,"g"), id );
                tmceInit.cache_suffix   = '';

                $wrap.removeClass( 'html-active').addClass( 'tmce-active' );

                tmceInit.init_instance_callback = function( editor ){

                    if (  typeof settings === 'object' ) {
                        if ( typeof settings.mod === 'string' && settings.mod === 'html' ){
                            //console.log( settings.mod  );
                            switchEditors.go( id, settings.mod );
                        }
                        // editor.theme.resizeTo('100%', 500);
                        if( typeof settings.init_instance_callback === "function" ) {
                            settings.init_instance_callback( editor );
                        }

                        if (settings.sync_id !== '') {
                            if (typeof settings.sync_id === 'string') {
                                editor.on('keyup change', function (e) {
                                    var html = editor.getContent( { format: 'raw' } );
                                    html = _wpEditor.removep( html );
                                    $('#' + settings.sync_id).val( html ).trigger('change');
                                });
                            } else {
                                editor.on('keyup change', function (e) {
                                    var html = editor.getContent( { format: 'raw' } );
                                    html = _wpEditor.removep( html );
                                    settings.sync_id.val( html ).trigger('change');
                                });
                            }

                            $( 'textarea#'+id ).on( 'keyup change', function(){
                                var v =  $( this).val();
                                if ( typeof settings.sync_id === 'string' ) {
                                    $('#' + settings.sync_id).val( v ).trigger('change');
                                } else {
                                    settings.sync_id.val( v ).trigger('change');
                                }
                            } );


                        }
                    }
                };


                //console.log( tmceInit );
                tmceInit.plugins = tmceInit.plugins.replace('fullscreen,', '');
                tinyMCEPreInit.mceInit[ id ] = tmceInit;
                //console.log( tmceInit );

                qtInit.id = id;
                tinyMCEPreInit.qtInit[ id ] = qtInit;

                if ( $wrap.hasClass( 'tmce-active' ) || ! tinyMCEPreInit.qtInit.hasOwnProperty( id )  ) {
                    tinymce.init( tmceInit );
                    if ( ! window.wpActiveEditor ) {
                        window.wpActiveEditor = id;
                    }
                }

                if ( typeof quicktags !== 'undefined' ) {

                    /**
                     * Reset quicktags
                     * This is crazy condition
                     * Maybe this is a bug ?
                     * see wp-includes/js/quicktags.js line 252
                     */
                    if( QTags.instances['0'] ) {
                        QTags.instances['0'] =  false;
                    }
                    quicktags( qtInit );
                    if ( ! window.wpActiveEditor ) {
                        window.wpActiveEditor = id;
                    }

                }

            }
        },

        /**
         * Replace paragraphs with double line breaks
         * @see wp-admin/js/editor.js
         */
        removep: function ( html ) {
            return window.switchEditors._wp_Nop( html );
        },

        sync: function(){
            //
        },

        remove: function( id ){
            var content = '';
            var editor = false;
            if ( editor = tinymce.get(id) ) {
                content = editor.getContent( { format: 'raw' } );
                content = _wpEditor.removep( content );
                editor.remove();
            } else {
                content = $( '#'+id ).val();
            }

            if ( $( '#wp-' + id + '-wrap').length > 0 ) {
                window._wpEditorBackUp = window._wpEditorBackUp || {};
                if (  typeof window._wpEditorBackUp[ id ] !== "undefined" ) {
                    $( '#wp-' + id + '-wrap').replaceWith( window._wpEditorBackUp[ id ] );
                }
            }

            $( '#'+id ).val( content );
        }

    };


    $.fn.wp_js_editor = function( options ) {

        // This is the easiest way to have default options.
        if ( options !== 'remove' ) {
            options = $.extend({
                sync_id: "", // sync to another text area
                tinymce: {}, // tinymce setting
                qtag:    {}, // quick tag settings
                mod:    '', // quick tag settings
                init_instance_callback: function(){} // quick tag settings
            }, options );
        } else{
            options =  'remove';
        }

        return this.each( function( ) {
            var edit_area  =  $( this );

            edit_area.uniqueId();
            // Make sure edit area have a id attribute
            var id =  edit_area.attr( 'id' ) || '';
            if ( id === '' ){
                return ;
            }

            if ( 'remove' !== options ) {
                if ( ! options.mod  ){
                    options.mod = edit_area.attr( 'data-editor-mod' ) || '';
                }

                window._wpEditorBackUp = window._wpEditorBackUp || {};
                window._wpEditorBackUp[ id ] =  edit_area;
                window._wpEditor.init( id, edit_area.val(), options );
            } else {
                window._wpEditor.remove( id );
            }

        });

    };

}( jQuery ));


jQuery( document ).ready( function( $ ){

   function screenr_the_editor( container ){
       var _editor = {
           ready: function( container ) {
               var control = this;
               if ( ! window.switchEditors ) {
                   return false;
               }
               control.container = container;
               control.editing_area = $( 'textarea' , control.container );
               control.editing_area.uniqueId();
               if ( control.container.hasClass( 'wp-editor-added' ) ) {
                   return true;
               }
               if ( control.editing_area.hasClass( 'ed-added' ) ) {
                   return true;
               }

               control.editing_area.addClass( 'ed-added' );
               control.container.addClass( 'screenr-editor-control' );

               control.container.addClass('wp-editor-added');
               control.editing_id = control.editing_area.attr( 'id' ) || '';
               control.editor_id = 'wpe-for-'+control.editing_id;
               control.preview = $( '<div id="preview-'+control.editing_id+'" class="wp-js-editor-preview"></div>');
               control.editing_editor = $( '<div id="wrap-'+control.editing_id+'" class="modal-wp-js-editor"><textarea id="'+control.editor_id+'"></textarea></div>');
               var content = control.editing_area.val();
               // Load default value
               $( 'textarea', control.editing_editor).val( content );
               control.preview.html( window.switchEditors._wp_Autop( content ) );

               $( 'body' ).on( 'click', '#customize-controls, .customize-section-back', function( e ) {
                   if ( ! $( e.target ).is( control.preview ) ) {
                       /// e.preventDefault(); // Keep this AFTER the key filter above
                       control.editing_editor.removeClass( 'wpe-active' );
                       $( '.wp-js-editor-preview').removeClass( 'wpe-focus');
                   }
               } );

               control._init();

               $( window ) .on( 'resize', function(){
                   control._resize();
               } );

           },

           _init: function(  ){

               var control = this;
               $( 'body .wp-full-overlay').append( control.editing_editor );

               $( 'textarea',  control.editing_editor).attr(  'data-editor-mod', ( control.editing_area.attr( 'data-editor-mod' ) || '' ) ) .wp_js_editor( {
                   sync_id: control.editing_area,
                   init_instance_callback: function( editor ) {
                       var w =  $( '#wp-'+control.editor_id+ '-wrap' );
                       $( '.wp-editor-tabs', w).append( '<button class="wp-switch-editor fullscreen-wp-editor"  type="button"><span class="dashicons"></span></button>' );
                       $( '.wp-editor-tabs', w).append( '<button class="wp-switch-editor preview-wp-editor"  type="button"><span class="dashicons dashicons-visibility"></span></button>' );
                       $( '.wp-editor-tabs', w).append( '<button class="wp-switch-editor close-wp-editor"  type="button"><span class="dashicons dashicons-no-alt"></span></button>' );
                       w.on( 'click', '.close-wp-editor', function( e ) {
                           e.preventDefault();
                           control.editing_editor.removeClass( 'wpe-active' );
                           $( '.wp-js-editor-preview').removeClass( 'wpe-focus');
                       } );
                       $( '.preview-wp-editor', w ).hover( function(){
                           w.closest( '.modal-wp-js-editor').css( { opacity: 0 } );
                       }, function(){
                           w.closest( '.modal-wp-js-editor').css( { opacity: 1 } );
                       } );
                       w.on( 'click', '.fullscreen-wp-editor', function( e ) {
                           e.preventDefault();
                           w.closest( '.modal-wp-js-editor').toggleClass( 'fullscreen' );
                           setTimeout( function(){
                               $( window ).resize();
                           }, 600 );
                       } );
                   }
               } );
               control.editing_area.on( 'change', function() {
                   control.preview.html( window.switchEditors._wp_Autop( $( this).val() ) );
               });

               control.preview.on( 'click', function( e ){
                   $( '.modal-wp-js-editor').removeClass( 'wpe-active' );
                   control.editing_editor.toggleClass( 'wpe-active' );
                   tinyMCE.get( control.editor_id ).focus();
                   control.preview.addClass( 'wpe-focus' );
                   control._resize();
                   return false;
               } );

               control.container.find( '.wp-js-editor').addClass( 'wp-js-editor-active' );
               control.preview.insertBefore( control.editing_area );
               control.container.on( 'click', '.wp-js-editor-preview', function( e ){
                   e.preventDefault();
               } );

           },

           _resize: function(){
               var control = this;
               var w =  $( '#wp-'+control.editor_id+ '-wrap');
               var height = w.innerHeight();
               var tb_h = w.find( '.mce-toolbar-grp' ).eq( 0 ).height();
               tb_h += w.find( '.wp-editor-tools' ).eq( 0 ).height();
               tb_h += 50;
               //var width = $( window ).width();
               var editor = tinymce.get( control.editor_id );
               control.editing_editor.width( '' );
               editor.theme.resizeTo( '100%', height - tb_h );
               w.find( 'textarea.wp-editor-area').height( height - tb_h  );
           }

       };

       _editor.ready( container );

   }

    function remove_editor( $context ){
        $( '.control.editing_area', $context ).each( function(){
            var id = $(this).attr( 'id' ) || '';
            var editor_id = 'wpe-for-'+id;
            try {
                editor = tinymce.get( editor_id );
                if ( editor ) {
                    editor.remove();
                }
                $( '#wrap-'+editor_id ).remove();
                $( '#wrap-'+id ).remove();

                if ( typeof tinyMCEPreInit.mceInit[ editor_id ] !== "undefined"  ) {
                    delete  tinyMCEPreInit.mceInit[ editor_id ];
                }

                if ( typeof tinyMCEPreInit.qtInit[ editor_id ] !== "undefined"  ) {
                    delete  tinyMCEPreInit.qtInit[ editor_id ];
                }

            } catch (e) {

            }

        } );
    }

    var _is_init_editors = {};


    $.each( SCREENR_PLUS_CUSTOMIZER.editor_controls,  function( key, type ) {
        var c = $( '#customize-control-'+ key );
        if ( type == 'textarea' ) {
            c.addClass( 'wp-js-editor' );
        } else {
            $( '.item-editor', c ).each( function(){
                c.addClass( 'wp-js-editor' );
            } );
        }
    } );

    $( 'body' ).on( 'click', '#customize-theme-controls li.accordion-section', function( e ){
        //e.preventDefault();
        var section = $( this );
        var id = section.attr( 'id' ) || '';
        if ( id.indexOf( 'accordion-section') > -1 ) {
            if ( typeof _is_init_editors[ id ] === "undefined" ) {
                _is_init_editors[ id ] = true;

                setTimeout( function() {
                    if ( $( '.customize-control-repeatable', section).length > 0 ) {

                        if ( $( '.repeatable-customize-control:not(.no-changeable) .item-editor', section ).length > 0 ) {
                            $( '.repeatable-customize-control:not(.no-changeable) .item-editor', section ).each( function(){
                                screenr_the_editor( $( this ) );
                            } );
                        }

                    } else {
                        if ( $( '.wp-js-editor', section ).length > 0 ) {
                            $( '.wp-js-editor', section ).each( function(){
                                screenr_the_editor( $( this ) );
                            } );
                        }
                    }

                }, 300 );

            }
        }
    } );


    // Check section when focus
    if ( _wpCustomizeSettings.autofocus ) {
        if ( _wpCustomizeSettings.autofocus.section ) {
            var id = "accordion-section-"+_wpCustomizeSettings.autofocus.section ;
            _is_init_editors[ id ] = true;
            var section = $( '#'+id );
            setTimeout( function(){


                if ( $( '.wp-js-editor', section ).length > 0 ) {
                    $( '.wp-js-editor', section ).each( function(){
                        screenr_the_editor( $( this ) );
                    } );
                }

                if ( $( '.repeatable-customize-control:not(.no-changeable) .item-editor', section ).length > 0 ) {
                    $( '.repeatable-customize-control:not(.no-changeable) .item-editor', section ).each( function(){
                        _the_editor( $( this ) );
                    } );
                }
            }, 1000 );

        } else if ( _wpCustomizeSettings.autofocus.panel ) {

        }
    }

    $( 'body' ).on( 'repeater-control-init-item', function( e, container ){
        $( '.item-editor', container ).each( function(){

            screenr_the_editor( $( this ) );
        } );
    } );

    $( 'body' ).on( 'repeat-control-remove-item', function( e, container ){
        remove_editor( container );
    } );



   // $( '[data-customize-setting-link="features_desc"]').wp_js_editor();
} );





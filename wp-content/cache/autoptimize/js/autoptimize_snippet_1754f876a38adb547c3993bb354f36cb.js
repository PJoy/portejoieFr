
jQuery( function() {
	if ( 'undefined' === typeof wp || ! wp.customize || ! wp.customize.selectiveRefresh ) {
		return;
	}
	function addtoany_init() {
		if ( window.a2a ) {
			a2a.init_all( 'page' );
		}
	}
	wp.customize.selectiveRefresh.bind( 'partial-content-rendered', function( placement ) {
		if ( placement.container ) {
			addtoany_init();
		}
	} );
} );
jQuery( document ).ready( function() {

	function galSetActionToTab( id ) {
		const frm = jQuery( '#gal_form' );

		frm.attr( 'action', frm.attr( 'action' ).replace( /(#.+)?$/, '#' + id ) );
	}

	let adminTabs = jQuery( '#gal-tabs' );

	adminTabs
		.find( 'a' )
		.on( 'click', function() {
			adminTabs.find( 'a' ).removeClass( 'nav-tab-active' );
			jQuery( '.galtab' ).removeClass( 'active' );
			const id = jQuery( this ).attr( 'id' ).replace( '-tab', '' );
			jQuery( '#' + id + '-section' ).addClass( 'active' );
			jQuery( this ).addClass( 'nav-tab-active' );

			// Set submit URL to this tab.
			galSetActionToTab( id );
		} );

	// Did page load with a tab active?
	const active_tab = window.location.hash.replace( '#', '' );
	if ( active_tab !== '' ) {
		const activeSection = jQuery( '#' + active_tab + '-section' );
		const activeTab = jQuery( '#' + active_tab + '-tab' );

		if ( activeSection && activeTab ) {
			adminTabs.find( 'a' ).removeClass( 'nav-tab-active' );
			jQuery( '.galtab' ).removeClass( 'active' );

			activeSection.addClass( 'active' );
			activeTab.addClass( 'nav-tab-active' );
			galSetActionToTab( active_tab );
		}
	}

	// JSON keyfile Browse for File <-> Textarea.
	jQuery( 'a.gal_jsonkeyfile' ).on( 'click', function( e ) {
		e.preventDefault();

		jQuery( 'input#input_ga_keyfileupload' ).replaceWith(
			jQuery(
				'<input type=\'file\' name=\'ga_keyfileupload\' id=\'input_ga_keyfileupload\' class=\'gal_jsonkeyfile\'/>',
			),
		);
		jQuery( '.gal_jsonkeyfile' ).hide();
		jQuery( '.gal_jsonkeytext' ).show();
	} );

	jQuery( 'a.gal_jsonkeytext' ).on( 'click', function( e ) {
		e.preventDefault();

		jQuery( '.gal_jsonkeytext' ).hide();
		jQuery( '.gal_jsonkeyfile' ).show();
		jQuery( 'textarea#input_ga_keyjson' ).val( '' );
	} );

	// Dependent fields in premium.
	// Default role only makes sense if Auto-create users is checked.
	let clickfn = function() {
		jQuery( '#ga_defaultrole' ).prop(
			'disabled',
			! jQuery( '#input_ga_autocreate' ).is( ':checked' ),
		);
	};
	jQuery( '#input_ga_autocreate' ).on( 'click', clickfn );
	clickfn();

	// Only allow "Completely hide WP login" if "Disable WP login for my domain" is checked.
	let clickfn2 = function() {
		jQuery( '#input_ga_hidewplogin' ).prop(
			'disabled',
			! jQuery( '#input_ga_disablewplogin' ).is( ':checked' ),
		);
	};
	jQuery( '#input_ga_disablewplogin' ).on( 'click', clickfn2 );
	clickfn2();

	// Only bother with any domain-specific options if a domain has been entered.
	if ( jQuery( '#input_ga_domainname' ).length > 0 ) {
		let domainchangefn = function() {
			let domainname = jQuery( '#input_ga_domainname' ).val().trim();

			jQuery( '#domain-section input.gal_needsdomain' ).prop(
				'disabled',
				domainname === '',
			);
		};
		jQuery( '#input_ga_domainname' ).on( 'change', domainchangefn );
		domainchangefn();
	}

	// Show service account button.
	jQuery( '#gal-show-admin-serviceacct' ).on( 'click', function( e ) {
		e.preventDefault();

		jQuery( '#gal-hide-admin-serviceacct' ).show();
		jQuery( '#gal-show-admin-serviceacct' ).hide();
	} );

	// Copy and paste click.
	function selectText( element ) {
		let range, selection;

		if ( document.body.createTextRange ) {
			//ms
			range = document.body.createTextRange();
			range.moveToElementText( element );
			range.select();
		} else if ( window.getSelection ) {
			//all others
			selection = window.getSelection();
			range = document.createRange();
			range.selectNodeContents( element );
			selection.removeAllRanges();
			selection.addRange( range );
		}
	}

	jQuery( '.gal-admin-scopes-list' ).on( 'click', function( e ) {
		selectText( e.target );
	} );
} );

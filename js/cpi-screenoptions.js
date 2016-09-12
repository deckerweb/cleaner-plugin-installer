/**
 * Add screen options for "Topics" tab.
 *
 * @package    Cleaner Plugin Installer
 * @subpackage JavaScript & jQuery
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2014-2016, David Decker - DECKERWEB
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL-2.0+
 * @link       http://genesisthemes.de/en/wp-plugins/cleaner-plugin-installer/
 * @link       http://deckerweb.de/twitter
 *
 * @since      1.2.1
 */

/**
 * Document ready.
 *
 * @author Brady Vercher of Blaser Six, Inc.
 * @link   https://profiles.wordpress.org/bradyvercher
 *
 * @since  1.2.1
 */
jQuery(function( $ ) {

	/** Wire up the toggle checkboxes in the screen options tab */
	$( '.cpi-search-type-toggle' ).on( 'change', function() {
		$.ajax({
			url: ajaxurl,
			type: 'POST',
			data: {
				action: 'ddw_cpi_screen_options',
				search_type: $( '.cpi-search-type-toggle:checked' ).val(),
				nonce: cpiScreenOptions.screenOptionsNonce
			},
			success: function( response ) {
				if ( 'data' in response && 'nonce' in response.data ) {
					cpiScreenOptions.screenOptionsNonce = response.data.nonce;
				}
			}
		});
	});
});

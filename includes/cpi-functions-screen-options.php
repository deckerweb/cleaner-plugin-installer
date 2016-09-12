<?php
/**
 * Various helper functions for this plugin.
 *
 * @package    Cleaner Plugin Installer
 * @subpackage Helper Functions
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2014-2016, David Decker - DECKERWEB
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL-2.0+
 * @link       http://genesisthemes.de/en/wp-plugins/cleaner-plugin-installer/
 * @link       http://deckerweb.de/twitter
 *
 * @since      1.0.0
 */

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'WPINC' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'load-plugin-install.php', 'ddw_cpi_add_plugin_installer_screen_options' );
/**
 * Add and register our screen option for plugin cards per page.
 *
 * @since  1.0.0
 *
 * @global string $GLOBALS[ 'wp_version' ]
 */
function ddw_cpi_add_plugin_installer_screen_options() {

	$string_cards = sprintf(
		_x( '%s per page', 'Plugin Cards/ Plugins per page', 'cleaner-plugin-installer' ),
		( version_compare( $GLOBALS[ 'wp_version' ], '4.0', '>=' ) ) ? __( 'Plugin Cards', 'cleaner-plugin-installer' ) : __( 'Plugins', 'cleaner-plugin-installer' )
	);

	$option_per_page = 'per_page';

	$args_per_page = array(
		'label'   => $string_cards,
		'default' => 24,
		'option'  => 'cpi_plugin_cards_per_page',
	);

	add_screen_option( $option_per_page, $args_per_page );

}  // end function


add_filter( 'set-screen-option', 'ddw_cpi_plugin_installer_set_screen_option', 10, 3 );
/**
 * Set screen option for plugin cards per page.
 *
 * See this link why only returning the $value here is correct:
 * @link   https://www.joedolson.com/2013/01/custom-wordpress-screen-options/
 *
 * @since  1.0.0
 *
 * @param  $status
 * @param  string $option
 * @param  int $value
 *
 * @return int $value Value for plugin cards per page.
 */
function ddw_cpi_plugin_installer_set_screen_option( $status, $option, $value ) {

	return $value;

}  // end function


/**
 * Validating user screen option for plugin cards per page option.
 *
 * @since  1.0.0
 *
 * @global string $GLOBALS[ 'pagenow' ]
 *
 * @return absint $per_page Value for plugin cards per page.
 */
function ddw_cpi_plugin_installer_plugin_cards_per_page() {

	$user   = get_current_user_id();
	$screen = get_current_screen();

	/**
	 * Bail early if not on a plugin-install.php!
	 *    We're using check against $GLOBALS[ 'pagenow' ] here, as check against
	 *    $screen->id is not Multisite compatible in this specific case.
	 */
	if ( 'plugin-install.php' != $GLOBALS[ 'pagenow' ] ) {

		return;

	}  // end if

	/** Retrieve our "per page" sreen option */
	$screen_option = $screen->get_option( 'per_page', 'option' );

	/** Get option's setting for the current user */
	$per_page = get_user_meta( $user, $screen_option, TRUE );

	/** Use default if empty or < 1 */
	if ( empty( $per_page ) || $per_page < 1 ) {

		$per_page = $screen->get_option( 'per_page', 'default' );

	}  // end if

	/** Return the value (absolute integer) */
	return absint( $per_page );

}  // end function


add_filter( 'plugins_api_args', 'ddw_cpi_tweak_plugins_api_args', 10, 2 );
/**
 * Apply screen options for Plugins API arguments: plugin cards per page.
 *
 * @since  1.0.0
 *
 * @uses   ddw_cpi_plugin_installer_plugin_cards_per_page()
 *
 * @return object $args Tweaked arguments for Plugins API.
 */
function ddw_cpi_tweak_plugins_api_args( $args, $action ) {

	$args->per_page = ddw_cpi_plugin_installer_plugin_cards_per_page();

	return $args;

}  // end function


add_filter( 'install_plugins_table_api_args_featured',    'ddw_cpi_tweak_plugins_api_tabs_args', 10, 1 );
add_filter( 'install_plugins_table_api_args_search',      'ddw_cpi_tweak_plugins_api_tabs_args', 10, 1 );
add_filter( 'install_plugins_table_api_args_popular',     'ddw_cpi_tweak_plugins_api_tabs_args', 10, 1 );
add_filter( 'install_plugins_table_api_args_new',         'ddw_cpi_tweak_plugins_api_tabs_args', 10, 1 );
add_filter( 'install_plugins_table_api_args_recommended', 'ddw_cpi_tweak_plugins_api_tabs_args', 10, 1 );
add_filter( 'install_plugins_table_api_args_favorites',   'ddw_cpi_tweak_plugins_api_tabs_args', 10, 1 );
add_filter( 'install_plugins_table_api_args_beta',        'ddw_cpi_tweak_plugins_api_tabs_args', 10, 1 );
/**
 * Apply screen options for Plugins API arguments - tab specific: plugin cards
 *    per page.
 *
 * @since  1.0.3
 *
 * @uses   ddw_cpi_plugin_installer_plugin_cards_per_page()
 *
 * @return array $args Tweaked arguments for Plugins API - tab specific.
 */
function ddw_cpi_tweak_plugins_api_tabs_args( $args ) {

	$args[ 'per_page' ] = ddw_cpi_plugin_installer_plugin_cards_per_page();

	return $args;

}  // end function


/**
 * Add our screen options.
 *
 * @author Brady Vercher of Blaser Six, Inc.
 * @link   https://profiles.wordpress.org/bradyvercher
 *
 * @since  1.2.1
 *
 * @param  string $settings Markup for additional custom screen options.
 * @param  object $screen Current admin screen object.
 *
 * @global string $GLOBALS[ 'pagenow' ]
 * @see    ddw_cpi_plugin_installer_plugin_cards_per_page()
 *
 * @return string $settings Markup for screen options.
 */
function ddw_cpi_installer_screen_settings( $settings, $screen ) {

	/** Bail early if not Plugin Installer "Topics" tab screen */
	if ( /* 'plugin-install' !== $screen->base */ 'plugin-install.php' != $GLOBALS[ 'pagenow' ] ) {

		return $settings;

	}  // end if

	/** Build our options markup */
	$settings .= sprintf(
		'<br /><h5 class="cpi-search-type">%s</h5>',
		__( 'Topics Search Type Selector', 'cleaner-plugin-installer' )
	);

	$selected = explode( ',', get_user_option( 'cpi_search_type', get_current_user_id() ) );

	$settings .= sprintf(
		'<label><input type="checkbox" value="%1$s"%2$s class="cpi-search-type-toggle"> %3$s</label>',
		'set_to_term',
		checked( in_array( 'set_to_term', $selected ), TRUE, FALSE ),
		sprintf(
			__( 'Set Search Type to %1$s (instead of %2$s)', 'cleaner-plugin-installer' ),
			'<em>' . __( 'keyword (term)', 'cleaner-plugin-installer' ) . '</em>',
			'<em>' . __( 'tag', 'cleaner-plugin-installer' ) . '</em>'
		)
	);

	$settings .= sprintf(
		'<input type="submit" class="button" value="%1$s" />',
		_x( 'Refresh Topics', 'Screen Options button label', 'cleaner-plugin-installer' )
	);

	/** Return our options markup */
	return $settings;

}  // end function


/**
 * Register & enqueue our screen options script; transmit nonce to it.
 *
 * @since 1.2.1
 *
 * @uses  ddw_cpi_script_suffix() Conditionally adding minified suffix.
 * @uses  ddw_cpi_script_version() Dynamically adding versioning string.
 * @uses  wp_localize_script() To transmit the nonce check.
 *
 * @param string $hook_suffix Unique ID of admin pagehook suffix.
 */
function ddw_cpi_screen_options_enqueue_assets( $hook_suffix ) {

	/** Bail early if not Plugin Installer "Topics" tab screen */
	if ( 'plugin-install.php' !== $hook_suffix ) {

		return;

	}  // end if

	/** Enqueue our screen options script */
	wp_enqueue_script(
		'cpi-screen-options',
		dirname( plugin_dir_url( __FILE__ ) ) . '/js/cpi-screenoptions' . ddw_cpi_script_suffix() . '.js',
		array( 'jquery' ),
		ddw_cpi_script_version()
	);

	/** Transmit the nonce to the script */
	wp_localize_script(
		'cpi-screen-options',
		'cpiScreenOptions',
		array(
			'screenOptionsNonce' => wp_create_nonce( 'save-cpi-preferences' ),
		)
	);

}  // end function


add_action( 'wp_ajax_ddw_cpi_screen_options', 'ddw_cpi_ajax_save_user_preferences' );
/**
 * AJAX saving of user settings, including santizing and error checking.
 *
 * @author Brady Vercher of Blaser Six, Inc.
 * @link   https://profiles.wordpress.org/bradyvercher
 *
 * @since  1.2.1
 *
 * @uses   check_ajax_referer()
 * @uses   wp_create_nonce()
 * @uses   wp_get_current_user()
 * @uses   wp_send_json_error()
 * @uses   update_user_option()
 * @uses   wp_send_json_success()
 */
function ddw_cpi_ajax_save_user_preferences() {

	$nonce_action = 'save-cpi-preferences';

	/** Verify the AJAX request to prevent external requests */
	check_ajax_referer( $nonce_action, 'nonce' );

	/** Generate & return nonce */
	$data = array( 'nonce' => wp_create_nonce( $nonce_action ) );

	/** Check for current user */
	if ( ! $user = wp_get_current_user() ) {

		wp_send_json_error( $data );

	}  // end if

	/** Update option for user */
	update_user_option( $user->ID, 'cpi_search_type', $_POST[ 'search_type' ] );

	/** Send JSON response back to Ajax request, indicating success */
	wp_send_json_success( $data );

}  // end function


add_filter( 'cpi_filter_default_search_type_selector', 'ddw_cpi_set_topics_search_type', 999, 1 );
/**
 * Set the search type for our listed topics of plugin tags: default is "tag",
 *    optionally switch on per user basis to "term".
 *
 * @param  string $type_default
 *
 * @return string $type_default Tweaked array of topic tags collections.
 */
function ddw_cpi_set_topics_search_type( $type_default ) {

	/** Retrieve user option */
	$type_default = get_user_option( 'cpi_search_type', get_current_user_id() );

	if ( 'set_to_term' === $type_default ) {

		/** Optionally switch to "term" */
		return 'term';

	}  // end if

	/** Otherwise keep the default ("tag") */
	return $type_default;

}  // end function

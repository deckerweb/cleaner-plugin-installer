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


/**
 * Check if "Slim Mode" is activated.
 *
 * @since  1.3.0
 *
 * @uses   CPI_SLIM_MODE Our helper constant, that could be activated in wp-config.php for example.
 *
 * @return bool TRUE when CPI_SLIM_MODE is defined, otherwise FALSE.
 */
function ddw_cpi_is_slim() {

	if ( defined( 'CPI_SLIM_MODE' ) && CPI_SLIM_MODE ) {

		return TRUE;

	}  // end if

	return FALSE;

}  // end function


add_action( 'admin_init', 'ddw_cpi_do_slim_mode' );
add_action( 'install_plugins_pre_upload', 'ddw_cpi_do_slim_mode' );		// Necessary!
/**
 * If "Slim Mode" is activated, remove a few of our hooked instances.
 *
 * @since 1.3.0
 */
function ddw_cpi_do_slim_mode() {

	if ( ddw_cpi_is_slim() ) {

		remove_action( 'ddw_cpi_plugin_installer_start', 'ddw_cpi_start_tab_text_after' );
		remove_action( 'ddw_cpi_plugin_uploader_zone', 'ddw_cpi_plugin_uploader_form_after' );
		add_filter( 'install_plugins_tabs', 'ddw_cpi_slim_remove_collections_tab', 100, 1 );

		remove_action( 'network_admin_notices', 'ddw_cpi_network_installer_notice' );
		remove_action( 'admin_notices', 'ddw_cpi_site_installer_notice' );

	}  // end if

}  // end function


/**
 * Remove "Collections" tab for Slim Mode.
 *
 * @since  1.3.0
 *
 * @param  array $tabs
 *
 * @return array $tabs Tweaked tabs output.
 */
function ddw_cpi_slim_remove_collections_tab( $tabs ) {

	unset( $tabs[ 'collections' ] );

	return $tabs;

}  // end function


/**
 * Helper function for returning string for minifying scripts/ stylesheets.
 *
 * @since  1.0.0
 *
 * @return string String for minifying scripts/ stylesheets.
 */
function ddw_cpi_script_suffix() {

	/** Bail early if not admin */
	if ( ! is_admin() ) {
		return;
	}

	return ( ( defined( 'WP_DEBUG' ) && WP_DEBUG ) || ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ) ? '' : '.min';

}  // end function


/**
 * Helper function for returning string for versioning scripts/ stylesheets.
 *
 * @since  1.0.0
 *
 * @return string Version string for versioning scripts/ stylesheets.
 */
function ddw_cpi_script_version() {

	/** Bail early if not admin */
	if ( ! is_admin() ) {
		return;
	}

	return ( ( defined( 'WP_DEBUG' ) && WP_DEBUG ) || ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ) ? time() : filemtime( plugin_dir_path( __FILE__ ) );

}  // end function


add_action( 'admin_init', 'ddw_cpi_register_admin_styles' );
/**
 * Load additional admin styles for our "searching" tab.
 *
 * @since 1.0.0
 *
 * @uses  ddw_cpi_script_suffix()  Conditionally adding minified suffix.
 * @uses  ddw_cpi_script_version() Dynamically adding versioning string.
 * @uses  is_rtl()                 Detecting Right-To-Left languages.
 */
function ddw_cpi_register_admin_styles() {

	/** Register the stylesheet */
	wp_register_style(
		'cpi-admin-styles',
		plugins_url( 'css/cpi-admin-styles' . ddw_cpi_script_suffix() . '.css', dirname( __FILE__ ) ),
		FALSE,
		ddw_cpi_script_version(),
		'all'
	);

	/** Register optional RTL stylesheet */
	if ( is_rtl() ) {

		wp_register_style(
			'cpi-admin-styles-rtl',
			plugins_url( 'css/cpi-admin-styles-rtl' . ddw_cpi_script_suffix() . '.css', dirname( __FILE__ ) ),
			FALSE,
			ddw_cpi_script_version(),
			'all'
		);

	}  // end if

	/** Register the srcipt */
	wp_register_script(
		'cpi-placeholder',
		plugins_url( 'js/cpi-placeholder' . ddw_cpi_script_suffix() . '.js', dirname( __FILE__ ) ),
		array( 'jquery' ),
		ddw_cpi_script_version()
	);

}  // end function


add_action( 'admin_head-plugin-install.php', 'ddw_cpi_enqueue_placholder_tweaks', 15 );
/**
 * Enqueue and transmit tweaks for original placeholder search bar in toolbar.
 *
 * @since  1.1.1
 *
 * @uses   wp_localize_script()
 *
 * @global string $GLOBALS[ 'tab' ]
 */
function ddw_cpi_enqueue_placholder_tweaks() {

	if ( ! in_array( $GLOBALS[ 'tab' ], array( 'search', 'new', 'popular', 'favorites', 'beta' ) ) ) {

		return;

	}  // end if

	/** Enqueue our script */
	wp_enqueue_script( 'cpi-placeholder' );

	/** Localize strings within JavaScript */
	wp_localize_script(
		'cpi-placeholder',
		'cpi_input',
		array(
			/* Translators: for the original search field in the installer toolbar */
			'text_placeholder' => _x( 'Search Plugins', 'Search placeholder text', 'cleaner-plugin-installer' ),
			/* Translators: for the original search field in the installer toolbar */
			'text_button'      => _x( 'Go', 'Search submit button text', 'cleaner-plugin-installer' )
		)
	);

}  // end function


/**
 * Add additional admin body class for certain tab sections.
 *
 * @since  1.0.0
 *
 * @param  string $classes CSS class(es).
 *
 * @global string $GLOBALS[ 'tab' ]
 *
 * @return string $classes CSS class(es).
 */
function ddw_cpi_add_admin_body_class( $classes ) {

	//$suffix = ( 'collections' === $GLOBALS[ 'tab' ] ) ? ' cpi-tab-collections' : '';
	$suffix = '';
	if ( 'featured' === $GLOBALS[ 'tab' ] ) {
		$suffix = ' cpi-tab-start';
	} elseif ( 'collections' === $GLOBALS[ 'tab' ] ) {
		$suffix = ' cpi-tab-collections';
	}

	$classes .= ' ' . 'ddw-cpi' . $suffix;

	return $classes;

}  // end function


/**
 * Helper function for building search legend output.
 *
 * @since  1.0.0
 *
 * @return array Array of labels/ strings for footnotes.
 */
function ddw_cpi_start_tab_legend() {

	/** Render legend strings */
	return apply_filters(
		'cpi_filter_search_keys_legend',
		array(
			'keyword' => array(
				'label'       => _x( 'Keyword', 'Search filter', 'cleaner-plugin-installer' ),
				'description' => __( 'Any search term, will be searched within plugin title, description, plus readme info', 'cleaner-plugin-installer' ),
			),
			'tag'     => array(
				'label'       => _x( 'Tag', 'Plugin Installer, search filter', 'cleaner-plugin-installer' ),
				'description' => __( 'Plugin tag, will be searched in readme tag list (set by plugin author)', 'cleaner-plugin-installer' ),
			),
			'author'  => array(
				'label'       => _x( 'Author', 'Search filter', 'cleaner-plugin-installer' ),
				'description' => sprintf(
					__( 'Must be a %s username', 'cleaner-plugin-installer' ),
					__( 'WordPress.org', 'cleaner-plugin-installer' )
				) . ' &#x3D; ' . __( 'Plugin author (developer), will be searched in readme/ plugin header info', 'cleaner-plugin-installer' ),
			),
		)
	);

}  // end function


/**
 * Check for supported plugin manager provider.
 *    Currently supported: "WPCore.com" & "WPFavs.com".
 *
 * @since  1.3.0
 *
 * @return string $provider Unique key for supported provider, otherwise 'none'.
 */
function ddw_cpi_collections_provider() {

	$provider = '';

	if ( class_exists( 'WPCore' )
		|| ( class_exists( 'WPCore' ) && class_exists( 'Wpfavs_Admin' ) )
	) {

		return $provider = 'wpcore';

	} elseif ( class_exists( 'Wpfavs_Admin' ) ) {

		return $provider = 'wpfavs';

	}  // end if

	return $provider = 'none';

}  // end function


/**
 * Link building helper function for installing plugins.
 *
 * @since  1.0.0
 *
 * @uses   wp_kses_post() Sanitizing linked text, but allow certain HTML tags.
 *
 * @param  string $plugin_slug Plugin slug.
 * @param  string $text        Plugin name.
 * @param  string $title_text  Plugin name for title attribute.
 * @param  string $class       Optional CSS class(es).
 *
 * @return string              HTML markup for links.
 */
function ddw_cpi_plugin_install_link( $plugin_slug = '', $text = '', $title_text = '', $class = '' ) {

	/** URL logic */
	if ( is_main_site() ) {

		$url = network_admin_url( 'plugin-install.php?tab=plugin-information&plugin=' . $plugin_slug . '&TB_iframe=true&width=600&height=550' );

	} else {

		$url = admin_url( 'plugin-install.php?tab=plugin-information&plugin=' . $plugin_slug . '&TB_iframe=true&width=600&height=550' );

	}  // end if

	/** Title attribute text */
	$title_text = sprintf(
		__( 'Install %s', 'cleaner-plugin-installer' ),
		esc_attr( $title_text )
	);

	/** Return the link markup */
	return sprintf(
		'<a%s href="%s" title="%s">%s</a>',
		( ! empty( $class ) ) ? ' class="' . esc_attr( $class ) . '"' : '',
		esc_url( $url ),
		esc_html( $title_text ),
		wp_kses_post( $text )
	);

}  // end function


/**
 * Add a little notice in the Multisite Network plugin installer pages to tell
 *    the user where he currently is (compared to the regular site installer).
 * @hook   'network_admin_notices'
 *
 * @since  1.1.0
 *
 * @global string $GLOBALS[ 'pagenow' ]
 */
function ddw_cpi_network_installer_notice() {

	/** Bail early if in Slim Mode or not in plugin installer */
	if ( 'plugin-install.php' !== $GLOBALS[ 'pagenow' ] ) {

		return;

	}  // end if

	$output = sprintf(
		'<p class="cpi-network-notice">%s: %s</p>',
		__( 'Your are here', 'cleaner-plugin-installer' ),
		__( 'Network Plugin Installer (Multisite)', 'cleaner-plugin-installer' )
	);

	echo $output;

}  // end function


/**
 * Add a little notice in the Multisite Network plugin installer pages to tell
 *    the user where he currently is (compared to the regular site installer).
 * @hook   'admin_notices'
 *
 * @since  1.3.0
 *
 * @global string $GLOBALS[ 'pagenow' ]
 */
function ddw_cpi_site_installer_notice() {

	/** Bail early if in Slim Mode or not in plugin installer */
	if ( 'plugins.php' !== $GLOBALS[ 'pagenow' ] ) {

		return;

	}  // end if

	/** Enqueue the stylesheet */
	wp_enqueue_style( 'cpi-admin-styles' );

	$output = sprintf(
		'<p class="cpi-site-notice">%s: %s <small><a href="%s" title="%s">[%s]</a></small></p>',
		__( 'Your are here', 'cleaner-plugin-installer' ),
		__( 'Site Plugin Listing', 'cleaner-plugin-installer' ),
		network_admin_url( 'plugins.php' ),
		esc_html_x( 'Go to Network plugins', 'Title attribute', 'cleaner-plugin-installer' ),
		esc_attr__( 'Go to Network', 'cleaner-plugin-installer')
	);

	echo $output;

}  // end function


add_filter( 'plugin_install_action_links', 'ddw_cpi_plugin_install_action_links', 10, 2 );
/**
 * Add plugin version to plugin card overview.
 *
 * @since 1.3.0
 *
 * @param array $action_links Collected action links in plugin card.
 * @param array $plugin       Values from Plugins API for each plugin.
 *
 * @return array $action_links Array of tweaked action links in plugin card.
 */
function ddw_cpi_plugin_install_action_links( $action_links, $plugin ) {

	/** Add to the action links */
	if ( ! ddw_cpi_is_slim() ) {

		$action_links[] = sprintf(
			'<div><small>%s %s</small></div>',
			_x( 'Version:', 'Plugin card: plugin version', 'cleaner-plugin-installer' ),
			wp_kses_data( $plugin[ 'version' ] )
		);

	}  // end if

	/** Render output */
	return $action_links;

}  // end function

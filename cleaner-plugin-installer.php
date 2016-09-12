<?php
/**
 * Main plugin file.
 * Cleaner Plugin Installer experience, replacing the "Featured" tab with bigger
 *     search. Additionally added "Topics" tab with curated topic tag list.
 *
 * @package     Cleaner Plugin Installer
 * @author      David Decker
 * @copyright   Copyright (c) 2014-2016, David Decker - DECKERWEB
 * @license     GPL-2.0+
 * @link        http://deckerweb.de/twitter
 *
 * @wordpress-plugin
 * Plugin Name:       Cleaner Plugin Installer
 * Plugin URI:        https://github.com/deckerweb/cleaner-plugin-installer
 * Description:       Cleaner Plugin Installer experience, replacing the "Featured" tab content with bigger search. Additionally added "Topics" tab with curated topic tag list.
 * Version:           1.4.0
 * Author:            David Decker - DECKERWEB
 * Author URI:        http://deckerweb.de/
 * License:           GPL-2.0+
 * License URI:       http://www.opensource.org/licenses/gpl-license.php
 * Text Domain:       cleaner-plugin-installer
 * Domain Path:       /languages/
 * Network:           true
 * GitHub Plugin URI: https://github.com/deckerweb/cleaner-plugin-installer
 * GitHub Branch:     master
 *
 * Copyright (c) 2014-2016 David Decker - DECKERWEB
 *
 *     This file is part of Cleaner Plugin Installer,
 *     a plugin for WordPress.
 *
 *     Cleaner Plugin Installer is free software:
 *     You can redistribute it and/or modify it under the terms of the
 *     GNU General Public License as published by the Free Software
 *     Foundation, either version 2 of the License, or (at your option)
 *     any later version.
 *
 *     Cleaner Plugin Installer is distributed in the hope that
 *     it will be useful, but WITHOUT ANY WARRANTY; without even the
 *     implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR
 *     PURPOSE. See the GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with WordPress. If not, see <http://www.gnu.org/licenses/>.
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
 * Setting constants.
 *
 * @since 1.0.0
 */
/** Plugin directory */
define( 'CLPINST_PLUGIN_DIR', trailingslashit( dirname( __FILE__ ) ) );

/** Plugin base directory */
define( 'CLPINST_PLUGIN_BASEDIR', trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) );


add_action( 'plugins_loaded', 'ddw_cpi_setup_plugin' );
/**
 * Plugin's inital setup: load translations, included needed files, set filters.
 *
 * @since  1.0.0
 *
 * @uses   get_locale() To retrieve current used Locale by install.
 * @uses   load_textdomain()	To load translations first from WP_LANG_DIR sub folder.
 * @uses   load_plugin_textdomain() To additionally load default translations from plugin folder (default).
 *
 * @global string $GLOBALS[ 'pagenow' ]
 */
function ddw_cpi_setup_plugin() {

	/** Bail early if not in /wp-admin/ */
	if ( ! is_admin()
		&& ! in_array( $GLOBALS[ 'pagenow' ], array( 'plugin-install.php', 'plugins.php' ) )
	) {

		return;

	}  // end if

	/** Set unique textdomain string */
	$cpi_textdomain = 'cleaner-plugin-installer';

	/** The 'plugin_locale' filter is also used by default in load_plugin_textdomain() */
	$locale = apply_filters( 'plugin_locale', get_locale(), $cpi_textdomain );

	/** Set filter for WordPress languages directory */
	$cpi_wp_lang_dir = apply_filters(
		'cpi_filter_wp_lang_dir',
		trailingslashit( WP_LANG_DIR ) . trailingslashit( $cpi_textdomain ) . $cpi_textdomain . '-' . $locale . '.mo'
	);

	/** Translations: First, look in WordPress' "languages" folder = custom & update-safe! */
	load_textdomain( $cpi_textdomain, $cpi_wp_lang_dir );

	/** Translations: Secondly, look in plugin's "languages" folder = default */
	load_plugin_textdomain( $cpi_textdomain, FALSE, CLPINST_PLUGIN_BASEDIR . 'languages' );


	/** Include plugin installer main functions */
	require_once( CLPINST_PLUGIN_DIR . 'includes/cpi-plugin-installer.php' );

	/** Include general (helper) functions */
	require_once( CLPINST_PLUGIN_DIR . 'includes/cpi-functions.php' );
	require_once( CLPINST_PLUGIN_DIR . 'includes/cpi-functions-dashboard.php' );

	/** Include admin specific functions, help tab etc. */
	require_once( CLPINST_PLUGIN_DIR . 'includes/cpi-admin-extras.php' );

	/** Add "Plugin Install" page link to plugins page */
	if ( is_admin() && current_user_can( 'install_plugins' ) ) {

		add_filter(
			'plugin_action_links_' . plugin_basename( __FILE__ ),
			'ddw_cpi_plugins_page_link'
		);

		add_filter(
			'network_admin_plugin_action_links_' . plugin_basename( __FILE__ ),
			'ddw_cpi_plugins_page_link'
		);

	}  // end if

	/** In Multisite: Add installer notices */
	if ( is_multisite() /* && 'plugin-install.php' != $GLOBALS[ 'pagenow' ] */ ) {

		add_action( 'network_admin_notices', 'ddw_cpi_network_installer_notice' );
		add_action( 'admin_notices', 'ddw_cpi_site_installer_notice' );

	}  // end if

}  // end function


/**
 * Check all prerequisites for our tweaked uploader page.
 *    Includes check for active third-party plugin "Upload Larger Plugins".
 *
 * @since 1.3.0
 */
function ddw_cpi_start_uploader() {

	if ( current_user_can( 'upload_plugins' )
		&& ! class_exists( 'Simba_Upload_Larger_Plugins' )
	) {

		return TRUE;

	} else {

		return FALSE;

	}  // end if

}  // end function


add_action( 'install_plugins_pre_upload', 'ddw_cpi_setup_uploader', 5 );
/**
 * Load additional functions for tweaking the Plugin ZIP Uploader page.
 *
 * @since 1.1.0
 *
 * @uses  ddw_cpi_start_uploader() To check all prerequisites.
 */
function ddw_cpi_setup_uploader() {

	if ( ddw_cpi_start_uploader() ) {

		/** Include uploader page functions */
		require_once( CLPINST_PLUGIN_DIR . 'includes/cpi-plugin-uploader.php' );

	}  // end if

}  // end function


/**
 * Returns current plugin's header data in a flexible way.
 *
 * @since  1.0.0
 *
 * @uses   is_admin()
 * @uses   get_plugins()
 * @uses   plugin_basename()
 *
 * @param  $cpi_plugin_value
 *
 * @return string Plugin data.
 */
function ddw_cpi_plugin_get_data( $cpi_plugin_value ) {

	/** Bail early if not admin */
	if ( ! is_admin() ) {

		return;

	}  // end if

	/** Include WordPress plugin data */
	if ( ! function_exists( 'get_plugins' ) ) {

		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	}  // end if

	$cpi_plugin_folder = get_plugins( '/' . plugin_basename( dirname( __FILE__ ) ) );
	$cpi_plugin_file   = basename( ( __FILE__ ) );

	return $cpi_plugin_folder[ $cpi_plugin_file ][ $cpi_plugin_value ];

}  // end function

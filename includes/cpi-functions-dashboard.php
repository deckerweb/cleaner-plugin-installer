<?php
/**
 * Dashboard-related functions for this plugin, including Multisite.
 *
 * @package    Cleaner Plugin Installer
 * @subpackage Dashboard Functions
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2014-2016, David Decker - DECKERWEB
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL-2.0+
 * @link       http://genesisthemes.de/en/wp-plugins/cleaner-plugin-installer/
 * @link       http://deckerweb.de/twitter
 *
 * @since      1.3.0
 */

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'WPINC' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'rightnow_end', 'ddw_cpi_dashboard_search', 5 );
add_action( 'wpmuadminresult', 'ddw_cpi_dashboard_search', 5 );
/**
 * Add plugin search field to "At a Glance"/ "Right Now" Dashboard widgets.
 *
 * @since  1.3.0
 * @since  1.4.0 Feature does no longer work with WP 4.6+ therefore we do a version check now.
 *
 * @return string HTML markup for plugin search functionality.
 */
function ddw_cpi_dashboard_search() {

	/** Bail early if no plugin expert is on it :) */
	if ( ! current_user_can( 'install_plugins' )
		|| ( is_multisite() && ! current_user_can( 'manage_network' ) )
		|| ( version_compare( get_bloginfo( 'version' ), '4.6', '>=' ) )
	) {

		return;

	}  // end if

	$term        = isset( $_REQUEST[ 's' ] ) ? wp_unslash( $_REQUEST[ 's' ] ) : '';
	$button_type = apply_filters( 'cpi_filter_dashboard_button_type', 'button' );

	/** Begin markup: */
	?>

		<div class="cpi-dashboard">
			<form class="cpi-dashboard-search-form search-plugins" method="get" action="<?php echo network_admin_url( 'plugin-install.php' ); ?>">
				<input type="hidden" name="tab" value="search" />
				<input type="hidden" name="type" value="term" />
				<label for="cpi-dashboard-search"><?php _e( 'Find plugins', 'cleaner-plugin-installer' ); ?>
					<input id="cpi-dashboard-search" type="search" placeholder="<?php _e( 'Plugin keyword', 'cleaner-plugin-installer' ); ?> &#x2026;" name="s" value="<?php echo esc_attr( $term ) ?>" />
				</label>
				<?php submit_button(
					_x( 'Plugin Search', 'Submit button label', 'cleaner-plugin-installer' ),
					sanitize_html_class( $button_type ),
					FALSE,
					FALSE,
					array( 'id' => 'search-submit' )
				); ?>
			</form>
		</div>

	<?php
	/** ^ End markup */

}  // end function


/**
 * Prepare plugin counters for the Dashboard output.
 *
 * @since  1.3.0
 *
 * @return array Array of string values for later output.
 */
function ddw_cpi_plugins_counters_prepare() {

	/** Counter for active network wide plugins */
	if ( is_multisite() ) {

		$count_active_sitewide = get_site_option( 'active_sitewide_plugins', array() );
		$count_active_sitewide = count( $count_active_sitewide );

		$text_active_sitewide = sprintf(
			_n( '%s active', '%s active', $count_active_sitewide, 'cleaner-plugin-installer' ),
			absint( $count_active_sitewide )
		);

	} else {

		$count_active_sitewide = 0;
		$text_active_sitewide  = '';

	}  // end if

	/** Counter for active plugins (per site) */
	$count_active = get_option( 'active_plugins', array() );
	$count_active = count( $count_active );

	$text_active = sprintf(
		_n( '%s active', '%s active', $count_active, 'cleaner-plugin-installer' ),
		absint( $count_active )
	);

	/** Counter for all installed plugins */
	$count_all = get_plugins();
	$count_all = count( $count_all );
	$count_all = is_network_admin() ? $count_all : $count_all - $count_active_sitewide;

	$text_all = sprintf(
		_n( '%s installed', '%s installed', $count_all, 'cleaner-plugin-installer' ),
		absint( $count_all )
	);

	return array(
		'text_active'          => $text_active,
		'text_active_sitewide' => $text_active_sitewide,
		'text_all'             => $text_all,
	);

}  // end function


add_action( 'dashboard_glance_items', 'ddw_cpi_plugins_glancer', 100 );
/**
 * Add plugin counters to "At a Glance" Dashboard widget.
 *
 * @since  1.3.0
 *
 * @uses   ddw_cpi_plugins_counters_prepare()
 *
 * @param  string $glancer_elements
 */
function ddw_cpi_plugins_glancer( $glancer_elements ) {

	/** Bail early if Slim Mode or no plugin expert is on it :) */
	if ( ddw_cpi_is_slim()
		|| ! current_user_can( 'install_plugins' )
		|| ( is_multisite() && ! current_user_can( 'manage_network' ) )
	) {

		return;

	}  // end if

	/** Enqueue the stylesheet */
	wp_enqueue_style( 'cpi-admin-styles' );

	$plugin_counters = (array) ddw_cpi_plugins_counters_prepare();

	$system = is_multisite() ? ' <small>(' . __( 'Site', 'cleaner-plugin-installer' ) . ')</small>' : '';

	/** Add our Glancer element $glancer_elements[ 'cpi_plugins' ] */
	$glancer_elements = sprintf(
		'<li class="cpi-count">%1$s <a class="cpi-plugins-active" href="%2$s" title="%3$s">%4$s</a>, <a class="cpi-plugins-installed" href="%5$s" title="%6$s">%7$s</a>%8$s</li>',
		__( 'Plugins:', 'cleaner-plugin-installer' ),
		admin_url( 'plugins.php?plugin_status=active' ),
		esc_html( $plugin_counters[ 'text_active' ] ),
		$plugin_counters[ 'text_active' ],
		admin_url( 'plugins.php?plugin_status=all' ),
		esc_html( $plugin_counters[ 'text_all' ] ),
		$plugin_counters[ 'text_all' ],
		$system
	);

	/** Render tweaked Glancer elements */
	echo $glancer_elements;

}  // end function


add_action( 'wpmuadminresult', 'ddw_cpi_multisite_dashboard_plugins', 4 );
/**
 * Add plugin counters to "Right Now" Dashboard widget (in Multisite's Network admin).
 *
 * @since 1.3.0
 *
 * @uses  ddw_cpi_plugins_counters_prepare()
 */
function ddw_cpi_multisite_dashboard_plugins() {

	/** Bail early if Slim Mode or no plugin expert is on it :) */
	if ( ddw_cpi_is_slim()
		|| ! current_user_can( 'install_plugins' )
		|| ( is_multisite() && ! current_user_can( 'manage_network' ) )
	) {

		return;

	}  // end if

	/** Enqueue the stylesheet */
	wp_enqueue_style( 'cpi-admin-styles' );

	$plugin_counters = (array) ddw_cpi_plugins_counters_prepare();

	/** Add our Glancer element */
	$multisite_dashboard = sprintf(
		'<div class="cpi-multisite-dashboard">%1$s <a class="cpi-plugins-active" href="%2$s" title="%3$s">%4$s</a> <small>(%5$s)</small>, <a class="cpi-plugins-installed" href="%6$s" title="%7$s">%8$s</a> <small>(%9$s)</small></div><br />',
		__( 'Network Plugins:', 'cleaner-plugin-installer' ),
		network_admin_url( 'plugins.php?plugin_status=active' ),
		esc_html( $plugin_counters[ 'text_active_sitewide' ] ),
		$plugin_counters[ 'text_active_sitewide' ],
		__( 'network wide', 'cleaner-plugin-installer' ),
		network_admin_url( 'plugins.php?plugin_status=all' ),
		esc_html( $plugin_counters[ 'text_all' ] ),
		$plugin_counters[ 'text_all' ],
		__( 'overall', 'cleaner-plugin-installer' )
	);

	/** Render tweaked Glancer elements */
	echo $multisite_dashboard;

}  // end function

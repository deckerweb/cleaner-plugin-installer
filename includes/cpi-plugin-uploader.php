<?php
/**
 * Tweaked markup for the "Upload" tab.
 *
 * @package    Cleaner Plugin Installer
 * @subpackage Admin Plugin Installer
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2014-2016, David Decker - DECKERWEB
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL-2.0+
 * @link       http://genesisthemes.de/en/wp-plugins/cleaner-plugin-installer/
 * @link       http://deckerweb.de/twitter
 *
 * @since      1.1.0
 */

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'WPINC' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'install_plugins_pre_upload', 'ddw_cpi_tweak_plugin_uploader_start', 10 );
/**
 * Remove uploader form.
 *    Instead re-add our own tweaked version of it.
 *
 * @since 1.1.0
 */
function ddw_cpi_tweak_plugin_uploader_start() {

	/** Remove original "upload" tab/ content */
	remove_action( 'install_plugins_upload', 'install_plugins_upload', 10, 1 );

	/** Load our admin body class functionality */
	add_filter( 'admin_body_class', 'ddw_cpi_add_admin_body_class' );

	/** Load our new tweaked content */
	add_action( 'install_plugins_upload', 'ddw_cpi_plugin_uploader_start', 10, 1 );

}  // end function


/**
 * Set our own action hook: for adding various content blocks easily.
 *
 * @since 1.1.0
 *
 * @param string $page The current page number of the plugins list table.
 */
function ddw_cpi_plugin_uploader_start( $page = 1 ) {

	do_action( 'ddw_cpi_plugin_uploader_zone' );

}  // end function


add_action( 'ddw_cpi_plugin_uploader_zone', 'ddw_cpi_plugin_uploader_form' );
/**
 * "Uploader" content: the zip file upload form, tweaked.
 *
 * @since 1.1.0
 *
 * @uses  self_admin_url()
 * @uses  wp_nonce_field()
 * @uses  sanitize_text_field()
 *
 * @param int $page
 */
function ddw_cpi_plugin_uploader_form( $page = 1 ) {

	$button_type   = apply_filters( 'cpi_filter_uploader_button_type', 'button button-primary' );
	$button_string = _x( 'Upload &amp; Install Now', 'Submit button label', 'cleaner-plugin-installer' );

	?>
		<div class="cpi-uploader upload-plugin">
			<p class="install-help">
				<?php _ex( 'If you have a plugin in a .zip format, you may install it by uploading it here.', 'Description before file input field', 'cleaner-plugin-installer' ); ?>
			</p>
			<form method="post" enctype="multipart/form-data" class="wp-upload-form" action="<?php echo self_admin_url( 'update.php?action=upload-plugin' ); ?>">
				<?php wp_nonce_field( 'plugin-upload' ); ?>
				<label class="screen-reader-text" for="pluginzip"><?php _ex( 'Plugin zip file', 'File field label', 'cleaner-plugin-installer' ); ?></label>
				<input type="file" id="pluginzip" name="pluginzip" />
				<button name="install-plugin-submit" id="install-plugin-submit" class="<?php echo sanitize_text_field( $button_type ); ?>" value="<?php echo $button_string; ?>" type="submit" /><?php echo $button_string; ?></button>
			</form>
		</div>
	<?php

}  // end function


add_action( 'ddw_cpi_plugin_uploader_zone', 'ddw_cpi_plugin_uploader_form_after' );
/**
 * "Uploader" content: advises after the form.
 *
 * @since 1.1.0
 *
 * @uses  ddw_cpi_uploads_tab_content_footnote() For displaying footnote content.
 */
function ddw_cpi_plugin_uploader_form_after() {

	/** Build our output for display */
	$output = '<div class="cpi-block"><br /><hr /><br /><div class="cpi-uploader-after">';

	/** Hook in after <hr /> but within our div containers */
	do_action( 'ddw_cpi_uploader_footnote_before' );

	/** Conditionally show our footnote user notes */
	if ( apply_filters( 'cpi_filter_show_uploader_footnote', TRUE ) ) {

		$output .= ddw_cpi_uploads_tab_content_footnote( FALSE );

	}  // end if

	/** Hook in after footnote content but still within our div containers */
	do_action( 'ddw_cpi_uploader_footnote_after' );

	$output .= '</div></div>';

	/** Render the output */
	echo $output;

}  // end function


/**
 * Helper function for displaying Upload page footnote content.
 *
 * @since  1.1.0
 *
 * @uses   ddw_cpi_info_values() For returning info values.
 *
 * @param  bool $echo For echoing or returning the output.
 *
 * @return string $output Echoing or returing string with markup.
 */
function ddw_cpi_uploads_tab_content_footnote( $echo = TRUE ) {

	$cpi_info = (array) ddw_cpi_info_values();

	$output = '
		<p class="description">' . __( 'Currently, the above Uploader only accepts one (1 and only 1) plugin at a time.', 'cleaner-plugin-installer' ) . '</p>
		<p class="description">' . sprintf(
			/* Translators: 1 plugin name, 2 search term */
			__( 'For bulk installing more than one plugin, use %s or search for %s.', 'cleaner-plugin-installer' ),
			'<a href="' . network_admin_url( 'plugin-install.php?tab=collections' ). '"><em>&raquo;' . __( 'WPCore Plugin Manager', 'cleaner-plugin-installer' ) . '&laquo;</em></a>',
			'<a href="' . network_admin_url( 'plugin-install.php?tab=search&type=term&s=plugin+bulk+install' ) . '" title="' . esc_html__( 'Start the search in plugin repository &hellip;', 'cleaner-plugin-installer' ) . '"><code>plugin bulk install</code></a>'	// not for translation = search key phrase!
		) . '</p>
		<p class="description">' . sprintf(
			/* Translators: 1 = WordPress Core, 2 = create a ticket, 3 = Make WordPress Core, 4 = Trac */
			__( 'For changing this behavior in %1$s you can always %2$s in the official development base %3$s (a.k.a. %4$s).', 'cleaner-plugin-installer' ),
			'<em>' . __( 'WordPress Core', 'cleaner-plugin-installer' ) . '</em>',
			'<a href="' . esc_url( $cpi_info[ 'core_new_ticket' ] ) . '" target="_blank">' . __( 'create a ticket', 'cleaner-plugin-installer' ) . '</a>',
			'<a href="' . esc_url( $cpi_info[ 'core_make' ] ) . '" target="_blank">' . __( 'Make WordPress Core', 'cleaner-plugin-installer' ) . '</a>',
			'<a href="#" target="_blank"><em>' . __( 'Trac', 'cleaner-plugin-installer' ) . '</em></a>'
		) . '</p>
	';

	/** Render/ return output */
	if ( $echo ) {

		echo $output;

	} else {

		return $output;

	}  // end if

}  // end function

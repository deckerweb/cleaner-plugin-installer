<?php
/**
 * Locale specific functions for German locales (de_DE, de_AT, de_CH, de_LU, gsw).
 *
 * @package    Cleaner Plugin Installer
 * @subpackage de_DE Functions
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


/**
 * German-ized tags list for those German locales, ya know...
 *
 * @since  1.1.0
 *
 * @return array Array of plugin tags.
 */
function ddw_cpi_topic_locale_de() {

	return apply_filters(
		'cpi_filter_topic_tags_locale_de',
		array(
			'german' => array(
				'name' => 'German',
				'slug' => 'german',
			),
			'deutsch' => array(
				'name' => 'Deutsch',
				'slug' => 'deutsch',
			),
			'de_de' => array(
				'name' => 'de_DE',
				'slug' => 'de_DE',
			),
			'austria' => array(
				'name' => esc_html_x( 'Austria', 'Plugin tag name', 'cleaner-plugin-installer' ),
				'slug' => 'austria',
			),
		)
	);

}  // end function


add_filter( 'cpi_filter_topic_tag_collections', 'ddw_cpi_add_german_topic_tag_listing', 10, 1 );
/**
 * Guten Tag!
 *    German-ize our Topic tag list a bit, adding a few tags for German locales
 *    only (de_DE, de_AT, de_CH, de_LU, gsw).
 *    --Viel Spass damit! :)
 *
 * @since  1.1.0
 *
 * @param  array $collections
 *
 * @return array $collections Tweaked array of topic tags collections.
 */
function ddw_cpi_add_german_topic_tag_listing( $collections ) {

	$collections[ 'cpi_german' ] = array(
		'title'    => _x( 'German Tags (de_DE)', 'Topic tags collection title', 'cleaner-plugin-installer' ),
		'function' => ddw_cpi_topic_locale_de(),
		'type'     => 'tag',
	);

	return $collections;

}  // end function

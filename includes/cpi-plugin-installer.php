<?php
/**
 * Basic functionality of this plugin.
 *
 * @package    Cleaner Plugin Installer
 * @subpackage Admin Plugin Installer
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


add_filter( 'install_plugins_tabs', 'ddw_cpi_plugin_installer_tweak_tabs', 5, 1 );
/**
 * Plugin installer tabs: Rename, reorder some existing tabs, plus, add new tabs
 *    to the stack.
 *
 * @since  1.0.0
 *
 * @uses   is_rtl() Detecting Right-To-Left languages.
 *
 * @param  array $tabs Array of plugin installer tabs.
 *
 * @global string $GLOBALS[ 'tab' ]
 * @global string $GLOBALS[ 'wp_version' ]
 */
function ddw_cpi_plugin_installer_tweak_tabs( $tabs ) {

	/** Enqueue the stylesheet */
	wp_enqueue_style( 'cpi-admin-styles' );

	/** Enqueue optional RTL stylesheet */
	if ( is_rtl() ) {

		wp_enqueue_style( 'cpi-admin-styles-rtl' );

	}  // end if

	$tabs = array();

	/** Rename existing tab */
	$tabs[ 'featured' ] = '<strong>' . _x( 'Start: Search', 'Tab name in toolbar', 'cleaner-plugin-installer' ) . '</strong>';

	/** Add new "Topics" tab */
	$tabs[ 'topics' ] = '<strong>' . _x( 'Topics', 'Tab name in toolbar', 'cleaner-plugin-installer' ) . '</strong>';

	/** Optional include "Collections"/ "WPCore"/"WpFavs" plugin info */
	if ( current_user_can( 'manage_options' ) ) {

		$tabs[ 'collections' ] = '<strong>' . _x( 'Collections', 'Tab name in toolbar', 'cleaner-plugin-installer' ) . '</strong>';

	}  // end if

	/** Re-enable hidden tab from core */
	$tabs[ 'new' ] = _x( 'Newest', 'Tab name in toolbar', 'cleaner-plugin-installer' );

	/** Stack other existings tabs to the end */
	$tabs_later                = array();
	$tabs[ 'recommended' ]     = _x( 'Recommended', 'Tab name in toolbar', 'cleaner-plugin-installer' );	// since WP 4.1+
	$tabs_later[ 'popular' ]   = _x( 'Popular', 'Tab name in toolbar', 'cleaner-plugin-installer' );
	$tabs_later[ 'favorites' ] = _x( 'Favorites', 'Tab name in toolbar', 'cleaner-plugin-installer' );
	/** For alpha-, beta-, RC-versions of WordPress Core */
	if ( 'beta' === $GLOBALS[ 'tab' ] || FALSE !== strpos( $GLOBALS[ 'wp_version' ], '-' ) ) {
		$tabs_later[ 'beta' ]  = _x( 'Beta Testing', 'Tab name in toolbar', 'cleaner-plugin-installer' );
	}
	/** Include search tab here, only when performing a search */
	if ( 'search' == $GLOBALS[ 'tab' ] ) {
		$tabs_later[ 'search' ] = _x( 'Search Results', 'Tab name in toolbar', 'cleaner-plugin-installer' );
	}
	/** The 'virtual tab' "Upload Plugin" (button) */
	if ( current_user_can( 'upload_plugins' ) ) {
		$tabs_later[ 'upload' ] = _x( 'Upload Plugin', 'Upload button label', 'cleaner-plugin-installer' );
	}

	/** Merge our "default" tabs with the new "add-to-the-end-of-stack" tabs */
	$tabs = array_merge(
		apply_filters( 'cpi_filter_install_plugins_tabs', $tabs ),
		apply_filters( 'cpi_filter_install_plugins_tabs_later', $tabs_later )
	);

	/** Return tweaked tabs array */
	return $tabs;

}  // end function


add_action( 'install_plugins_pre_featured', 'ddw_cpi_tweak_plugin_installer_start', 0 );
/**
 * Remove featured content.
 *    Instead add our own content.
 *
 * @since 1.0.0
 */
function ddw_cpi_tweak_plugin_installer_start() {

	/** Remove original "featured" tab/ content */
	remove_action( 'install_plugins_featured', 'install_dashboard' );		// WP 4.0+
	remove_action( 'install_plugins_featured', 'display_plugins_table' );	// WP pre 4.0

	/** Load our admin body class functionality */
	add_filter( 'admin_body_class', 'ddw_cpi_add_admin_body_class' );

	/** Load our new stripped down content */
	add_action( 'install_plugins_featured', 'ddw_cpi_plugins_install_dashboard', 10, 1 );

}  // end function


/**
 * Set our own action hook: for adding various content blocks easily.
 *
 * @since 1.0.0
 *
 * @param string $page The current page number of the plugins list table.
 */
function ddw_cpi_plugins_install_dashboard( $page = 1 ) {

	do_action( 'ddw_cpi_plugin_installer_start' );

}  // end function


add_action( 'ddw_cpi_plugin_installer_start', 'ddw_cpi_start_tab_text_intro' );
/**
 * Tab "Start: Search": Intro text. GPL-2.0+
 *
 * @since 1.0.0
 *
 * @uses  ddw_cpi_info_values()
 */
function ddw_cpi_start_tab_text_intro() {

	/** Get info values */
	$cpi_info = (array) ddw_cpi_info_values();

	/** Build output */
	$output = '
		<div class="cpi-block cpi-start-intro">
			<h3>' . __( 'Search for Plugins', 'cleaner-plugin-installer' ) . '</h3>
			<p>' . sprintf(
				/* translators: WordPress.org repo */
				__( 'Find plugins on the official %s plugin repository.', 'cleaner-plugin-installer' ),
				__( 'WordPress.org', 'cleaner-plugin-installer' )
			) . ' ' . sprintf(
				/* translators: 1 = Open Source, 2 = GPL-2.0+ */
				__( 'All are %s and licensed under %s or compatible.', 'cleaner-plugin-installer' ),
				'<a href="' . network_admin_url( 'freedoms.php' ) . '">' . __( 'Open Source', 'cleaner-plugin-installer' ) . '</a>',
				'<a href="' . esc_url( $cpi_info[ 'url_license' ] ). '" target="_new">' . esc_attr( $cpi_info[ 'license' ] ). '</a>'
			) . '</p><br class="clear" />
		</div>
	';

	/** Build Slim Mode output */
	$output_slim = '<div class="cpi-block cpi-start-intro">&nbsp;</div>';

	/** Render output */
	echo ddw_cpi_is_slim() ? $output_slim : $output;

}  // end function


add_action( 'ddw_cpi_plugin_installer_start', 'ddw_cpi_start_tab_search_field' );
/**
 * Tab "Start: Search": Large search input field.
 *
 * NOTE:
 *  This search form is pretty much a copy of the original search from Core!
 *  (See function install_search_form() in wp-admin/includes/plugin-install.php)
 *
 * @since  1.0.0
 * @since  1.4.0 Tweaked for the changes in WP 4.6+ (sadly...).
 *
 * @return string HTML markup for search functionality.
 */
function ddw_cpi_start_tab_search_field() {

	$type        = isset( $_REQUEST[ 'type' ] ) ? wp_unslash( $_REQUEST[ 'type' ] ) : 'term';
	$term        = isset( $_REQUEST[ 's' ] ) ? wp_unslash( $_REQUEST[ 's' ] ) : '';
	$input_attrs = '';
	$button_type = apply_filters( 'cpi_filter_start_button_type', 'primary' );

	/** Add markup for plugin search */
	?>
		<div class="cpi-block cpi-start-search-form">

			<form class="cpi-search-form search-plugins" method="get">
				<input type="hidden" name="tab" value="search" />

				<div class="one-sixth first">
					<select name="type" id="typeselector">
						<option value="term"<?php selected( 'term', $type ) ?>><?php _ex( 'Keyword', 'Search filter', 'cleaner-plugin-installer' ); ?>:</option>
						<option value="tag"<?php selected( 'tag', $type ) ?>><?php _ex( 'Tag', 'Plugin Installer, search filter', 'cleaner-plugin-installer' ); ?>:</option>
						<option value="author"<?php selected( 'author', $type ) ?>><?php _ex( 'Author', 'Search filter', 'cleaner-plugin-installer' ); ?>:</option>
					</select>
				</div>

				<div class="three-sixths">
					<label><span class="screen-reader-text"><?php _ex( 'Search Plugins', 'Screen reader text', 'cleaner-plugin-installer' ); ?></span>
						<input type="search" name="s" placeholder="<?php _ex( 'Your plugin search term &hellip;', 'Placeholder label', 'cleaner-plugin-installer' ); ?>" value="<?php echo esc_attr( $term ) ?>" class="wp-filter-search" <?php echo $input_attrs; ?>/>
					</label>
				</div>

				<div class="two-sixths">
					<?php submit_button(
						_x( 'Search Plugins', 'Submit button label', 'cleaner-plugin-installer' ),
						sanitize_html_class( $button_type ),
						FALSE,
						FALSE,
						array( 'id' => 'search-submit' )
					); ?>
				</div>
				<div class="clear"></div>
			</form>

		</div>

	<?php
	/** ^ End of markup for search form */

	if ( version_compare( get_bloginfo( 'version' ), '4.6', '>=' ) ) {

		/** Add special markup for WP 46.+ -- plugin table display */
		?>
			<form id="plugin-filter" method="post">
				<div class="wp-list-table widefat plugin-install">
				</div>
			</form>
		<?php
		/** ^ End of markup for plugin table display */

	}  // end if

}  // end function


add_action( 'ddw_cpi_plugin_installer_start', 'ddw_cpi_start_tab_text_after' );
/**
 * Tab "Start: Search": Outro text (legend).
 *
 * @since 1.0.0
 *
 * @uses  ddw_cpi_start_tab_legend() To build the legend strings & markup.
 */
function ddw_cpi_start_tab_text_after() {

	/** Build our output for display */
	$output = '<div class="cpi-block cpi-start-after"><br /><hr /><br />';

	/** Hook in after <hr /> but within our div containers */
	do_action( 'ddw_cpi_start_tab_legend_before' );

	/** Conditionally show our legend user notes */
	if ( apply_filters( 'cpi_filter_show_start_tab_legend', TRUE ) ) {

		foreach ( ddw_cpi_start_tab_legend() as $string => $string_item ) {

			$output .= sprintf(
				'<div class="one-sixth first description"><strong>%s <i class="cpi-arrow-legend"></i></strong></div><div class="five-sixths description">%s</div>',
				$string_item[ 'label' ],
				$string_item[ 'description' ]
			);

		}  // end foreach

	}  // end if

	echo '<div class="clear"></div>';

	/** Hook in after legend content but still within our div containers */
	do_action( 'ddw_cpi_start_tab_legend_after' );

	$output .= '</div>';

	/** Render the output */
	echo $output;

}  // end function


add_action( 'install_plugins_pre_topics', 'ddw_cpi_prepare_tabs' );
add_action( 'install_plugins_pre_collections', 'ddw_cpi_prepare_tabs' );
/**
 * Tab "Topics" & Tab "Collections": add our body class.
 * Tab "Topics": set additional screen option.
 *
 * @since 1.0.0
 */
function ddw_cpi_prepare_tabs() {

	/** Load our admin body class functionality */
	add_filter( 'admin_body_class', 'ddw_cpi_add_admin_body_class' );

	/** Load special screen options only for "Topics" tab */
	if ( 'topics' === $GLOBALS[ 'tab' ] ) {

		add_filter( 'screen_settings', 'ddw_cpi_installer_screen_settings', 10, 2 );
		add_action( 'admin_enqueue_scripts', 'ddw_cpi_screen_options_enqueue_assets' );

	}  // end if

}  // end function


add_action( 'install_plugins_topics', 'ddw_cpi_installer_tab_topics', 10, 1 );
/**
 * Add special tab "Topics" (lists of curated tags).
 *    Set our own action hook for easily addting content.
 *    Load the required helper functions for this tab only.
 *
 * @since 1.0.0
 *
 * @param string $page The current page number of the plugins list table.
 */
function ddw_cpi_installer_tab_topics( $page = 1 ) {

	/** Include "Topics" tab functions */
	require_once( CLPINST_PLUGIN_DIR . 'includes/cpi-functions-tab-topics.php' );

	if ( in_array( get_locale(), array( 'de_DE', 'de_AT', 'de_CH', 'de_LU', 'gsw' ) ) ) {

		require_once( CLPINST_PLUGIN_DIR . 'includes/cpi-functions-de.php' );

	}  // end if

	do_action( 'ddw_cpi_plugin_installer_topics' );

}  // end function


add_action( 'ddw_cpi_plugin_installer_topics', 'ddw_cpi_topics_tab_content' );
/**
 * Build the "Topics" tab content.
 *    Includes all default lists by this plugin, and their appropriate functions.
 *    See plugin file "cpi-functions-tab-topics.php" for all topic functions.
 *
 * @since 1.0.0
 *
 * @uses  ddw_cpi_topic_{content-type}() Render title for tag lists.
 * @uses  ddw_cpi_topics_tab_content_disclaimer() To display block of content.
 * @uses  ddw_cpi_topics_tab_content_type_advise() To display block of content.
 */
function ddw_cpi_topics_tab_content() {

	/** Load our admin body class functionality */
	add_filter( 'admin_body_class', 'ddw_cpi_add_admin_body_class' );

	/** All collections, filterable */
	$collections = apply_filters(
		'cpi_filter_topic_tag_collections',
		array(
			'content_editor' => array(
				'title'    => _x( 'Content/ Editor', 'Topic tags collection title', 'cleaner-plugin-installer' ),
				'function' => ddw_cpi_topic_content_editor(),
			),
			'post_types' => array(
				'title'    => _x( 'Post Types/ Custom Taxonomies/ Custom Fields', 'Topic tags collection title', 'cleaner-plugin-installer' ),
				'function' => ddw_cpi_topic_post_types(),
			),
			'media' => array(
				'title'    => _x( 'Media/ Gallery/ Video', 'Topic tags collection title', 'cleaner-plugin-installer' ),
				'function' => ddw_cpi_topic_media(),
			),
			'tools' => array(
				'title'    => _x( 'Tools, Helpers', 'Topic tags collection title', 'cleaner-plugin-installer' ),
				'function' => ddw_cpi_topic_tools(),
			),
			'multisite' => array(
				'title'    => _x( 'Multisite/ Network', 'Topic tags collection title', 'cleaner-plugin-installer' ),
				'function' => ddw_cpi_topic_multisite(),
			),
			'ecommerce' => array(
				'title'    => _x( 'E-Commerce/ Shop Plugins/ Digital Products', 'Topic tags collection title', 'cleaner-plugin-installer' ),
				'function' => ddw_cpi_topic_ecommerce(),
			),
			'forms' => array(
				'title'    => _x( 'Contact Forms/ Form Builders', 'Topic tags collection title', 'cleaner-plugin-installer' ),
				'function' => ddw_cpi_topic_forms(),
			),
			'community_forum' => array(
				'title'    => _x( 'Community/ Forum', 'Topic tags collection title', 'cleaner-plugin-installer' ),
				'function' => ddw_cpi_topic_community_forum(),
			),
			'social' => array(
				'title'    => _x( 'Social/ Sharing', 'Topic tags collection title', 'cleaner-plugin-installer' ),
				'function' => ddw_cpi_topic_social(),
			),
			'membership' => array(
				'title'    => _x( 'Membership/ Restrict Content', 'Topic tags collection title', 'cleaner-plugin-installer' ),
				'function' => ddw_cpi_topic_membership(),
			),
			'multilingual' => array(
				'title'    => _x( 'Multilingual/ Translations', 'Topic tags collection title', 'cleaner-plugin-installer' ),
				'function' => ddw_cpi_topic_multilingual(),
			),
			'security_backup' => array(
				'title'    => _x( 'Security/ Backup', 'Topic tags collection title', 'cleaner-plugin-installer' ),
				'function' => ddw_cpi_topic_security_backup(),
			),
			'themes' => array(
				'title'    => _x( 'Themes', 'Topic tags collection title', 'cleaner-plugin-installer' ),
				'function' => ddw_cpi_topic_themes(),
			),
			'developer' => array(
				'title'    => _x( 'Developer', 'Topic tags collection title', 'cleaner-plugin-installer' ),
				'function' => ddw_cpi_topic_developer(),
			),
			'special_tags' => array(
				'title'    => _x( 'Special Tags', 'Topic tags collection title', 'cleaner-plugin-installer' ),
				'function' => ddw_cpi_topic_special_tags(),
			),
		)
	);

	echo '<div class="cpi-block cpi-tab-topics">';
		echo '<div class="cpi-topics-intro">';
		echo '<h4 class="description">' . __( 'Curated List of Tags for Lots of Plugin Topics, Use Cases etc.', 'cleaner-plugin-installer' ) . '</h4>';
			/** Disclaimer & advise info (hide on Slim Mode) */
			if ( ! ddw_cpi_is_slim() ) {
				ddw_cpi_topics_tab_content_disclaimer();
				ddw_cpi_topics_tab_content_type_advise();
			}
		echo '</div>';

	echo '<div class="cpi-topics-group">';

	$type_default = apply_filters( 'cpi_filter_default_search_type_selector', 'tag' );

	/** Finally render our topic tags collections list */
	foreach ( (array) $collections as $collection => $collection_args ) {

		/** Sets the type of search for each list, fallback to "tag" if empty */
		$type = ( isset( $collection_args[ 'type' ] ) && ! empty( $collection_args[ 'type' ] ) ) ? sanitize_key( $collection_args[ 'type' ] ) : sanitize_key( $type_default );

		/** Further sanitizing the search type, only 3 alternatives possible! */
		$type = ( in_array( $type, array( 'term', 'author', 'tag' ) ) ) ? $type : sanitize_key( $type_default );

		echo ddw_cpi_render_topic_tags(
			$collection_args[ 'title' ],
			$collection_args[ 'function' ],
			$type
		);

	}  // end foreach

	echo '</div>';	// end .cpi-topics-group

	echo '</div>';	// end .cpi-block .cpi-tab-topics

}  // end function


add_action( 'install_plugins_collections', 'ddw_cpi_installer_tab_collections', 10, 1 );
/**
 * Add special tab "Collections" to display info and action links for
 *    "WPCore/WpFavs Plugin Managers" base plugins (third-party).
 *    Set our own action hook for easily addting content.
 *
 * @since 1.0.0
 *
 * @param string $page The current page number of the plugins list table.
 */
function ddw_cpi_installer_tab_collections( $page = 1 ) {

	do_action( 'ddw_cpi_plugin_installer_collections' );

}  // end function


add_action( 'ddw_cpi_plugin_installer_collections', 'ddw_cpi_collections_tab_content' );
/**
 * Build content for Collections tab.
 *    Conditionally for active/ inactive "WPCore"/"WpFavs" plugins.
 *
 * @since 1.0.0
 *
 * @uses  ddw_cpi_info_values()
 * @uses  ddw_cpi_collections_provider()
 * @uses  ddw_cpi_plugin_install_link()
 * @uses  ddw_cpi_collections_tab_content_disclaimer()
 */
function ddw_cpi_collections_tab_content() {

	/** Load our info values, plus detect supported plugin provider */
	$cpi_info = (array) ddw_cpi_info_values();
	$provider = ddw_cpi_collections_provider();

	if ( 'none' === $provider ) {

		$provider = 'wpcore';

		$install_link_label = sprintf(
			__( 'Install + activate the %s', 'cleaner-plugin-installer' ),
			$cpi_info[ 'provider_' . $provider ][ 'name' ]
		);

		add_action( 'admin_enqueue_scripts', 'add_thickbox' );

		echo '<div class="cpi-block cpi-tab-collections">';
			echo '<h3>' . __( 'Would You Like Having Your Own Plugin Collections, plus Bulk Installing?', 'cleaner-plugin-installer' ) . '</h3>';
			echo '<p><strong>' . __( '&hellip; so are we!', 'cleaner-plugin-installer' ) . ' ;-)</strong></p>';

			/** First column */
			echo '<div class="one-half first">';

				echo '<p>' . sprintf(
					__( 'Free and GPL-licensed third-party plugin %s just manages to do this.', 'cleaner-plugin-installer' ),
					'&#x0022;' . $cpi_info[ 'provider_' . $provider ][ 'name' ] . '&#x0022;'
				) . '</p>';

				echo '<p>' . __( 'Follow these 2 steps to use it', 'cleaner-plugin-installer' ) . ':</p>';
				echo '<p><a class="button-primary" href="' . esc_url( $cpi_info[ 'provider_' . $provider ][ 'url_start' ] ) . '" target="_new"><i class="cpi-arrow-legend"></i> ' . sprintf(
						__( 'Create Collections at %s', 'cleaner-plugin-installer' ),
						$cpi_info[ 'provider_' . $provider ][ 'label' ]
					) . '</a><br />' . __( 'Create a 1 or more collections (private and/ or public)', 'cleaner-plugin-installer' ) . '</p>';
				echo '<p>' . ddw_cpi_plugin_install_link(
					$cpi_info[ 'provider_' . $provider ][ 'slug' ],
					'<i class="cpi-arrow-legend"></i> ' . $install_link_label,
					$cpi_info[ 'provider_' . $provider ][ 'short' ],
					'button-primary thickbox'
				) . '</p>';

			echo '</div>';

			/** Second column */
			echo '<div class="one-half">';

			/** Disclaimer info (hide on Slim Mode) */
			if ( ! ddw_cpi_is_slim() ) {
				ddw_cpi_collections_tab_content_disclaimer(
					__( 'Please Note', 'cleaner-plugin-installer' )
				);
			}

			echo '</div>';
			echo '<div class="clear"></div>';
		echo '</div>';

	} else {

		echo '<div class="cpi-block cpi-tab-collections">';
			echo '<h3>' . sprintf(
				__( '%s Plugin Collections, plus Bulk Installing', 'cleaner-plugin-installer' ) . '</h3>',
				$cpi_info[ 'provider_' . $provider ][ 'short' ]
			);
			echo '<p>' . __( 'Manage Your favorite plugins more easily and efficiently!', 'cleaner-plugin-installer' ) . '</p>';

			/** First column */
			echo '<div class="one-half first">';

				echo '<p><a class="button-primary" href="' . admin_url( $cpi_info[ 'provider_' . $provider ][ 'url_admin' ] ) . '"><i class="cpi-arrow-legend"></i> '. __( 'Install plugins from Your collections', 'cleaner-plugin-installer' ) . '</a><br />' . __( 'plus, connect/ remove collections', 'cleaner-plugin-installer' ) . '</p>';
				echo '<p><a class="button-primary" href="' . esc_url( $cpi_info[ 'provider_' . $provider ][ 'url_browse' ] ) . '" target="_new"><i class="cpi-arrow-legend"></i> ' . __( 'Manage Your private & public plugin collections', 'cleaner-plugin-installer' ) . '</a><br />' . sprintf(
						__( 'via %s', 'cleaner-plugin-installer' ) . '</p>',
						$cpi_info[ 'provider_' . $provider ][ 'label' ]
					);

			echo '</div>';

			/** Second column */
			echo '<div class="one-half">';

			/** Disclaimer info (hide on Slim Mode) */
			if ( ! ddw_cpi_is_slim() ) {
				ddw_cpi_collections_tab_content_disclaimer(
					__( 'Please Note', 'cleaner-plugin-installer' )
				);
			}

			echo '</div>';
			echo '<div class="clear"></div>';
		echo '</div>';

	}  // end if

}  // end function


/**
 * Helper function for displaying Topics tab disclaimer content.
 *
 * @since  1.0.0
 *
 * @param  bool $echo For echoing or returning the output.
 *
 * @return string $output Echoing or returing string with markup.
 */
function ddw_cpi_topics_tab_content_disclaimer( $echo = TRUE ) {

	$output = '<p class="description">' . sprintf(
			__( 'Manually curated tag lists for a lot of plugin types, use cases and popular plugin solutions. Listing here maintained by David Decker (plugin author of %s). The tags itself are from plugin\'s readme header.', 'cleaner-plugin-installer' ),
			'"' . __( 'Cleaner Plugin Installer', 'cleaner-plugin-installer' ) . '"'
		) . '</p>';

	/** Render/ return output */
	if ( $echo ) {

		echo $output;

	} else {

		return $output;

	}  // end if

}  // end function


/**
 * Helper function for displaying Topics tab search type advise.
 *
 * @since  1.2.1
 *
 * @param  bool $echo For echoing or returning the output.
 *
 * @return string $output Echoing or returing string with markup.
 */
function ddw_cpi_topics_tab_content_type_advise( $echo = TRUE ) {

	$output = '<p class="description">' . sprintf(
			/* Translators: 1 = Screen Options / 2 = tag / 3 = keyword (term) */
			'<i class="cpi-arrow-advise"></i>' . __( 'Via %1$s: Optionally switch the search type from %2$s to %3$s.', 'cleaner-plugin-installer' ),
			'&raquo;' . __( 'Screen Options', 'cleaner-plugin-installer' ) . '&laquo;',
			'<em>' . __( 'tag', 'cleaner-plugin-installer' ) . '</em>',
			'<em>' . __( 'keyword (term)', 'cleaner-plugin-installer' ) . '</em>'
		) . '</p>';

	/** Render/ return output */
	if ( $echo ) {

		echo $output;

	} else {

		return $output;

	}  // end if

}  // end function


/**
 * Helper function for displaying Collections tab disclaimer content.
 *
 * @since  1.0.0
 *
 * @uses   ddw_cpi_info_values()
 * @uses   ddw_cpi_collections_provider()
 *
 * @param  string $title Title string for section.
 * @param  bool   $echo  For echoing or returning the output.
 *
 * @return string $output Echoing or returing string with markup.
 */
function ddw_cpi_collections_tab_content_disclaimer( $title = '', $echo = TRUE ) {

	$cpi_info = (array) ddw_cpi_info_values();
	$provider = ( 'none' !== ddw_cpi_collections_provider() ) ? ddw_cpi_collections_provider() : 'wpcore';

	/** Build output */
	$output = '<p class="description"><strong>' . esc_attr( $title ) . '</strong></p>';
	$output .= '<p class="description">&raquo;' . sprintf(
		__( 'I am NOT affiliated with %1$s in any way, other than that, being a normal user of their service & plugin. %1$s is a community effort aiming to make some things a bit easier for a lot of administrators and webmasters.', 'cleaner-plugin-installer' ),
			'&#x0022;' . $cpi_info[ 'provider_' . $provider ][ 'short' ] . '&#x0022;'
	) . '&laquo;</p>';
	$output .= '<p class="description"><cite>&mdash; ' . sprintf(
			__( 'David Decker, author of %s plugin', 'cleaner-plugin-installer' ),
			'&#x0022;' . __( 'Cleaner Plugin Installer', 'cleaner-plugin-installer' ) . '&#x0022;'
		) . '</cite></p>';

	/** Render/ return output */
	if ( $echo ) {

		echo $output;

	} else {

		return $output;

	}  // end if

}  // end function


/**
 * Include needed functions for screen options.
 */
include_once( CLPINST_PLUGIN_DIR . 'includes/cpi-functions-screen-options.php' );

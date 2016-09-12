<?php
/**
 * Helper functions for the "Topics" tab.
 *
 * @package    Cleaner Plugin Installer
 * @subpackage Topics Tab Functions
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
 * Build a plugin tag list/cloud output using native WordPress functionality.
 *
 * NOTE: WP's tag cloud function is used for link building here only (not cloud
 *       building), therefore "counter" parameter not needed and fake number
 *       only passed for compatibility reasons!
 *
 * @since  1.0.0
 *
 * @uses   self_admin_url()
 * @uses   sanitize_title_with_dashes()
 * @uses   wp_generate_tag_cloud()
 *
 * @param  array  $topic_tags_array Array of plugin tags.
 * @param  string $type             Key string for type of search (term, tag, author)
 *
 * @return object Tag cloud for plugin tags.
 */
function ddw_cpi_generate_topic_links( $topic_tags_array, $type ) {

	/** Set as array */
	$tags = array();

	/** Prepare type */
	$type = ( isset( $type ) && ! empty( $type ) ) ? $type : 'tag';

	/** Get parameters for each tag */
	foreach ( (array) $topic_tags_array as $tag ) {

		if ( version_compare( $GLOBALS[ 'wp_version' ], '4.5.999', '>=' ) ) {

			/** WP 4.6+ */
			$url = self_admin_url( 'plugin-install.php?tab=search&type=' . sanitize_key( $type ) . '&s=' . urlencode( $tag[ 'slug' ] ) );
			$data = array(
				'link'  => esc_url( $url ),
				'name'  => $tag[ 'name' ],
				'slug'  => $tag[ 'slug' ],
				'id'    => sanitize_title_with_dashes( $tag[ 'name' ] ),	//$tag[ 'name' ] ),
				'count' => 20,  // Not real, just to pass any number as count...
			);  // end array

			$tags[ $tag[ 'name' ] ] = (object) $data;

		} else {

			/** WP 4.5.x or lower */
			$tags[ $tag[ 'name' ] ] = (object) array(
				'link'  => esc_url( self_admin_url( 'plugin-install.php?tab=search&type=' . sanitize_key( $type ) . '&s=' . urlencode( $tag[ 'slug' ] ) ) ),
				'name'  => $tag[ 'name' ],
				'id'    => sanitize_title_with_dashes( $tag[ 'name' ] ),	//$tag[ 'name' ] ),
				'count' => 20,  // Not real, just to pass any number as count...
			);  // end array

		}  // end if


	}  // end foreach

	/** Title attribute string */
	$title_attribute = esc_html_x( 'A lot of plugins', 'Title attribute', 'cleaner-plugin-installer' );

	/** Render topic tag out, using native WordPress functionality */
	return wp_generate_tag_cloud(
		$tags,
		apply_filters(
			'cpi_filter_topic_tag_cloud_args',
			array(
				'single_text'   => $title_attribute,
				'multiple_text' => $title_attribute,
				'separator'     => ' | ',
				'smallest'      => 14,
				'largest'       => 14,
				'unit'          => 'px',
			)
		)
	);

}  // end function


/**
 * Helper function for rendering a certain topic tags collection.
 *
 * @since  1.0.0
 *
 * @param  string $topic_title
 * @param  obj    $topic_tags
 * @param  string $type
 *
 * @return string $topic_part Markup for a topic part/ tags list.
 */
function ddw_cpi_render_topic_tags( $topic_title, $topic_tags, $type ) {

	/** Building the HTML presentation <br class="clear" /> */
	$topic_part = sprintf(
		'<div class="cpi-topic"><h3>%s</h3><div class="cpi-topic-tags">%s</div></div>',
		esc_attr( $topic_title ),
		ddw_cpi_generate_topic_links( $topic_tags, $type )
	);

	/** Returning topic part output */
	return $topic_part;

}  // end function


/**
 * Tags list for Ecommerce.
 *
 * @since  1.0.0
 *
 * @return array Array of plugin tags.
 */
function ddw_cpi_topic_ecommerce() {

	return apply_filters(
		'cpi_filter_topic_tags_ecommerce',
		array(
			'ecommerce' => array(
				'name' => 'Ecommerce',
				'slug' => 'ecommerce',
			),
			'e_commerce' => array(
				'name' => 'E-Commerce',
				'slug' => 'e-commerce',
			),
			'shop' => array(
				'name' => 'Shop',
				'slug' => 'shop',
			),
			'woocommerce' => array(
				'name' => 'WooCommerce',
				'slug' => 'woocommerce',
			),
			'easy_digital_downloads' => array(
				'name' => 'Easy Digital Downloads',
				'slug' => 'easy-digital-downloads',
			),
			'edd' => array(
				'name' => 'EDD',
				'slug' => 'edd',
			),
			'jigoshop' => array(
				'name' => 'Jigoshop',
				'slug' => 'jigoshop',
			),
			'shopp' => array(
				'name' => 'Shopp',
				'slug' => 'shopp',
			),
			'marketpress' => array(
				'name' => 'Marketpress',
				'slug' => 'marketpress',
			),
			'cart66' => array(
				'name' => 'Cart66',
				'slug' => 'cart66',
			),
			'wp_e_commerce' => array(
				'name' => 'WP e-Commerce',
				'slug' => 'wp-e-commerce',
			),
			'wpec' => array(
				'name' => 'WPEC',
				'slug' => 'wpec',
			),
			'payment_gateway' => array(
				'name' => 'Payment Gateway',
				'slug' => 'payment-gateway',
			),
			'shipping' => array(
				'name' => 'Shipping',
				'slug' => 'shipping',
			),
			'coupons' => array(
				'name' => 'Coupons',
				'slug' => 'coupons',
			),
			'digital_products' => array(
				'name' => 'Digital Products',
				'slug' => 'digital-products',
			),
			'products' => array(
				'name' => 'Products',
				'slug' => 'products',
			),
		)
	);

}  // end function


/**
 * Tags list for Contact Forms/ Form Builders.
 *
 * @since  1.0.0
 *
 * @return array Array of plugin tags.
 */
function ddw_cpi_topic_forms() {

	return apply_filters(
		'cpi_filter_topic_tags_forms',
		array(
			'contact-form' => array(
				'name' => 'Contact Form',
				'slug' => 'contact-form',
			),
			'forms' => array(
				'name' => 'Forms',
				'slug' => 'forms',
			),
			'gravity_forms' => array(
				'name' => 'Gravity Forms',
				'slug' => 'gravity-forms',
			),
			'ninja_forms' => array(
				'name' => 'Ninja Forms',
				'slug' => 'ninja-forms',
			),
			'formidable' => array(
				'name' => 'Formidable',
				'slug' => 'formidable',
			),
			'contactform7' => array(
				'name' => 'Contact Form 7',
				'slug' => 'contact-form-7',
			),
			'cf7' => array(
				'name' => 'CF7',
				'slug' => 'cf7',
			),
			'form_builder' => array(
				'name' => 'Form Builder',
				'slug' => 'form-builder',
			),
		)
	);

}  // end function


/**
 * Tags list for Content, Editor etc..
 *
 * @since  1.0.0
 *
 * @return array Array of plugin tags.
 */
function ddw_cpi_topic_content_editor() {

	return apply_filters(
		'cpi_filter_topic_tags_content_editor',
		array(
			'posts' => array(
				'name' => 'Posts',
				'slug' => 'posts',
			),
			'pages' => array(
				'name' => 'Pages',
				'slug' => 'pages',
			),
			'portfolio' => array(
				'name' => 'Portfolio',
				'slug' => 'portfolio',
			),
			'widgets' => array(
				'name' => 'Widgets',
				'slug' => 'widgets',
			),
			'widget' => array(
				'name' => 'Widget',
				'slug' => 'widget',
			),
			'widget_only' => array(
				'name' => 'Widget Only',
				'slug' => 'widget-only',
			),
			'sidebars' => array(
				'name' => 'Sidebars',
				'slug' => 'sidebar',
			),
			'sidebar' => array(
				'name' => 'Sidebar',
				'slug' => 'sidebar',
			),
			'page_builder' => array(
				'name' => 'Page Builder',
				'slug' => 'page-builder',
			),
			'editor' => array(
				'name' => 'Editor',
				'slug' => 'editor',
			),
			'tinymce' => array(
				'name' => 'TinyMCE',
				'slug' => 'tinymce',
			),
			'visual_editor' => array(
				'name' => 'Visual Editor',
				'slug' => 'visual-editor',
			),
			'templates' => array(
				'name' => 'Templates',
				'slug' => 'templates',
			),
			'copyright' => array(
				'name' => 'Copyright',
				'slug' => 'copyright',
			),
			'footnotes' => array(
				'name' => 'Footnotes',
				'slug' => 'footnotes',
			),
			'publishing' => array(
				'name' => 'Publishing',
				'slug' => 'publishing',
			),
		)
	);

}  // end function


/**
 * Tags list for Special Tags.
 *
 * @since  1.0.0
 *
 * @return array Array of plugin tags.
 */
function ddw_cpi_topic_special_tags() {

	return apply_filters(
		'cpi_filter_topic_tags_special',
		array(
			'adopt_me' => array(
				'name' => 'Adopt Me',
				'slug' => 'adopt-me',
			),
			'widget_only' => array(
				'name' => 'Widget Only',
				'slug' => 'widget-only',
			),
			'beta_test' => array(
				'name' => 'Beta',
				'slug' => 'beta',
			),
			'wordcamp' => array(
				'name' => 'WordCamp',
				'slug' => 'wordcamp',
			),
			'camptix' => array(
				'name' => 'CampTix',
				'slug' => 'camptix',
			),
			'meetup' => array(
				'name' => esc_html_x( 'Meetup', 'Plugin tag name', 'cleaner-plugin-installer' ),
				'slug' => 'meetup',
			),
			'core' => array(
				'name' => 'Core',
				'slug' => 'core',
			),
			'hello_dolly' => array(
				'name' => 'Hello Dolly',
				'slug' => 'hello-dolly',
			),
		)
	);

}  // end function


/**
 * Tags list for Post Types, Custom Fields etc..
 *
 * @since  1.0.0
 *
 * @return array Array of plugin tags.
 */
function ddw_cpi_topic_post_types() {

	return apply_filters(
		'cpi_filter_topic_tags_post_types',
		array(
			'post_type' => array(
				'name' => 'Post Type',
				'slug' => 'post-type',
			),
			'custom_post_types' => array(
				'name' => 'Custom Post Types',
				'slug' => 'custom-post-types',
			),
			'custom_fields' => array(
				'name' => 'Custom Fields',
				'slug' => 'custom-fields',
			),
			'metaboxes' => array(
				'name' => 'Metaboxes',
				'slug' => 'metaboxes',
			),
			'advanced_custom_fields' => array(
				'name' => 'Advanced Custom Fields',
				'slug' => 'advanced-custom-fields',
			),
			'acf' => array(
				'name' => 'ACF',
				'slug' => 'acf',
			),
			'content_types' => array(
				'name' => 'Content Types',
				'slug' => 'content-types',
			),
			'pods' => array(
				'name' => 'Pods',
				'slug' => 'pods',
			),
			'custom_taxonomies' => array(
				'name' => 'Custom Taxonomies',
				'slug' => 'custom-taxonomies',
			),
		)
	);

}  // end function


/**
 * Tags list for Multisite.
 *
 * @since  1.0.0
 *
 * @return array Array of plugin tags.
 */
function ddw_cpi_topic_multisite() {

	return apply_filters(
		'cpi_filter_topic_tags_multisite',
		array(
			'Multisite' => array(
				'name' => 'Multisite',
				'slug' => 'multisite',
			),
			'network' => array(
				'name' => 'Network',
				'slug' => 'network',
			),
			'blog_network' => array(
				'name' => 'Blog Network',
				'slug' => 'blog-network',
			),
			'wpmu' => array(
				'name' => 'WPMU',
				'slug' => 'wpmu',
			),
			'migration' => array(
				'name' => 'Migration',
				'slug' => 'migration',
			),
			'cloning' => array(
				'name' => 'Cloning',
				'slug' => 'cloning',
			),
			'sub_site' => array(
				'name' => 'Sub Site',
				'slug' => 'sub-site',
			),
			'domain_mapping' => array(
				'name' => 'Domain Mapping',
				'slug' => 'domain-mapping',
			),
		)
	);

}  // end function


/**
 * Tags list for Membership.
 *
 * @since  1.0.0
 *
 * @return array Array of plugin tags.
 */
function ddw_cpi_topic_membership() {

	return apply_filters(
		'cpi_filter_topic_tags_membership',
		array(
			'membership' => array(
				'name' => 'Membership',
				'slug' => 'membership',
			),
			's2member' => array(
				'name' => 's2Member',
				'slug' => 's2member',
			),
			'paid_memberships_pro' => array(
				'name' => 'Paid Memberships Pro',
				'slug' => 'paid-memberships-pro',
			),
			'restrict_content' => array(
				'name' => 'Restrict Content',
				'slug' => 'restrict-content',
			),
			'drip_content' => array(
				'name' => 'Drip Content',
				'slug' => 'drip-content',
			),
		)
	);

}  // end function


/**
 * Tags list for Community & Forum.
 *
 * @since  1.0.0
 *
 * @return array Array of plugin tags.
 */
function ddw_cpi_topic_community_forum() {

	return apply_filters(
		'cpi_filter_topic_tags_community_forum',
		array(
			'buddypress' => array(
				'name' => 'BuddyPress',
				'slug' => 'buddypress',
			),
			'bbpress' => array(
				'name' => 'bbPress',
				'slug' => 'bbpress',
			),
			'forum' => array(
				'name' => 'Forum',
				'slug' => 'forum',
			),
			'community' => array(
				'name' => 'Community',
				'slug' => 'community',
			),
			'discussion' => array(
				'name' => 'Discussion',
				'slug' => 'discussion',
			),
			'board' => array(
				'name' => 'Board',
				'slug' => 'board',
			),
			'user_profiles' => array(
				'name' => 'User Profiles',
				'slug' => 'user-profiles',
			),
		)
	);

}  // end function


/**
 * Tags list for Media, Gallery, Video.
 *
 * @since  1.0.0
 *
 * @return array Array of plugin tags.
 */
function ddw_cpi_topic_media() {

	return apply_filters(
		'cpi_filter_topic_tags_media',
		array(
			'media' => array(
				'name' => 'Media',
				'slug' => 'media',
			),
			'gallery' => array(
				'name' => 'Gallery',
				'slug' => 'gallery',
			),
			'video' => array(
				'name' => 'Video',
				'slug' => 'video',
			),
			'media_library' => array(
				'name' => 'Media Library',
				'slug' => 'media-library',
			),
			'images' => array(
				'name' => 'Images',
				'slug' => 'images',
			),
			'pictures' => array(
				'name' => 'Pictures',
				'slug' => 'pictures',
			),
			'youtube' => array(
				'name' => 'YouTube',
				'slug' => 'youtube',
			),
			'vimeo' => array(
				'name' => 'Vimeo',
				'slug' => 'vimeo',
			),
			'lightbox' => array(
				'name' => 'Lightbox',
				'slug' => 'lightbox',
			),
			'nextgen' => array(
				'name' => 'NextGen',
				'slug' => 'nextgen',
			),
			'oembed' => array(
				'name' => 'oEmbed',
				'slug' => 'oembed',
			),
			'pinterest' => array(
				'name' => 'Pinterest',
				'slug' => 'pinterest',
			),
			'instagram' => array(
				'name' => 'Instagram',
				'slug' => 'instagram',
			),
			'flickr' => array(
				'name' => 'Flickr',
				'slug' => 'flickr',
			),
		)
	);

}  // end function


/**
 * Tags list for Social.
 *
 * @since  1.0.0
 *
 * @return array Array of plugin tags.
 */
function ddw_cpi_topic_social() {

	return apply_filters(
		'cpi_filter_topic_tags_social',
		array(
			'social' => array(
				'name' => 'Social',
				'slug' => 'social',
			),
			'sharing' => array(
				'name' => 'Sharing',
				'slug' => 'sharing',
			),
			'social_sharing' => array(
				'name' => 'Social Sharing',
				'slug' => 'social-sharing',
			),
			'jetpack' => array(
				'name' => 'Jetpack',
				'slug' => 'jetpack',
			),
			'twitter' => array(
				'name' => 'Twitter',
				'slug' => 'twitter',
			),
			'facebook' => array(
				'name' => 'Facebook',
				'slug' => 'facebook',
			),
			'googleplus' => array(
				'name' => 'Google Plus',
				'slug' => 'google-plus',
			),
			'pinterest' => array(
				'name' => 'Pinterest',
				'slug' => 'pinterest',
			),
			'instagram' => array(
				'name' => 'Instagram',
				'slug' => 'instagram',
			),
		)
	);

}  // end function


/**
 * Tags list for Security & Backup.
 *
 * @since  1.0.0
 *
 * @return array Array of plugin tags.
 */
function ddw_cpi_topic_security_backup() {

	return apply_filters(
		'cpi_filter_topic_tags_security_backup',
		array(
			'security' => array(
				'name' => 'Security',
				'slug' => 'security',
			),
			'backup' => array(
				'name' => 'Backup',
				'slug' => 'backup',
			),
			'sucuri' => array(
				'name' => 'Sucuri',
				'slug' => 'sucuri',
			),
			'antivirus' => array(
				'name' => 'Antivirus',
				'slug' => 'antivirus',
			),
			'antispam' => array(
				'name' => 'Antispam',
				'slug' => 'antispam',
			),
			'akismet' => array(
				'name' => 'Akismet',
				'slug' => 'akismet',
			),
			'activity_log' => array(
				'name' => 'Activity Log',
				'slug' => 'activity-log',
			),
			'wordfence' => array(
				'name' => 'WordFence',
				'slug' => 'wordfence',
			),
			'logging' => array(
				'name' => 'Logging',
				'slug' => 'logging',
			),
		)
	);

}  // end function


/**
 * Tags list for Tools.
 *
 * @since  1.0.0
 *
 * @return array Array of plugin tags.
 */
function ddw_cpi_topic_tools() {

	return apply_filters(
		'cpi_filter_topic_tags_tools',
		array(
			'export' => array(
				'name' => 'Export',
				'slug' => 'export',
			),
			'import' => array(
				'name' => 'Import',
				'slug' => 'import',
			),
			'settings_import' => array(
				'name' => 'Settings Import',
				'slug' => 'settings-import',
			),
			'settings_export' => array(
				'name' => 'Settings Export',
				'slug' => 'settings-export',
			),
			'database' => array(
				'name' => 'Database',
				'slug' => 'database',
			),
			'mysql' => array(
				'name' => 'MySQL',
				'slug' => 'mysql',
			),
			'administrator' => array(
				'name' => 'Administrator',
				'slug' => 'administrator',
			),
			'widget_settings' => array(
				'name' => 'Widget Settings',
				'slug' => 'widget-settings',
			),
			'super_admin' => array(
				'name' => 'Super Admin',
				'slug' => 'super-admin',
			),
			'toolbar' => array(
				'name' => 'Toolbar',
				'slug' => 'toolbar',
			),
			'admin_color_scheme' => array(
				'name' => 'Admin Color Scheme',
				'slug' => 'admin-color-scheme',
			),
			'cache' => array(
				'name' => 'Cache',
				'slug' => 'cache',
			),
		)
	);

}  // end function


/**
 * Tags list for Multilingual & Translations.
 *
 * @since  1.0.0
 *
 * @return array Array of plugin tags.
 */
function ddw_cpi_topic_multilingual() {

	return apply_filters(
		'cpi_filter_topic_tags_multilingual',
		array(
			'multilingual' => array(
				'name' => 'Multilingual',
				'slug' => 'multilingual',
			),
			'multilingual_press' => array(
				'name' => 'Multilingual Press',
				'slug' => 'multilingual-press',
			),
			'wpml' => array(
				'name' => 'WPML',
				'slug' => 'wpml',
			),
			'translation' => array(
				'name' => 'Translation',
				'slug' => 'translation',
			),
			'internationalization' => array(
				'name' => 'Internationalization',
				'slug' => 'internationalization',
			),
			'localization' => array(
				'name' => 'Localization',
				'slug' => 'localization',
			),
			'i18n' => array(
				'name' => 'i18n',
				'slug' => 'i18n',
			),
			'l10n' => array(
				'name' => 'L10n',
				'slug' => 'l10n',
			),
			'translate' => array(
				'name' => 'Translate',
				'slug' => 'translate',
			),
			'polylang' => array(
				'name' => 'Polylang',
				'slug' => 'polylang',
			),
			'qtranslate' => array(
				'name' => 'qTranslate',
				'slug' => 'qtranslate',
			),
			'language_switcher' => array(
				'name' => 'Language Switcher',
				'slug' => 'language-switcher',
			),
		)
	);

}  // end function


/**
 * Tags list for Developers.
 *
 * @since  1.0.0
 *
 * @return array Array of plugin tags.
 */
function ddw_cpi_topic_developer() {

	return apply_filters(
		'cpi_filter_topic_tags_developer',
		array(
			'developer' => array(
				'name' => 'Developer',
				'slug' => 'developer',
			),
			'database' => array(
				'name' => 'Database',
				'slug' => 'database',
			),
			'mysql' => array(
				'name' => 'MySQL',
				'slug' => 'mysql',
			),
			'server' => array(
				'name' => 'Server',
				'slug' => 'server',
			),
			'nginx' => array(
				'name' => 'Nginx',
				'slug' => 'nginx',
			),
			'apache' => array(
				'name' => 'Apache',
				'slug' => 'apache',
			),
			'debug' => array(
				'name' => 'Debug',
				'slug' => 'debug',
			),
			'debug_bar' => array(
				'name' => 'Debug Bar',
				'slug' => 'debug-bar',
			),
			'transients' => array(
				'name' => 'Transients',
				'slug' => 'transients',
			),
			'deprecated' => array(
				'name' => 'Deprecated',
				'slug' => 'deprecated',
			),
			'staging' => array(
				'name' => 'Staging',
				'slug' => 'staging',
			),
			'migration' => array(
				'name' => 'Migration',
				'slug' => 'migration',
			),
			'database_migration' => array(
				'name' => 'Database Migration',
				'slug' => 'database-migration',
			),
			'cloning' => array(
				'name' => 'Cloning',
				'slug' => 'cloning',
			),
			'htaccess' => array(
				'name' => '.htaccess',
				'slug' => 'htaccess',
			),
			'php' => array(
				'name' => 'PHP',
				'slug' => 'php',
			),
			'json' => array(
				'name' => 'JSON',
				'slug' => 'json',
			),
			'rest_api' => array(
				'name' => 'REST-API',
				'slug' => 'rest-api',
			),
			'dev_theme_development' => array(
				'name' => 'Theme Development',
				'slug' => 'theme-development',
			),
			'object_cache' => array(
				'name' => 'Object Cache',
				'slug' => 'object-cache',
			),
		)
	);

}  // end function


/**
 * Tags list for Themes.
 *
 * @since  1.1.0
 *
 * @return array Array of plugin tags.
 */
function ddw_cpi_topic_themes() {

	return apply_filters(
		'cpi_filter_topic_tags_themes',
		array(
			'genesis' => array(
				'name' => esc_html_x( 'Genesis', 'Plugin tag name', 'cleaner-plugin-installer' ),
				'slug' => 'genesis',
			),
			'themes' => array(
				'name' => 'Themes',
				'slug' => 'themes',
			),
			'default_theme' => array(
				'name' => 'Default Theme',
				'slug' => 'default-theme',
			),
			'theme_options' => array(
				'name' => 'Theme Options',
				'slug' => 'theme-options',
			),
			'the_customizer' => array(
				'name' => 'Customizer',
				'slug' => 'customizer',
			),
			'theme_development' => array(
				'name' => 'Theme Development',
				'slug' => 'theme-development',
			),
			'twitter_bootstrap' => array(
				'name' => '(Twitter) Bootstrap',
				'slug' => 'bootstrap',
			),
		)
	);

}  // end function

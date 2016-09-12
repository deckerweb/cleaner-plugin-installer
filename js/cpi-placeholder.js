/**
 * Placeholder & button texts replacements.
 *
 * @package    Cleaner Plugin Installer
 * @subpackage JavaScript & jQuery
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2014-2016, David Decker - DECKERWEB
 * @license    http://www.opensource.org/licenses/gpl-license.php GPL-2.0+
 * @link       http://genesisthemes.de/en/wp-plugins/cleaner-plugin-installer/
 * @link       http://deckerweb.de/twitter
 *
 * @since      1.1.1
 */

jQuery(document).ready(function($){

	$('form').find("input.wp-filter-search").each(function(ev){
		if(!$(this).val()) {
			$(this).attr("placeholder", cpi_input.text_placeholder);
		}
	});

	$('input.button.screen-reader-text').prop('value', cpi_input.text_button);

});

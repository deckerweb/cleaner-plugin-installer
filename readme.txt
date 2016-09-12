=== Cleaner Plugin Installer ===
Contributors: daveshine, deckerweb
Donate link: http://genesisthemes.de/en/donate/
Tags: plugin installer, cleaner, plugins, installer, search, admin, focus, efficient, deckerweb
Requires at least: 4.0
Tested up to: 4.7
Stable tag: 1.4.0
License: GPL-2.0+
License URI: http://www.opensource.org/licenses/gpl-license.php

Simplified & more useful Plugin Install page, replacing Featured tab with bigger search. Additional Topics tab with curated topic tag list.

== Description ==

> #### Cleaner Start Page for "Add Plugins" (Installer)
> A LARGE search box to find plugins for installing more easily and way faster.
>
> No clutter. The regular content of the "Featured" tab was removed: not the 6 same old plugin cards cards any longer and no useless tag cloud anymore!
>
> Plus: set the number of displayed plugin cards per page via "Screen Options" tab (on top right corner).

= Scratching My Own Itch =
As of WordPress 4.0+, going to "Add Plugins" page and being welcomed by always the same old 6 featured plugin cards annoyed me big time! So I thought on how to change this default behavior. Due to WordPress' genius Hooks & Filter functionality I could easily tweak this via my plugin.

Now it starts with what should have been the default (in my opinion) from the beginning: a large and nice plugin search box - because that's what I do all the day :). Side benefit: better performance as no external plugin card content has to be loaded!

*And there you have it, a one-purpose admin helper plugin aiming at (super) administrators and webmasters searching for and installing plugins from WordPress.org repository on a daily basis.*

= Video of Plugin Walkthrough plus Demo: =
[youtube https://www.youtube.com/watch?v=fD42vNhuArA]
[**original video link:** *Screencast by plugin developer David Decker*](https://www.youtube.com/watch?v=fD42vNhuArA)

= Benefits & Advantages =
* Cleaner, more easy, more useful!
* Improved performance of `plugin-install.php` admin start page!
* Additional curated topics with list of plugin tags (from WordPress.org) for lots of use cases etc.
* Additional basic integration of ["WPCore Plugin Manager"](https://wordpress.org/plugins/wpcore/) base plugin and service, as well as "WP Favs".
* Added "Screen Options" tab (on top right corner) to *set number of plugin cards per page* on a per user basis.
* Tweaked "ZIP Uploader page" - larger file upload field, plus bigger button.
* Search field and plugins number integration for "At a Glance" and "Right Now" (Multisite) Dashboard widgets.
* Optional "Slim Mode" to hide various help texts etc. from the plugin - for power users (see bottom of [FAQ page](https://wordpress.org/plugins/cleaner-plugin-installer/faq/ "See in FAQ section for more info ...")).
* Highly extensible: Additional hooks and filters in place so you could easily tweak my plugin's output (or add, or remove) if ever needed :)
* Lightweight, simple one-purpose plugin. Loads only within `/wp-admin/` when and where needed.
* Fully embracing Multisite Network modus, yeah!
* Fully translateable!

= Requirements =
* WordPress version 4.0 or higher!
* At least capability of `install_plugins` for your user role (to access the plugin installer page)!

= Translations: Internationalization (i18n) / Localization (L10n) =
* English (default) - always included
* German (de_DE) - always included
* .pot file (`cleaner-plugin-installer.pot`) for translators is also always included :)
* Easy plugin translation platform with GlotPress tool: [Translate "Cleaner Plugin Installer"...](http://translate.wpautobahn.com/projects/wordpress-plugins-deckerweb/cleaner-plugin-installer)
* *Your translation? - [Just send it in](http://genesisthemes.de/en/contact/)*

[A plugin from deckerweb.de and GenesisThemes](http://genesisthemes.de/en/)

= Feedback =
* I am open for your suggestions and feedback - Thank you for using or trying out one of my plugins!
* Drop me a line [@deckerweb](https://twitter.com/deckerweb) on Twitter
* Or follow me on [+David Decker](https://plus.google.com/+DavidDecker/posts) on Google Plus ;-)

= This Plugin... =
* ...is *Quality Made in Germany*
* ...was created with love (plus some coffee) on an [Ubuntu Linux](http://www.ubuntu.com/desktop) powered machine :)

= More =
* [Also see my other plugins](http://genesisthemes.de/en/wp-plugins/) or see [my WordPress.org profile page](https://profiles.wordpress.org/daveshine/)
* Tip: [*GenesisFinder* - Find then create. Your Genesis Framework Search Engine.](http://genesisfinder.com/)
* Hey, come & join the [*Genesis Community on Google+* :)](http://ddwb.me/genesiscommunity)

== Installation ==

= Installation Steps =
1. Installing alternatives:
 * *via Admin Dashboard:* Go to 'Plugins > Add Plugins', search for "Cleaner Plugin Installer", click "install"
 * *OR via direct ZIP upload:* Upload the ZIP package via 'Plugins > Add New > Upload' in your WP Admin
 * *OR via FTP upload:* Upload `cleaner-plugin-installer` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to the "Plugins > Add Plugins" admin page again and enjoy the new experience... :-)

= Optional user options =
1. Optionally set number of plugin cards per page via "Screen Options" tab (on top right corner).
2. Only for "Topics" tab: switch the search type from "tag" to "keyword" (term) for the plugin tag lists.


= Plugin Requirements =
* WordPress version 4.0 or higher!
* At least capability of `install_plugins` for your user role (to access the plugin installer page)!
* (Technically the plugin is compatible also with older WP versions, styling is made for WP 4.0+!)

= Video of Plugin Walkthrough plus Demo: =
[youtube https://www.youtube.com/watch?v=fD42vNhuArA]
[**original video link:** *Screencast by plugin developer David Decker*](https://www.youtube.com/watch?v=fD42vNhuArA)

**Own translation/wording:** For custom and update-secure language files please upload them to `/wp-content/languages/cleaner-plugin-installer/` (just create this folder) - This enables you to use fully custom translations that won't be overridden on plugin updates. Also, complete custom English wording is possible with that, just use a language file like `cleaner-plugin-installer-en_US.mo/.po` to achieve that (for creating one see the tools on "Other Notes").

== Frequently Asked Questions ==

= Does this plugin replace the built-in "Featured" tab? =
Yes, but only its content! The page query parameter `?tab=featured` was left untouched! This way all works as before, if you access the `plugin-install.php` admin page, but you'll be welcomed with a big search input field.


= What's the benefit of this curated Topics list with plugin tags? =
In my opinion this helps to find specific plugins (within certain areas, topics, use cases...) a lot faster - via your admin area. For example, clicking on "TinyMCE" will list you all plugin cards tagged (by their authors) with "tinymce".

The original built-in plugin tag cloud is way to generic, so I removed it.

**Note:** Manually curated tag lists for a lot of plugin types, use cases and popular plugin solutions. Listing here maintained by David Decker (plugin author of "Cleaner Plugin Installer"). Tag itself are from plugin's readme header.


= Why the Collections tab for "WPCore"? =
Glad you asked :). This is a bit more experimental, I guess. However, in my opinion, the WPCore plugin and service are incredible useful, so I thought of some basic integration. This could help to jump faster to WPCore functionality if the service is already active. If it is not active yet, users are informed about it and can install and register for it super fast. This may help users get aware of an alternative for collecting & managing their favorite plugins - and bulk installing them on any installation.

**Disclaimer:** "I am NOT affiliated with 'WPCore' in any way, other than that, being a normal user of their service & plugin. 'WPCore' is a community effort aiming to make some things a bit easier for a lot of administrators and webmasters." *—David Decker, author of "Cleaner Plugin Installer" plugin*


= Why the additional "Newest" tab? =
I think it is really useful to easily check for the newest additions on WordPress.org plugin repository without leaving your admin area. Also great for test installations to just install a brand new plugin and try it out! :)


= Can I suggest new topics and tags for the "Topics" tab? =
Absolutely! Just open a new thread in the [support forum **here**](https://wordpress.org/support/plugin/cleaner-plugin-installer) and let us know your feedback! Thank you!


= How can I remove the "Collections" tab? =
This is easily possible with a little code snippet added to a *functionality plugin*, *snippet manager* or to your theme's/ child theme's `functions.php`:

`
add_filter( 'install_plugins_tabs', 'custom_cpi_plugin_installer_tabs_tweaks', 15, 1 );
/**
 * Plugin: Cleaner Plugin Installer
 * Remove "Collections" tab.
 *
 * @param  array $tabs
 *
 * @return array Array of (tweaked) plugin installer tabs.
 */
function custom_cpi_plugin_installer_tabs_tweaks( $tabs ) {

	unset( $tabs[ 'collections' ] );

	return $tabs;

}  // end function
`

**---> Note:** I only recommend using a custom functionality plugin, or snippets manager plugins like ["Code Snippets"](https://wordpress.org/plugins/code-snippets/) or ["Toolbox"](https://wordpress.org/plugins/toolbox/). --- Customizing your `functions.php` is always dangerous and at your own risk! You may experience a crashed site plus lots of trouble when changing your theme/ child theme afterwards. Also, any generic admin functionality has no place in your theme!


= How can I remove the "Topics" tab? =
Possible, via the above code for "Collections" tab: you only have to add the following line after the first "unset" line (or replace this line with that):
`
	unset( $tabs[ 'topics' ] );
`


= What does the "Slim Mode" do? =
For power users this is to remove/ hide the following things:

* Remove help texts on the "Start: Search" tab
* Remove help texts on the "Topics" tab
* Remove the "Collections" tab completely
* Remove the help texts on the "Uploader" page
* Remove the notice on the Multisite plugins installer page
* Remove the plugins counter entry on the Dashboard widget

= How do I activate the "Slim Mode"? =
That is relatively easy, just add the following code snippet to your `wp-config.php` file or a functionality plugin:
`
/**
 * Plugin: Cleaner Plugin Installer - activate Slim Mode.
 */
if ( ! defined( 'CPI_SLIM_MODE' ) ) {
	define( 'CPI_SLIM_MODE', TRUE );
}
`

== Screenshots ==

1. Cleaner Plugin Installer: BEFORE view of the "Plugins > Add Plugins" admin page (Add New). ([Click here for larger version of screenshot](https://www.dropbox.com/s/wpjgjatt0ipvoh6/screenshot-1.png?dl=0))

2. Cleaner Plugin Installer: AFTER view of the "Plugins > Add Plugins" admin page (Add New), after activating this plugin. ([Click here for larger version of screenshot](https://www.dropbox.com/s/sclx8djssnngnqa/screenshot-2.png?dl=0))

3. Cleaner Plugin Installer: Additional "Topics" tab -- 2 column view since version v1.1.0. ([Click here for larger version of screenshot](https://www.dropbox.com/s/g6f2sc0oasw5b52/screenshot-3.png?dl=0))

4. Cleaner Plugin Installer: Additional "Collections" tab ([Click here for larger version of screenshot](https://www.dropbox.com/s/tioagtmipl7pzrd/screenshot-4.png?dl=0))

5. Cleaner Plugin Installer: Added "Screen Options" tab for *setting number of plugin cards per page* - on a per user basis. ([Click here for larger version of screenshot](https://www.dropbox.com/s/psnpnxls3u6yg2l/screenshot-5.png?dl=0))

6. Cleaner Plugin Installer: Tweaked ZIP uploader page with larger file input field and bigger upload button. ([Click here for larger version of screenshot](https://www.dropbox.com/s/7fqcitzudk3zand/screenshot-6.png?dl=0))

7. Cleaner Plugin Installer: Added little note on Network plugin installer screen in Multisite to make it crystal clear where the installing happens! :) ([Click here for larger version of screenshot](https://www.dropbox.com/s/69ze03hsu0jcrr8/screenshot-7.png?dl=0))

8. Cleaner Plugin Installer: Also added littel note to a (Sub) Site's plugins page - to make it crystal clear, where what happens (only in Multisite installs!). ([Click here for larger version of screenshot](https://www.dropbox.com/s/gogmbfw8dgqbmgl/screenshot-8.png?dl=0))

9. Cleaner Plugin Installer: Search field and plugins counter integration for "At a Glance" Dashboard widget. ([Click here for larger version of screenshot](https://www.dropbox.com/s/wxlq2gjfjsrm2c3/screenshot-9.png?dl=0))

10. Cleaner Plugin Installer: Search field and network plugins counter integration for "Right Now" Dashboard widget in Multisite's Network admin. ([Click here for larger version of screenshot](https://www.dropbox.com/s/tmr4kdv99vf25ah/screenshot-10.png?dl=0))

11. Cleaner Plugin Installer: Plugin's help tab. ([Click here for larger version of screenshot](https://www.dropbox.com/s/f8cex53no2go08s/screenshot-11.png?dl=0))

== Changelog ==

= 1.4.0 (2016-09-12) =
* NEW: Finally, added the "Recommended" tab to the installer toolbar (was originally introduced with WP 4.2, yes I know...!)
* UPDATE: Fixed search functionality for starting page of the installer -- it's not the most ideal fix but as of now it's working again, which matters. (Backstory: in WP 4.6 they introduced Ajaxified installer behavior for the search function and we cannot easily modify it, sadly!)
* UPDATE: Re-added the original search form (top right in the installer toolbar) for all installer tabs except the starting page - reason: makes more sense to have search field always visible. I made the change based on my own usage and behavior and I guess it fits better overall...! :-)
* UPDATE: Removed the plugin search functionality from the Dashboard widget for WordPress versions 4.6 or higher (due to the changes in WP 4.6+, sadly).
* UPDATE: Updated German translations and also the `.pot` file for all translators.

= 1.3.0 (2014-11-02) =
* NEW: Now also supporting "WPFavs.com" bulk plugin installer service ([GPL plugin at WordPress.org](https://wordpress.org/plugins/wpfavs/)) - in addition to "WPCore.com".
* NEW: Added support for plugin ["Upload Larger Plugins" (free, by David Anderson)](https://wordpress.org/plugins/upload-larger-plugins/), regarding our tweaked uploader page (which will hide gracefully once this other plugin is active).
* NEW: Added plugin search field to "At a Glance" Dashboard widget - comes in really handy :-).
* NEW: Also added plugin search field to "Right Now" Dashboard widget in Multisite's Network admin.
* NEW: Added links and counters for active and total installed plugins to "At a Glance"/ "Right Now" Dashboard widgets - great for admins to get a first overview plugin-wise :).
* NEW: Added (current) version number of plugins to plugin card overview.
* NEW: Added "Slim Mode" to the plugin; to be activated via constant - it removes/ hides a few help texts etc. for power users [see FAQ section here](https://wordpress.org/plugins/cleaner-plugin-installer/faq/ "See in FAQ section for more info ...") for more info on that, and how to activate!
* UPDATE: Moved all visual arrows over to CSS! This also means simplified and improved RTL languages support in removing all PHP-tweaking from RTL-related things (beyond the stylesheet loading).
* UPDATE: Added Dashicon icon to our own Help Tab section link to make clear this is additional and not for Core help texts.
* CODE: Added `$page = 1` to all our tab functions to be 100% compliant with WordPress Core functions expecting this.
* CODE: More refinements, fixed PHP notices, minor enhancements, code documentation.
* UPDATE: Added 3 new screenshots.
* UPDATE: Updated and improved `readme.txt` file here.
* UPDATE: Updated German translations and also the `.pot` file for all translators.

= 1.2.2 (2014-10-29) =
* UPDATE: Fix "Topics" tab screen options display correctly in Multisite.

= 1.2.1 (2014-10-29) =
* NEW: Added new "Screen Option" to the "Topics" tab for setting the search type to "keyword": that means, the linked tag lists will trigger a search for the keyword ("term") instead of the "tag" search. This might bring other/ better/ whatever different search results. It's a per user setting. *--- Mad props to [Brady Vercher](https://profiles.wordpress.org/bradyvercher) of [Blaser Six, Inc.](http://www.blazersix.com/) for contributing the core code for this feature!*
* NEW: Added a few subtle CSS tweaks to the Thickbox modal window when opening a plugin card (details view). So hopefully you'll find that "install button" a bit better and faster now, and maybe like the donate link better :-).
* UPDATE: Make the plugin cards per page setting also available for the optional "Beta Testing" tab.
* UPDATE: Various small improvements, mostly regarding, code organization, (inline) code documentation and `readme.txt` file.
* UPDATE: Updated German translations and also the `.pot` file for all translators.

= 1.2.0 (2014-10-27) =
* NEW: Bring back the submit button for the original search bar in the toolbar (only visible when performing a search).
* UPDATE: Tweaked the large search form on the "Start: Search" tab even more: now fully mobile optimized as well - smoother overall performance :).
* NEW: Added 2 new curated topic tags to the "Topics" tab.
* NEW: Added compatibility plus basic styling for RTL languages (Right-To-Left direction languages).
* UPDATE: Further mobile optimizations.
* UPDATE: In the plugin overhauled some description texts to be more precise.
* UPDATE: Updated German translations and also the `.pot` file for all translators.

= 1.1.0 (2014-10-23) =
* NEW: Tweaked the Plugin ZIP Uploader page! Larger file input field (or drag a file in...), bigger and nicer button. All more clear and logical - as one would expect it (hopefully)!
* NEW: Added 10 new curated topic tags to the "Topics" tab.
* NEW: Only for German locales: added 4 new curated topic tags to the "Topics" tab.
* NEW: Added little admin notice on Network admin plugin installer pages to make it clearer it's the Network installer (only for Multisite of course!).
* NEW: Made search type (term, tag, author) tweakable, so it's possible from now on to filter the search type for the default or your own custom topic lists!
* NEW: Added `:hover` styling for any instance showing "plugin cards" - this way you can better visually distinguish those cards!
* NEW: All markup and CSS way better optimized for smaller displays and mobile usage.
* UPDATE: Topics listing now in 2 column view for regular displays.
* UPDATE: Some more smaller CSS tweaks here and there.
* UPDATE: Various small improvements, mostly regarding, code organization, (inline) code documentation and `readme.txt` file.
* UPDATE: Updated German translations and also the `.pot` file for all translators.

= 1.0.3 (2014-10-20) =
* UPDATE: Fixed and improved the per page setting for the number of plugin cards, now working (better) with all supported tabs.
* NEW: Added 12 new curated topic tags to the "Topics" tab.
* UPDATE: Various small improvements, mostly regarding (inline) documentation and `readme.txt` file.
* CODE: Switched linked topic tags to "slug" linking internally.
* UPDATE: Updated German translations and also the `.pot` file for all translators.

= 1.0.2 (2014-10-09) =
* UPDATE: Fixed debug notice on "Topics" tab, plus internal improvements.
* UPDATE: Fixed markup issue on "Collections" tab.
* UPDATE: Readme here, another FAQ entry, plus added video walkthrough & demo :).
* UPDATE: Updated German translations and also the `.pot` file for all translators.

= 1.0.1 (2014-10-09) =
* UPDATE: Improved Multisite compatibility for "Plugin Cards per page" screen options setting.
* UPDATE: Various small improvements, mostly regarding (inline) documentation and `readme.txt` file.

= 1.0.0 (2014-10-09) =
* Initial release

== Upgrade Notice ==

= 1.4.0 =
Bug fixes for WordPress 4.6+ plus few improvements. Also updated .pot file for translators plus German translations.

= 1.3.0 =
Several new features and improvements. Also updated .pot file for translators plus German translations.

= 1.2.2 =
New "Screen Option" for "Topics" tab - Multisite fix. CSS tweaks for Thickbox modal window. Also updated .pot file for translators plus German translations.

= 1.2.1 =
New "Screen Option" for "Topics" tab. CSS tweaks for Thickbox modal window. Also updated .pot file for translators plus German translations.

= 1.2.0 =
Further mobile optimizations. Basic RTL support. Submit button for installer toolbar search form. Also updated .pot file for translators plus German translations.

== Plugin Links ==
* [Translations (GlotPress)](http://translate.wpautobahn.com/projects/wordpress-plugins-deckerweb/cleaner-plugin-installer)
* [User support forums](https://wordpress.org/support/plugin/cleaner-plugin-installer)
* [Code snippets archive for customizing, GitHub Gist](https://gist.github.com/deckerweb/8e3bc0a1d62a096695db)

== Donate ==
Enjoy using *Cleaner Plugin Installer*? Please consider [making a small donation](http://genesisthemes.de/en/donate/) to support the project's continued development.

== Translations ==

* English - default, always included
* German (de_DE): Deutsch - immer dabei! [Download auch via deckerweb.de](http://deckerweb.de/material/sprachdateien/wordpress-plugins/#cleaner-plugin-installer)
* For custom and update-secure language files please upload them to `/wp-content/languages/cleaner-plugin-installer/` (just create this folder) - This enables you to use fully custom translations that won't be overridden on plugin updates. Also, complete custom English wording is possible with that as well, just use a language file like `cleaner-plugin-installer-en_US.mo/.po` to achieve that.

**Easy plugin translation platform with GlotPress tool:** [**Translate "Cleaner Plugin Installer"...**](http://translate.wpautobahn.com/projects/wordpress-plugins-deckerweb/cleaner-plugin-installer)

*Note:* All my plugins are internationalized/ translateable by default. This is very important for all users worldwide. So please contribute your language to the plugin to make it even more useful. For translating and validating I recommend the ["Poedit Editor"](http://www.poedit.net/), which works fine on Windows, Mac and Linux.

== Idea Behind / Philosophy ==
As of WordPress 4.0+ the new plugin installer start page was annoying me. By scratching my own itch here I came up with this plugin ;-). I hope you enjoy it as much as I do :).

== Credits ==
* [Brady Vercher](https://profiles.wordpress.org/bradyvercher) of [Blaser Six, Inc.](http://www.blazersix.com/) for contributing the "Screen Options" code for the "Topics" tab - Thank you, Brady!
* Plugin user [Mario Bego Garde a.k.a. "pixolin"](https://profiles.wordpress.org/pixolin) for helpful feedback to make the plugin even better - Thank you, Bego!
* All users and testers of the plugin, especially all [5-star reviewers](https://wordpress.org/support/view/plugin-reviews/cleaner-plugin-installer?filter=5) - you guys rock!
* Thanks to WordPress Core for the awesome Hooks & Filters system! :)
* Thanks to the "Dashicon" (font icon) creators, so I could make the appearance a tiny little bit friendlier.

== Last but not least ==
**Special Thanks go out to my family for allowing me to do such spare time projects (aka free plugins) and supporting me in every possible way!**

## Plugin: Cleaner Plugin Installer

### Changelog


#### Version 1.4.0 (2016-09-12)

* NEW: Finally, added the "Recommended" tab to the installer toolbar (was originally introduced with WP 4.2, yes I know...!)
* NEW: Now, plugin also has a [repository on GitHub.com](https://github.com/deckerweb/cleaner-plugin-installer), [bug reports](https://github.com/deckerweb/cleaner-plugin-installer/issues), patches/ pull requests are welcome! :)
* UPDATE: Fixed search functionality for starting page of the installer -- it's not the most ideal fix but as of now it's working again, which matters. (Backstory: in WP 4.6 they introduced Ajaxified installer behavior for the search function and we cannot easily modify it, sadly!)
* UPDATE: Re-added the original search form (top right in the installer toolbar) for all installer tabs except the starting page - reason: makes more sense to have search field always visible. I made the change based on my own usage and behavior and I guess it fits better overall...! :-)
* UPDATE: Removed the plugin search functionality from the Dashboard widget for WordPress versions 4.6 or higher (due to the changes in WP 4.6+, sadly).
* UPDATE: Updated German translations and also the `.pot` file for all translators.


#### Version 1.3.0 (2014-11-02)

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


#### Version 1.2.2 (2014-10-29)

* UPDATE: Fix "Topics" tab screen options display correctly in Multisite.


#### Version 1.2.1 (2014-10-29)

* NEW: Added new "Screen Option" to the "Topics" tab for setting the search type to "keyword": that means, the linked tag lists will trigger a search for the keyword ("term") instead of the "tag" search. This might bring other/ better/ whatever different search results. It's a per user setting. *--- Mad props to [Brady Vercher](https://profiles.wordpress.org/bradyvercher) of [Blaser Six, Inc.](http://www.blazersix.com/) for contributing the core code for this feature!*
* NEW: Added a few subtle CSS tweaks to the Thickbox modal window when opening a plugin card (details view). So hopefully you'll find that "install button" a bit better and faster now, and maybe like the donate link better :-).
* UPDATE: Make the plugin cards per page setting also available for the optional "Beta Testing" tab.
* UPDATE: Various small improvements, mostly regarding, code organization, (inline) code documentation and `readme.txt` file.
* UPDATE: Updated German translations and also the `.pot` file for all translators.


#### Version 1.2.0 (2014-10-27)

* NEW: Bring back the submit button for the original search bar in the toolbar (only visible when performing a search).
* UPDATE: Tweaked the large search form on the "Start: Search" tab even more: now fully mobile optimized as well - smoother overall performance :).
* NEW: Added 2 new curated topic tags to the "Topics" tab.
* NEW: Added compatibility plus basic styling for RTL languages (Right-To-Left direction languages).
* UPDATE: Further mobile optimizations.
* UPDATE: In the plugin overhauled some description texts to be more precise.
* UPDATE: Updated German translations and also the `.pot` file for all translators.


#### Version 1.1.0 (2014-10-23)

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


#### Version 1.0.3 (2014-10-20)

* UPDATE: Fixed and improved the per page setting for the number of plugin cards, now working (better) with all supported tabs.
* NEW: Added 12 new curated topic tags to the "Topics" tab.
* UPDATE: Various small improvements, mostly regarding (inline) documentation and `readme.txt` file.
* CODE: Switched linked topic tags to "slug" linking internally.
* UPDATE: Updated German translations and also the `.pot` file for all translators.


#### Version 1.0.2 (2014-10-09)
* UPDATE: Fixed debug notice on "Topics" tab, plus internal improvements.
* UPDATE: Fixed markup issue on "Collections" tab.
* UPDATE: Readme here, another FAQ entry, plus added video walkthrough & demo :).
* UPDATE: Updated German translations and also the `.pot` file for all translators.


#### Version 1.0.1 (2014-10-09)

* UPDATE: Improved Multisite compatibility for "Plugin Cards per page" screen options setting.
* UPDATE: Various small improvements, mostly regarding (inline) documentation and `readme.txt` file.


#### Version 1.0.0 (2014-10-09)

* Initial release

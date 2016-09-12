# WordPress Plugin: Cleaner Plugin Installer

* **Contributors:** [David Decker](https://github.com/deckerweb), [contributors](https://github.com/deckerweb/cleaner-plugin-installer/graphs/contributors)
* **Tags:** plugin installer, cleaner, plugins, installer, search, admin, focus, efficient, deckerweb
* **Requires at least:** 4.0.0
* **Tested up to:** 4.7-alpha
* **Stable tag:** master
* **Stable version:** 1.4.0
* **Donate link:** [http://ddwb.me/9s](http://ddwb.me/9s)
* **License:** GPL-2.0+
* **License URI:** [http://www.opensource.org/licenses/gpl-license.php](http://www.opensource.org/licenses/gpl-license.php)

Cleaner Plugin Installer experience, replacing the "Featured" tab content with bigger search. Additionally added "Topics" tab with curated topic tag list.


## Description:

> **Cleaner Start Page for "Add Plugins" (Installer)**
>
> A LARGE search box to find plugins for installing more easily and way faster.
>
> No clutter. The regular content of the "Featured" tab was removed: not the 6 same old plugin cards cards any longer and no useless tag cloud anymore!
>
> Plus: set the number of displayed plugin cards per page via "Screen Options" tab (on top right corner).


#### Scratching My Own Itch:
As of WordPress 4.0+, going to "Add Plugins" page and being welcomed by always the same old 6 featured plugin cards annoyed me big time! So I thought on how to change this default behavior. Due to WordPress' genius Hooks & Filter functionality I could easily tweak this via my plugin.

Now it starts with what should have been the default (in my opinion) from the beginning: a large and nice plugin search box - because that's what I do all the day :). Side benefit: better performance as no external plugin card content has to be loaded!

*And there you have it, a one-purpose admin helper plugin aiming at (super) administrators and webmasters searching for and installing plugins from WordPress.org repository on a daily basis.*


#### Video of Plugin Walkthrough plus Demo:
[youtube https://www.youtube.com/watch?v=fD42vNhuArA]
[**original video link:** *Screencast by plugin developer David Decker*](https://www.youtube.com/watch?v=fD42vNhuArA)


#### Benefits & Advantages:
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


## Plugin Installation:

**Requirements/ Prerequisites**
* [WordPress v4.0.0 or higher](https://wordpress.org/download/)
* At least capability of `install_plugins` for your user role (to access the plugin installer page)!
* *PLEASE: For security and best support, always use the latest stable version of WordPress!*

**Manual Upload**
* Download current .zip archive from master branch here, URL: [https://github.com/deckerweb/cleaner-plugin-installer/archive/master.zip](https://github.com/deckerweb/cleaner-plugin-installer/archive/master.zip)
* Unzip the package, then **rename the folder to `cleaner-plugin-installer`**, then upload renamed folder via SFTP/ FTP to your WordPress plugin directory
* Activate the plugin

**Via "GitHub Updater" Plugin** *(recommended!)*

* Install & activate the "GitHub Updater" plugin, get from here: [https://github.com/afragen/github-updater](https://github.com/afragen/github-updater)
* Recommended: set your API Token in the plugin's settings
* Go to "Settings > GitHub Updater > Install Plugin"
* Paste the GitHub URL `https://github.com/deckerweb/cleaner-plugin-installer` in the "Plugin URI" field (branch "master" is pre-set), then hit the "Install Plugin" button there
* Install & activate the plugin

**Updates**
* Are done via WordPress.org (or the plugin "GitHub Updater" (see above)) - leveraging the default WordPress update system!
* *for GitHub Updater only:* Setting your GitHub API Token is recommended! :)
* It's so easy and seamless you won't find any better solution for this ;-)


## Usage:

* See *Description* above :)


## Translations:
= Localization & Internationalizaton:

* Used textdomain: `cleaner-plugin-installer`
* Default `.pot` file included
* German translations included (`de_DE`)
* Plugin's own path for translations: `wp-content/plugins/cleaner-plugin-installer/languages/cleaner-plugin-installer-de_DE.mo`
* *Recommended:* Global WordPress lang dir path for translations: `wp-content/languages/plugins/cleaner-plugin-installer-de_DE.mo` ---> *NOTE: if this file/path exists it will be loaded at higher priority than the plugin path! This is the recommended path & way to store your translations as it is update-safe and allows for custom translations!*
* Recommended translation tools: *Poedit Pro v1.8+* or *WordPress Plugin "Loco Translate"* or *your IDE/ Code Editor* or *old WordPress plugin "Codestyling Localization"* (for the brave who know what they are doing :) )


## Changelog - Version History:

--> See plugin file [CHANGES.md here](https://github.com/deckerweb/cleaner-plugin-installer/blob/master/CHANGES.md)


Copyright (c) 2014-2016 David Decker - DECKERWEB.de

# Template for OpenSchulportfolio

This is the template for the OpenSchulPortfolio project. This is version 3 of the template. It's based on the default `dokuwiki` template and adds some modifications on top. It should be somewhat forward compatible with new DokuWiki releases.

## Configuration

* `closedwiki`: will remove all wiki functionality from the interface when a user is not logged in
* `topmenu_page`: the page to be included as top navigation
* `exportbox`: allows you to diable the export section in the sidebar
* `toolbox`: allows you to diable the tools section in the sidebar

## Differences to v2

When you upgrade from an older version, you will notice that the configuration options have been greatly reduced. However most of the functionality is still there. Here is how the old config settings are correspondent to the new way of doing things.

* `sitetitle`: use DokuWiki's standard `title` setting
* `schoolname`: use DokuWiki's standard `tagline` setting
* `userpage`: FIXME
* `userpage_ns`: FIXME
* `infomail`: disable or uninstall the `infopage` plugin to disable this
* `discuss`: disable or uninstall the `talkpage` plugin to disable this
* `discuss_ns`: configure the `talkpage` plugin instead
* `topmenu`: just empty the `topmenu_page` configuration or delete the page
* `sidebar`: use DokuWiki's builtin sidebar support
* `sidebar_page`: use DokuWiki's standard `sidebar` setting
* `print_new_window`: FIXME
* `winML*`: FIXME

 

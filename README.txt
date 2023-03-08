=== Plugin Name ===
Contributors: jrcreative
Donate link: https://jeremyrosscreative.com
Tags: security, username enumeration, modify login errors
Requires at least: 3.0.1
Tested up to: 6.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin will modify the login messages that show when the incorrect username, email or password are entered.

== Description ==

Username enumeration is one way that bad actors can find out the email addresses and usernames registered in your site.

This plugin modifies the messages on the login page, and the lost password page so that you don't give away any information
about your users unintentionally.

== Installation ==

1. Upload `secure-wp` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= How do I change the messages =

We'll add that feature in the future. Currently it's placed in code.

= What about foo bar? =

Answer to foo bar dilemma.

== Screenshots ==

== Changelog ==

= 1.0 =
* Modify the login messages
* Force Redirect even if the lost password was unsuccessful
* Modify the lost password message
* Initial release
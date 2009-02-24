=== Plugin Name ===
Contributors: yejun
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3494945
Tags: cdn,offloading, simplecdn
Requires at least: 2.7
Tested up to: 2.7.1
Stable tag: trunk

Help you offloading javascript, css and theme files to your own CDN network. This plugin only handle url rewriting not actual file transferring.

== Description ==

Help you offloading javascript, css and theme files to your own CDN network. This plugin only handle url rewriting not actual file transferring.

* Rewrite your js, css and theme file's urls with your own prefix
* Support excluding url patterns
* Tested with SimpleCDn's Mirror bucket

== Installation ==

1. Upload `my-cdn.php` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Offloading your static files to CDN or use a Mirror bucket. The new URL path has to match original.
4. Save changes in Settings.

== Frequently Asked Questions ==

= Which CDN service will work? =

Any mirror service allows exact matching path will work. SimpleCDN Mirror bucket is tested. CloudFront through s3sync should work as well.

== Screenshots ==

1. Settings `/trunk/screenshot.png`

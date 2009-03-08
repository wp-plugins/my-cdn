=== Plugin Name ===
Contributors: yejun
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=3494945
Tags: links,cdn,offloading,simplecdn,cloudfront
Requires at least: 2.7
Tested up to: 2.7.1
Stable tag: trunk

Help you offloading javascript, css and theme files to your own CDN network. This plugin only handle url rewriting not actual file transferring.

== Description ==

Help you offloading javascript, css and theme files to your own CDN network. This plugin only handle url rewriting not actual file transferring.

* Rewrite your js, css and theme file's urls with your own prefix
* Support excluding url patterns
* Multiple destination url can be used to increase page loading speed
* Tested with SimpleCDn's Mirror bucket and Amazon CloudFront.

Change Log:
 Version 1.2: Internal option page changes.
 Version 1.1: Support multiple destination urls.
 Version 1.0: Tight up some regular expression.

== Installation ==

1. Upload `my-cdn.php` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Offloading your static files to CDN or use a Mirror bucket. The new URL path has to match original.
4. Save changes in Settings.

== Frequently Asked Questions ==

= Which CDN service will work? =

Any mirror service allows exact matching path will work. SimpleCDN Mirror bucket and Amazon S3/Cloudfront are tested..

= How to copy files to Amazon S3/CloudFront =

Please check my post: [How to copy selected files to Aamazon S3 Cloudfront](http://blog.mudy.info/2009/02/how-to-copy-selected-files-to-cloudfront/)

= How to batch minify js and css files =

Please check my post: [How to batch process js and css](http://blog.mudy.info/2009/02/one-line-yuicompressor-script/)

= What is the correct SimpleCDN pre-URL and CNAME =

Please check my post: [Correct SimpleCDN pre-URL and CNAMEs](http://blog.mudy.info/2009/02/how-to-use-simplecdn-with-wordpress/)

= Should I use multiple destination urls =

If you have more than 10 items on a single page, you should. However css images refered in a single css file will be loaded from a single destination.

= How to get multiple destinations =

* If you use amazon cloudfront, you can add up to 10 CNAME for every single distribution.
* If you simplecdn, you have two options. One you use multiple bucket. Two use different pre urls.

== Screenshots ==

1. Settings
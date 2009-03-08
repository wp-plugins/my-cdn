<?php
/*
Plugin Name: My CDN
Plugin URI: http://blog.mudy.info/my-plugins/
Description: Help you offloading javascript, css and theme files to your own CDN network. This plugin only handle url rewriting not actual file transferring.
Version: 1.2
Author: Yejun Yang
Author URI: http://blog.mudy.info/
*/
/*  Copyright 2009 Yejun Yang  (email : yejunx AT gmail DOT com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
add_option('my_cdn_old_url', get_option('siteurl'));
add_option('my_cdn_exclude', '/wp-admin/');
add_option('my_cdn_js', 'http://');
add_option('my_cdn_css', 'http://');
add_option('my_cdn_theme', 'http://');

$my_cdn_old_urls = preg_split('/[\s,]+/', trim(get_option('my_cdn_old_url')));
$my_cdn_old_urls = preg_replace('/\./', '\\.',$my_cdn_old_urls);
$my_cdn_old_urls = preg_replace('/^.*$/', '#^\\0#i',$my_cdn_old_urls, 1);

$my_cdn_excludes = preg_split('/[\s,]+/', trim(get_option('my_cdn_exclude')));
$my_cdn_excludes = preg_replace('/^.*$/', '#\\0#i',$my_cdn_excludes, 1);

$my_cdn_jss = preg_split('/[\s,]+/', trim(get_option('my_cdn_js')));
$my_cdn_csss = preg_split('/[\s,]+/', trim(get_option('my_cdn_css')));
$my_cdn_themes = preg_split('/[\s,]+/', trim(get_option('my_cdn_theme')));


function check_cdn_exclude($url) {
	global $my_cdn_excludes;
	$ref = $_SERVER["HTTP_REFERER"];
	foreach ($my_cdn_excludes as $exclude){
		if (preg_match( $exclude, $url)>0) return true;
		if (preg_match( $exclude, $ref)>0) return true;
	}
	return false;
}

function cdn_hash($url, $buckets) {
	if(count($buckets)==1) return $buckets[0];
	$hash = crc32($url) % count($buckets);
	if(strlen($buckets[$hash])>7) return $buckets[$hash];
	else return $buckets[0];
}

function filter_cdn_js($url) {
	global $my_cdn_old_urls, $my_cdn_jss;
	if (check_cdn_exclude($url) ) return $url;
	return preg_replace( $my_cdn_old_urls, cdn_hash($url,$my_cdn_jss) ,$url, 1);
}
function filter_cdn_css($url) {
	global $my_cdn_old_urls, $my_cdn_csss;
	if (check_cdn_exclude($url) ) return $url;
        return preg_replace( $my_cdn_old_urls, cdn_hash($url,$my_cdn_csss) ,$url, 1);
}
function filter_cdn_theme($url) {
	global $my_cdn_old_urls, $my_cdn_themes;
        if (check_cdn_exclude($url) ) return $url;
        return preg_replace( $my_cdn_old_urls, cdn_hash($url,$my_cdn_themes) ,$url, 1);
}

add_action('admin_menu', 'my_cdn_menu');

function my_cdn_menu() {
  add_options_page('My CDN Options', 'My CDN', 8, __FILE__, 'my_cdn_options');
}

function my_cdn_options() {
if ( isset($_POST['action']) && ( $_POST['action'] == 'update_my_cdn' )){
	update_option('my_cdn_old_url', $_POST['my_cdn_old_url']);
	update_option('my_cdn_exclude', $_POST['my_cdn_exclude']);
	update_option('my_cdn_js', $_POST['my_cdn_js']);
	update_option('my_cdn_css', $_POST['my_cdn_css']);
	update_option('my_cdn_theme', $_POST['my_cdn_theme']);
}

?>
<div class="wrap">
<h2>My CDN URL Settings</h2>
<p>If you use <a href="http://aws.amazon.com/cloudfront/">CloudFront</a>, you can read this <a href="http://blog.mudy.info/2009/02/how-to-copy-selected-files-to-cloudfront/">post</a> to help offloading your static files.</p>
<p>You may also <a href="http://blog.mudy.info/2009/02/one-line-yuicompressor-script/">preprocess</a> your css js files <br />
<p>Multiple options can be seperated by comma or space. Please do not leave any trailing comma or space and slash.
<br />
<br /> 
<p><strong style="color:red;"> WARNING:</strong> Test some static urls e.g., http://static.mydomain.com/wp-includes/js/prototype.js <br/>
to ensure your CDN service is fully working before saving changes.</p>
<br />
<br />
<form method="post" action="">
<?php 
// wp_nonce_field('update-options'); 
?>
<table class="form-table">

<tr valign="top">
<th scope="row"><label for="my_cdn_old_url">Original Site URLs</label></th>
<td><input type="text" name="my_cdn_old_url" value="<?php echo get_option('my_cdn_old_url'); ?>" size="50" /></td>
<td><span class="setting-description">Your blog's main urls or any urls you want to rewrite <br />Comma seperated, e.g., http://mydomain.com,http://www.mydomain.com</span></td>
</tr>
<tr valign="top">
<th scope="row"><label for="my_cdn_exclude">Excluding URL patterns</label></th>
<td><input type="text" name="my_cdn_exclude" value="<?php echo get_option('my_cdn_exclude'); ?>" size="50" /></td>
<td><span class="setting-description">Any url or its referal matches this list will not be rewritten. <br />Comma seperated. e.g. /wp-admin/</span></td>
</tr>

<tr valign="top">
<th scope="row"><label for="my_cdn_js">Javascript file pre-URL</label></th>
<td><input type="text" name="my_cdn_js" value="<?php echo get_option('my_cdn_js'); ?>" size="50" /></td>
<td><span class="setting-description">e.g. http://st1.mydomain.com,http://st2.mydomain.com<br />Empty string will disable this function.</span></td>
</tr>
<tr valign="top">
<th scope="row"><label for="my_cdn_css">CSS file pre-URL</label></th>
<td><input type="text" name="my_cdn_css" value="<?php echo get_option('my_cdn_css'); ?>" size="50" /></td>
<td><span class="setting-description">e.g. http://st1.mydomain.com,http://st2.mydomain.com<br />Empty string will disable this function.</span></td>
</tr>
<tr valign="top">
<th scope="row"><label for="my_cdn_theme">Theme file pre-URL</label></th>
<td><input type="text" name="my_cdn_theme" value="<?php echo get_option('my_cdn_theme'); ?>" size="50" /></td>
<td><span class="setting-description">e.g. http://st1.mydomain.com,http://st2.mydomain.com<br />Empty string will disable this function.</span></td>
</tr>

</table>

<input type="hidden" name="action" value="update_my_cdn" />

<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>

</form>
</div>
<?php
}

if (count($my_cdn_jss)>0 && strlen($my_cdn_jss[0])>7)
	add_filter('script_loader_src','filter_cdn_js');
if (count($my_cdn_csss)>0 && strlen($my_cdn_csss[0])>7)
	add_filter('style_loader_src','filter_cdn_css');
if (count($my_cdn_themes)>0 && strlen($my_cdn_themes[0])>7)
	add_filter('theme_root_uri','filter_cdn_theme');
?>
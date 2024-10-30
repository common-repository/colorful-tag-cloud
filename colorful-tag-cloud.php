<?php
/*

**************************************************************************

Plugin Name:  Colorful Tag Cloud
Plugin URI:   http://www.arefly.com/colorful-tag-cloud/
Description:  Colorful Your Blog's Tag Cloud. 為你部落格的標籤雲加上色彩
Version:      1.0.9
Author:       Arefly
Author URI:   http://www.arefly.com/
Text Domain:  colorful-tag-cloud
Domain Path:  /lang/

**************************************************************************

	Copyright 2014  Arefly  (email : eflyjason@gmail.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

**************************************************************************/

define("COLORFUL_TAG_CLOUD_PLUGIN_URL", plugin_dir_url( __FILE__ ));
define("COLORFUL_TAG_CLOUD_FULL_DIR", plugin_dir_path( __FILE__ ));
define("COLORFUL_TAG_CLOUD_TEXT_DOMAIN", "colorful-tag-cloud");

/* Plugin Localize */
function colorful_tag_cloud_load_plugin_textdomain() {
	load_plugin_textdomain(COLORFUL_TAG_CLOUD_TEXT_DOMAIN, false, dirname(plugin_basename( __FILE__ )).'/lang/');
}
add_action('plugins_loaded', 'colorful_tag_cloud_load_plugin_textdomain');

include_once COLORFUL_TAG_CLOUD_FULL_DIR."options.php";

/* Add Links to Plugins Management Page */
function colorful_tag_cloud_action_links($links){
	$links[] = '<a href="'.get_admin_url(null, 'options-general.php?page='.COLORFUL_TAG_CLOUD_TEXT_DOMAIN.'-options').'">'.__("Settings", COLORFUL_TAG_CLOUD_TEXT_DOMAIN).'</a>';
	return $links;
}
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'colorful_tag_cloud_action_links');

function colorful_tag_cloud_callback($matches) {
	$text = $matches[1];
	if(get_option("colorful_tag_cloud_type") == "customise"){
		$color = get_option("colorful_tag_cloud_color_code");
	}else{
		for($a = 0; $a < 6; $a++){
			$color .= dechex(rand(0,15));
		}
	}
	$pattern = '/style=(\'|\")(.*)(\'|\")/i';
	$text = preg_replace($pattern, 'style="color: #'.$color.';"', $text);
	return "<a ".$text.">";
	unset($color);
}

function colorful_tag_cloud($text) {
	$text = preg_replace_callback('|<a (.+?)>|i', 'colorful_tag_cloud_callback', $text);
	return $text;
}
add_filter('wp_tag_cloud', 'colorful_tag_cloud', 1);
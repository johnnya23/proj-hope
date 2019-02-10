<?php
/*
Plugin Name: JMA CoWEBop Base 7.2
Description: This plugin adds a theme base provides styling and structure options like a child theme
Version: 1.2
Author: John Antonacci
Author URI: http://cleansupersites.com
License: GPL2
*/
/**
 * Absolute file path to bases directory.
 *
 * @since Theme_Blvd 2.0.0
 */
define('JMA_BASES_DIRECTORY', plugin_dir_path(__FILE__));

/**
 * URI to bases directory.
 *
 * @since Theme_Blvd 2.0.0
 */
define('JMA_BASES_URI', plugin_dir_url(__FILE__));
/**
 * Filter in the paths to your bases.
 */
function jma_base_path($path, $base)
{
    if ($base == 'cowebop-base') {
        $path = sprintf('%s/base/%s', plugin_dir_path(__FILE__), $base);
    }
    return $path;
}
add_filter('themeblvd_base_path', 'jma_base_path', 10, 2);

/**
 * Filter in the custom bases for the
 * admin selection.
 */
function jma_bases($bases)
{
    $bases['cowebop-base'] = array(
        'name'      => 'CoWEBop Base',
        'desc'      => 'CoWEBop base options and configurations'
    );
    return $bases;
}
add_filter('themeblvd_bases', 'jma_bases');

/**
 * Filter in the URL to your bases.
 */
function jma_base_uri($uri, $base)
{
    if ($base == 'cowebop-base') {
        $uri = esc_url(sprintf('%sbase/%s', plugin_dir_url(__FILE__), $base));
    }
    return $uri;
}
add_filter('themeblvd_base_uri', 'jma_base_uri', 10, 2);


function cowebop_base_option_id($id)
{
    return 'jumpstart';
}
add_filter('themeblvd_option_id', 'cowebop_base_option_id');

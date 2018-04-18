<?php

add_filter('widget_text', 'do_shortcode');//FOR WIDGET SHORTCODE

if (!function_exists('jmaStartsWith')) {
    function jmaStartsWith($haystack, $needle)
    {
        return $needle === "" || strpos($haystack, $needle) === 0;
    }
}

/**
 * @function is_kid checks to see if the current post is a child of $pid
 *
 * @param integer $pid   the page id we are searching for children of
 * @param integer (0 or 1) $includeparent wheather to include $pid itself
 *
 * @return boolean true if current ($post) is a child of $pid other-wise false
 *
 */
function is_kid($pid, $includeparent)
{      // $pid = The ID of the page we're looking for pages underneath
    //$includeparent = 1 to include the parent page, 0 to exclude
    global $post;               // load details about this page

    if (is_page($pid)) {
        return $includeparent;
    }            // we're at the page

    $anc = get_post_ancestors($post->ID);
    foreach ($anc as $ancestor) {
        if (is_page() && $ancestor == $pid) {
            return true;
        }
    }

    return false;  // we aren't at the page, and the page is not an ancestor
}

/**
 * @function jma_elements generates a div or other element from shortcode [html] etc.
 *
 * @param array $atts   attributes element, id, class, style as they apply to element
 * element will likely be div or span (maybe an h tag)
 * @param string $content the content within the shortcode
 *
 * @return string $content surrounded by the element with attributes
 *
 */
function jma_elements($atts, $content = null)
{
    ob_start();
    extract(shortcode_atts(array(
        'element' => 'div'
        ), $atts));

    echo '<'. $element . ' ';
    if ($atts) {
        foreach ($atts as $attribute => $value) {
            if ($attribute != 'element') {// check to make sure the attribute exists
                echo $attribute . '="' . $value . '" ';
            }
        }
    }
    echo '>';
    echo do_shortcode($content);
    echo '</' . $element . '>';
    $x = ob_get_contents();
    ob_end_clean();
    return str_replace("\r\n", '', $x);
}
add_shortcode('html', 'jma_elements');
add_shortcode('html_inner', 'jma_elements');
add_shortcode('html_inner_inner', 'jma_elements');
add_shortcode('html_inner_inner_inner', 'jma_elements');

/**
 * @function shortcode_empty_paragraph_fix this function runs on all page content to
 * try to eliminate extra spacing around shortcode
 *
 * @param string $content the content within the shortcode
 *
 * @return string $content with extra <br>'s and <p>'s removed
 *
 */
function shortcode_empty_paragraph_fix($content)
{
    $array = array(
        '<p></p>[' => '[',
        '<p>[' => '[',
        ']</p>' => ']',
        ']<br />' => ']'
    );

    $content = strtr($content, $array);

    return $content;
}

add_filter('the_content', 'shortcode_empty_paragraph_fix');

/*
   SIDEBAR HOOKS
   themeblvd_sidebar_{location OR type}_before
   themeblvd_sidebar_{location OR type}_after
   locations: sidebar_left, sidebar_right, ad_above_header, ad_above_content, ad_below_content, ad_below_footer
   types: collapsible, fixed
   so... ie...   themeblvd_sidebar_sidebar_right_before   hooks above right sidebar
*/



/*********************************************************************
 * ADD SOME EXTRA HOOKS
 ********************************************************************/
//add hooks to the top and bottom of .entry-content div (also required content-page.php modifications)
//immediately inside <article>
function jma_content_top()
{
    do_action('jma_content_top');
}
function jma_content_bottom()
{
    do_action('jma_content_bottom');
}
//add hooks to the outside sidebar
function jma_sidebar_top()
{
    do_action('jma_sidebar_top');
}
function jma_sidebar_middle()
{
    do_action('jma_sidebar_middle');
}
function jma_sidebar_bottom()
{
    do_action('jma_sidebar_bottom');
}

//add widget area to middle of outside sidebar
//UNCOMMENT SIDEBAR REGISTRATION BELOW
function jma_sidebar_middle_default()
{
    ?>
	<div class="jma-outside-sidebar-widget">
		<?php if (themeblvd_display_sidebar('outside_sidebar')) {
        ;
    } ?>
	</div>
	<?php
}
add_action('jma_sidebar_middle', 'jma_sidebar_middle_default');

//segregate site specific pre framework code for updates

/* adds the code for the sortable header base options */
require_once('options-header-sortable.php');

/* set default stacking of builder columns to 767 px */
function jma_core_filter($x)
{
    $x['columns']['options']['stack']['std'] = 'sm';
    return $x;
}
add_filter('themeblvd_elements', 'jma_core_filter');

/* set default stacking of sdiebars to 767 px */
function jma_sidebar_layout_stack()
{
    return 'sm';
}
add_filter('themeblvd_sidebar_layout_stack', 'jma_sidebar_layout_stack');

/* set default stacking of footer columns to 767 px */
function jma_footer_columns_args($args)
{
    $args['stack'] = 'sm';
    return $args;
}
add_filter('themeblvd_footer_columns_args', 'jma_footer_columns_args');

//grab the values from jma-options.php, jma-options-header.php
if (!function_exists('jma_get_theme_values')) {
    function jma_get_theme_values()
    {
        $jma_option_name = themeblvd_get_option_name();
        $jma_spec_options = get_option($jma_option_name);
        return $jma_spec_options;
    }
}
$jma_spec_options = jma_get_theme_values();//echo '<pre>';print_r($jma_spec_options);echo '</pre>';

/**
 * @function jma_images_on Check to see if images are on for the current page (or specific page)
 *
 * @param integer $post_id the post to be checked
 *
 * @return boolean $return are images on due to base or page options
 *
 */
function jma_images_on($post_id = 0)
{
    if (!$post_id) {
        global $post;
        $post_id = get_the_ID();
    }
    $jma_spec_options = jma_get_theme_values();
    if (is_home($post_id) || is_archive($post_id)) {
        return $jma_spec_options[ 'jma_archive_header_images' ];
    }

    if (!(is_page($post_id) || is_single($post_id))) {
        return $jma_spec_options[ 'jma_header_images' ];
    } else {
        $images_string = is_page($post_id)? 'jma_header_images': 'jma_post_header_images';
    }
    if (get_post_meta($post_id, '_jma_header_data_key', true)) {
        $header_value =  get_post_meta($post_id, '_jma_header_data_key', true);
    }
    $page_images = $header_value['change_header_default'] ;
    $return = (($jma_spec_options[ $images_string ] && $page_images != 'off') || (!$jma_spec_options[ $images_string ] && $page_images == 'on'));
    return $return;
}

/**
 * @function jma_remove_script_version for more efficient script loading
 *
 */
if (!function_exists('jma_remove_script_version')) {
    function jma_remove_script_version($src)
    {//Remove Query strings from Static Resources
        $parts = explode('?ver', $src);
        return $parts[0];
    }
}
add_filter('script_loader_src', 'jma_remove_script_version', 15, 1);
add_filter('style_loader_src', 'jma_remove_script_version', 15, 1);

require_once 'current-page-options.php';//Add box for indy page header meta image values

/**
 * Slider image sizes
 */
//lets not create an extra image size if we dont need it
/**
 * @function home_and_interior_image_sizes_identical Check to see if images size settings in base
 * are the same for home and interior pages
 *
 * @used_in jma_slider_image_sizes
 *
 * @return boolean
 *
 */
function home_and_interior_image_sizes_identical()
{
    $jma_spec_options = jma_get_theme_values();
    return ($jma_spec_options['header_image_width'] == $jma_spec_options['header_interior_width'] && $jma_spec_options['header_image_height'] == $jma_spec_options['header_interior_height']) ;
}

/**
 * @function jma_slider_image_sizes filter to set based on options selected) and uset theme image sizes
 *
 * @param array $sizes incoming sizes
 *
 * @return array $sizes filtered sizes
 *
 */
function jma_slider_image_sizes($sizes)
{
    global $jma_spec_options;

    // image size for header slider
    $sizes['jma-home-header']['name'] = 'Home Header';
    $sizes['jma-home-header']['width'] = $jma_spec_options['header_image_width'];
    $sizes['jma-home-header']['height'] = $jma_spec_options['header_image_height'];
    $sizes['jma-home-header']['crop'] = true;
    if (!home_and_interior_image_sizes_identical()) {
        $sizes['jma-interior-header']['name'] = 'Interior Header';
        $sizes['jma-interior-header']['width'] = $jma_spec_options['header_interior_width'];
        $sizes['jma-interior-header']['height'] = $jma_spec_options['header_interior_height'];
        $sizes['jma-interior-header']['crop'] = true;
    }
    unset($sizes['tb_large']);
    unset($sizes['tb_medium']);
    unset($sizes['slider-large']);
    unset($sizes['slider-staged']);
    return $sizes;
}
add_filter('themeblvd_image_sizes', 'jma_slider_image_sizes');

function jma_add_options()
{
    require_once('options-header-images.php');// file that creates special options tab
    require_once('options-header.php');// file that creates special options tab
    require_once('options-page.php');// file that creates special options tab
}
add_action('after_setup_theme', 'jma_add_options', 5);


/**
 * @function logo_in_menu Determine if any of the header items contain the logo together with
 * the menu (to determine the need for jquery to position menu)
 *
 * @return boolean
 *
 */
function logo_in_menu()
{
    global $jma_spec_options;
    $return = false;
    $sortable_items = $jma_spec_options['header_content'];
    if (is_array($sortable_items)) {
        foreach ($sortable_items as $sortable_item) {
            if ($sortable_item['logo']==1 && $sortable_item['header_element'] == 'access') {
                $return = true;
            }
        }
    }
    return $return;
}

/**************************************************************************************************
 * special options (except image sizes, which is above)
 */
 require_once 'header-images.php';
 require_once 'functions-implement-special-options.php';
/**
 * end special options (except image sizes)
 **************************************************************************************************************/

require_once 'functions-css-builder-helpers.php';

/**
 * @function generate_style_css generate dynamic-styles.css from dynamic-styles-builder.php
 * and supply values for $jma_spec_options, $logo_in_menu, $root_off
 *
 */
function generate_style_css()
{
    $jma_spec_options = jma_get_theme_values();//make $jma_spec_options available to dynamic-styles-builder.php

    $logo_in_menu = false;
    $root_off = false;
    $sortable_items = $jma_spec_options['header_content'];
    if (is_array($sortable_items)) {
        foreach ($sortable_items as $sortable_item) {
            if ($sortable_item['logo']==1 && $sortable_item['header_element'] == 'access') {
                $logo_in_menu = true;
            }
            if ($sortable_item['remove_root_bg']==1 && $sortable_item['header_element'] == 'access') {
                $root_off = true;
            }
        }
    }
    // used to fing sidebar divider shading
    $css_uri = plugin_dir_url(__FILE__). '/';

    $css_dir =  plugin_dir_path(__FILE__). 'css/' ;

    require($css_dir . 'dynamic-styles-builder.php'); // Generate CSS

    $css = build_css($jma_css_values);

    file_put_contents(get_stylesheet_directory() . '/dynamic-styles.css', $css, LOCK_EX); // Save value from end of css/dynamic-styles-builder.php
}
add_action('after_switch_theme', 'generate_style_css');
function custom_styles()
{
    add_action('update_option_' . themeblvd_get_option_name(), 'generate_style_css');
}
add_action('admin_init', 'custom_styles', 11);

// end dynamic styles implementation

function jma_custom_styles()
{
    if (!file_exists(get_stylesheet_directory() . '/dynamic-styles.css')) {
        generate_style_css();
    }
    wp_enqueue_style('jma_dynamic_styles', get_stylesheet_directory_uri(). '/dynamic-styles.css', false, '1.0');
}
add_action('wp_enqueue_scripts', 'jma_custom_styles', 21);


function jma_favicon()
{
    global $jma_spec_options;
    $ext = pathinfo($jma_spec_options['site_favicon'], PATHINFO_EXTENSION) == 'ico'? 'x-icon': pathinfo($jma_spec_options['site_favicon'], PATHINFO_EXTENSION);
    echo '<link href="' . $jma_spec_options['site_favicon'] . '" rel="shortcut icon" type="image/' . $ext . '">';
}
add_action('wp_head', 'jma_favicon', 800);
add_action('admin_head', 'jma_favicon');


//styling the backend with this css (hence hook "admin_head") remove comment 5 lines down to enable
function jma_backend_custom_css()
{
    echo '<link rel="stylesheet" href="'.plugin_dir_url(__FILE__).'css/back-side.css" type="text/css" />';
    echo "\n"; // line break for neatness
}
add_action('admin_head', 'jma_backend_custom_css');




function jma_theme_scripts()
{
    wp_enqueue_script('metaslider-nivo-slider');
    wp_enqueue_script('adjust_site_js', plugin_dir_url(__FILE__) . '/assets/js/adjust-site.min.js', array('jquery'));
}
add_action('wp_enqueue_scripts', 'jma_theme_scripts');

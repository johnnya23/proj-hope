<?php

/**
 * @function get_theme_default_header retrieves the default header as set in child theme options
 *
 * @param array $jma_spec_options   child theme options
 * @param string $header_image_size_string the size of the header image (ussaully dependent on wheather
 * this is home page, but may be a filtered value
 *
 * @return string $default_header_image the complete default header image tag
 *
 */
if (!function_exists('get_theme_default_header')) {
    function get_theme_default_header($jma_spec_options, $header_image_size_string)
    {
        $site_title = get_bloginfo('name');
        $raw_default_header_image = $jma_spec_options['default_header_image'];//establish default image
        $theme_default_id = attachment_url_to_postid($raw_default_header_image);
        if ($theme_default_id) {
            $default_header_image = wp_get_attachment_image($theme_default_id, $header_image_size_string, false, array('alt' => $site_title));
        } elseif ($raw_default_header_image) {
            $default_header_image = '<img alt="' . $site_title . '" src="' . $raw_default_header_image . '"/>';
        } else {
            $default_header_image = '<img alt="' . $site_title . '" src="' . get_stylesheet_directory_uri().'/images/default.jpg"/>';
        }
        return $default_header_image;
    }
}

/**
 * @function display_header_slider for backend to display a list of individual sliders
 *
 */
if (!function_exists('display_header_slider')) {
    function display_header_slider($type_id)
    {
        $slider_array = explode('|', $type_id);
        if ($slider_array[0] == 'theme_blvd') {
            $return = themeblvd_slider($slider_array[1]);
        } else {
            $return = 'errror';
        }

        return apply_filters('return_display_header_slider', $return, $type_id);
    }
}

/**
 * @function get_header_image_code produces the code for the header image or slider based on selections
 * made on the individual page
 *
 * @param array $jma_spec_options   child theme options
 * @param string $header_image_size_string the size of the header image (usually dependent on wheather
 * this is home page, but may be a filtered value)
 * @param integer $post_id   the post id
 *
 * @return string $return the complete header image code
 *
 */
if (!function_exists('get_header_image_code')) {
    function get_header_image_code($jma_spec_options, $header_image_size_string = 'jma-home-header', $post_id = 0)
    {
        if (!$post_id) {
            global $post;
            $post_id = $post->ID;
        }
        $site_title = get_bloginfo('name');
        $featured_image = wp_get_attachment_image(get_post_thumbnail_id($post_id), $header_image_size_string, false, array('alt' => $site_title));
        $return = get_theme_default_header($jma_spec_options, $header_image_size_string);

        if (get_post_meta($post_id, '_jma_header_data_key', true)) {//from jma-header-box.php
            $header_value =  get_post_meta($post_id, '_jma_header_data_key', true);
        }
        if (is_home() || is_archive()) {//archives and main blog just use theme default
            return $return;
        }

        if (is_front_page() && is_home()) {
            if ($front_page_slideshow) {
                $return = themeblvd_slider($jma_spec_options['front_page_slideshow']);
            }//end for front page
        } elseif ($header_value['slider_id']) {//grab a slideshow from pages metabox dropdown
        $return = display_header_slider($header_value['slider_id']);
        } elseif ($featured_image && $header_value['use_featured_image']) {//grab featured image
            $return = $featured_image;
        }
        return apply_filters('get_header_image_code_filter', $return, $header_value, $jma_spec_options) ;
    }
}

/**
 * @function jma_get_header_image_size_string determines the size requirement for the page (usually dependent on wheather
 * this is home page, but may be a filtered value)
 *
 * @return string $header_image_size_string an image size which is registered with the theme (or plugin)
 */
if (!function_exists('jma_get_header_image_size_string')) {
    function jma_get_header_image_size_string()
    {
        $use_home = is_front_page() || home_and_interior_image_sizes_identical();
        $header_image_size_string = $use_home ? 'jma-home-header' : 'jma-interior-header';
        $header_image_size_string = apply_filters('header_image_code_size', $header_image_size_string);
        return $header_image_size_string;
    }
}

/**
 * @function jma_header_image_html this is the function we call on the hook
 *
 * outputs the html for the image section
 */
if (!function_exists('jma_header_image_html')) {
    function jma_header_image_html()
    {
        $jma_spec_options = jma_get_theme_values();
        $header_image_size_string = jma_get_header_image_size_string();
        $header_image_attr = themeblvd_get_image_sizes($header_image_size_string);

        $marg_top_string = is_front_page() ? 'header_image_home_margin_top' : 'header_image_margin_top';
        $margin_top = apply_filters('header_image_top', $jma_spec_options[$marg_top_string]);

        $marg_bottom_string = is_front_page() ? 'header_image_home_margin_bottom' : 'header_image_margin_bottom';
        $margin_bottom = apply_filters('header_image_bottom', $jma_spec_options[$marg_bottom_string]);

        $width_string = is_front_page() ? 'header_image_width' : 'header_interior_width';
        $page_width = $jma_spec_options['site_width']; ?>

	<div class="jma-header-image" style="padding-top: <?php echo $margin_top; ?>px;
		padding-bottom: <?php echo $margin_bottom ?>px"
		data-image_width ="<?php echo $header_image_attr['width']; ?>"
		data-image_height ="<?php echo $header_image_attr['height']; ?>"
		data-width ="<?php echo $page_width; ?>" >
		<div class="jma-header-image-wrap"
		style="max-width: <?php echo $header_image_attr['width']; ?>px;
		position: relative;
		z-index: 0">

			<?php do_action('jma_header_image_before');
        echo get_header_image_code($jma_spec_options, $header_image_size_string);
        do_action('jma_header_image_after'); ?>

		</div>
	</div>
	<?php
    }
}

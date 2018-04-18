<?php


if (!function_exists('jma_add_header_input_box')) {
    function jma_add_header_input_box()
    {
        $screens = array('post', 'page', 'portfolio_item');
        $screens = apply_filters('input_screens_filter', $screens);
        foreach ($screens as $screen) {
            add_meta_box(
                'jma_header_input_section',
                __('Current Page Header Content', 'jma_textdomain'),
                'jma_header_input_box',
                $screen, 'side', 'high'
            );
        }
    }
}
add_action('add_meta_boxes', 'jma_add_header_input_box');

/*
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
if (!function_exists('jma_header_input_box')) {
    function jma_header_input_box($post)
    {
        // Add an nonce field so we can check for it later.
        wp_nonce_field('jma_header_input_box', 'jma_header_input_box_nonce');

        /*
         * Use get_post_meta() to retrieve an existing value
         * from the database and use the value for the form.
         */
        $screen_obj = get_current_screen();

        $default_featured = $screen_obj->post_type === 'page' ? 1 : 0;
        $header_values = array('change_header_default' => 'default',
                            'slider_id' => '',
                            'use_featured_image' => $default_featured, );
        if (get_post_meta($post->ID, '_jma_header_data_key', true)) {
            $header_values = get_post_meta($post->ID, '_jma_header_data_key', true);
        }
        if (function_exists('themeblvd_get_select')) {
            $slider_selections = array('theme_blvd' => themeblvd_get_select('sliders'));
            $slider_selections = apply_filters('slider_array_filter', $slider_selections);
        }
        if ($slider_selections) {
            foreach ($slider_selections as $slider_type => $slider_selection_choices) {
                foreach ($slider_selection_choices as $i => $slider_selection_choice) {
                    $form_array[$slider_type.'|'.$i] = $slider_selection_choice;
                }
            }
        }
        ob_start();
        echo '<p></p>';
        echo '<label for="change_header_default">';
        _e('Change header image settings. If default is "no images" and you turn images on for this page you must fill in settings in the "Theme Options" page', 'jma_textdomain');
        echo '</label><br/><br/> ';

        echo '<select name="change_header_default">';
        echo '<option value="default"'.selected($header_values['change_header_default'], 'default').'>Default</option>';
        echo '<option value="off"'.selected($header_values['change_header_default'], 'off').'>off</option>';
        echo '<option value="on"'.selected($header_values['change_header_default'], 'on').'>on</option>';
        echo '</select><br/><br/>';

        echo '<label for="slider_id">';
        _e('The Theme will first use the slider indicated below. If empty then the Featured Image or Default Image (as set below). The default image is set in "Theme Options".<br/><br/>Select Slider ID to show at the top of this page.', 'jma_textdomain');
        echo '</label><br/><br/> ';
        echo '<select name="slider_id">';
        echo '<option value=""'.selected($header_values['slider_id'], '').'>Select...</option>';
        foreach ($form_array as $i => $form_item) {
            echo '<option value="'.$i.'"'.selected($header_values['slider_id'], $i).'>'.$form_item.'</option>';
        }
        echo '</select><br/><br/>';

        echo '<label for="use_featured_image">';
        _e('Choose "Featured" or "Default" for the header image (if no featured image default will be used).', 'jma_textdomain');
        echo '</label><br/><br/> ';
        echo '<select name="use_featured_image">';
        echo '<option value="1"'.selected($header_values['use_featured_image'], '1').'>Use Featured Image</option>';
        echo '<option value="0"'.selected($header_values['use_featured_image'], '0').'>Use Default Image</option>';
        echo '</select><br/><br/>';
        $x = ob_get_contents();
        $x = apply_filters('jma_current_page_options', $x, $header_values);
        ob_end_clean();
        echo str_replace("\r\n", '', $x);
    }
}
/*
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
if (!function_exists('jma_save_header_postdata')) {
    function jma_save_header_postdata($post_id)
    {
        /*
         * We need to verify this came from the our screen and with proper authorization,
         * because save_post can be triggered at other times.
         */

        // Check if our nonce is set.
        if (!isset($_POST['jma_header_input_box_nonce'])) {
            return $post_id;
        }

        $nonce = $_POST['jma_header_input_box_nonce'];

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($nonce, 'jma_header_input_box')) {
            return $post_id;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        // Check the user's permissions.
        if ('page' === $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } else {
            if (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }
        }

        /* OK, its safe for us to save the data now. */

        // Sanitize user input.
        foreach ($_POST as $i => $value) {
            $clean_data[$i] = sanitize_text_field($value);
        }
        /*$jma_data['change_header_default'] = sanitize_text_field($_POST['change_header_default']);
        $jma_data['slider_id'] = sanitize_text_field($_POST['slider_id']);
        $jma_data['use_featured_image'] = sanitize_text_field($_POST['use_featured_image']);*/

        // Update the meta field in the database.
        update_post_meta($post_id, '_jma_header_data_key', $clean_data);
    }
}
add_action('save_post', 'jma_save_header_postdata');

/*********************************************************************************************/

/*
 * Adds a box to the main column on the Post and Page edit screens.
 */
if (!function_exists('jma_add_banner_input_box')) {
    function jma_add_banner_input_box()
    {
        $screens = array('post', 'page');
        $screens = apply_filters('input_screens_filter', $screens);
        foreach ($screens as $screen) {
            add_meta_box(
                'jma_banner_input_section',
                __('Current Page Banner Content', 'jma_textdomain'),
                'jma_banner_input_box',
                $screen, 'normal', 'high'
            );
        }
    }
}
add_action('add_meta_boxes', 'jma_add_banner_input_box');

/*
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
if (!function_exists('jma_banner_input_box')) {
    function jma_banner_input_box($post)
    {
        // Add an nonce field so we can check for it later.
        wp_nonce_field('jma_banner_input_box', 'jma_banner_input_box_nonce');

        /*
         * Use get_post_meta() to retrieve an existing value
         * from the database and use the value for the form.
         */
        $banner_values = array('change_banner_default' => '', 'banner_text' => '');
        if (get_post_meta($post->ID, '_jma_banner_data_key', true)) {
            $banner_values = get_post_meta($post->ID, '_jma_banner_data_key', true);
        }

        echo '<p></p>';
        /*echo '<label for="change_banner_default">';
        _e( 'Change banner  settings.', 'jma_textdomain' );
        echo '</label><br/><br/> ';

        echo '<select name="change_banner_default">';
        echo '<option value="default"' . selected( $banner_values['change_banner_default'], 'default' ) .'>Default</option>';
        echo '<option value="show"' . selected( $banner_values['change_banner_default'], 'show' ) .'>show</option>';
        echo '<option value="hide"' . selected( $banner_values['change_banner_default'], 'hide' ) .'>hide</option>';
        echo '</select><br/><br/>';*/

        echo '<label for="banner_text">';
        _e('banner_text.', 'jma_textdomain');
        echo '</label><br/><br/> ';
        echo '<textarea name="banner_text" rows="3" cols="100" value="'.$banner_values['banner_text'].'">'.$banner_values['banner_text'].'</textarea>';
    }
}
/*
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
if (!function_exists('jma_save_banner_postdata')) {
    function jma_save_banner_postdata($post_id)
    {
        /*
         * We need to verify this came from the our screen and with proper authorization,
         * because save_post can be triggered at other times.
         */

        // Check if our nonce is set.
        if (!isset($_POST['jma_banner_input_box_nonce'])) {
            return $post_id;
        }

        $nonce = $_POST['jma_banner_input_box_nonce'];

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($nonce, 'jma_banner_input_box')) {
            return $post_id;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        // Check the user's permissions.
        if ('page' === $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } else {
            if (!current_user_can('edit_post', $post_id)) {
                return $post_id;
            }
        }

        /* OK, its safe for us to save the data now. */

        // Sanitize user input.
        $jma_data['change_banner_default'] = sanitize_text_field($_POST['change_banner_default']);
        $jma_data['banner_text'] = sanitize_text_field($_POST['banner_text']);

        // Update the meta field in the database.
        update_post_meta($post_id, '_jma_banner_data_key', $jma_data);
    }
}
add_action('save_post', 'jma_save_banner_postdata');
add_action('after_switch_theme', 'jma_save_banner_postdata');

<?php

/*
Plugin Name: JMA Custom Post Type Display
Description: Adds isotope animation and filtering to a  Custom Post Type display using shortcode
Version: 1.0
Author: John Antonacci
License: GPL2
*/
function jma_amazon_quicktags()
{
    if (wp_script_is('quicktags')) {
        ?>
		<script language="javascript" type="text/javascript">

		QTags.addButton( 'JMA_ama', 'amazon', '[book amazon_id="PUT_ID_HERE" align="right"]' );
	    </script>
<?php
    }
}
add_action('admin_print_footer_scripts', 'jma_amazon_quicktags');

if (!function_exists('jma_cpt_shortcode')) {
    function jma_cpt_shortcode($needle = '', $post_item = 0)
    {
        if ($post_item) {
            if (is_object($post_item)) {
                $post = $post_item;
            } else {
                $post = get_post($post_item);
            }
        } else {
            global $post; /*  add comment*/
        }
        if (is_array($needle)) {
            $pattern = get_shortcode_regex($needle);
        } elseif (is_string($needle)) {
            $pattern = get_shortcode_regex(array($needle));
        } else {
            $pattern = get_shortcode_regex();
        }
        preg_match_all('/'.$pattern.'/s', $post->post_content, $matches);

        if (//if shortcode(s) to be searched for were passed and not found $return false
            array_key_exists(2, $matches) &&
            count($matches[2])
        ) {
            $return = $matches;
        } else {
            $return = false;
        }

        return $return;
    }
}

if (!function_exists('jmaStartsWith')) {
    function jmaStartsWith($haystack, $needle)
    {
        return $needle === '' || strpos($haystack, $needle) === 0;
    }
}

function jma_cpt_isotope()
{
    wp_enqueue_style('jma_Book_isotope', plugins_url('/jma_isotope.css', __FILE__));
    if (jma_cpt_shortcode('books')) {
        //wp_enqueue_script('jma_isotope', plugins_url('/isotope.pkgd.min.js', __FILE__), array('jquery'));
        wp_enqueue_script('jma_isotope_js', plugins_url('/jma_isotope.js', __FILE__), array('jquery'));
    }
}
add_action('wp_enqueue_scripts', 'jma_cpt_isotope');

function jma_cpt_image_sizes($sizes)
{
    // image size for header slider
    $sizes['jma-cpt-grid']['name'] = 'CPT Grid';
    $sizes['jma-cpt-grid']['width'] = 300;
    $sizes['jma-cpt-grid']['height'] = 300;
    $sizes['jma-cpt-grid']['crop'] = true;

    return $sizes;
}
//add_filter('themeblvd_image_sizes', 'jma_cpt_image_sizes');
spl_autoload_register('jma_cpt_autoloader');
function jma_cpt_autoloader($class_name)
{
    if (false !== strpos($class_name, 'JMACPT')) {
        $classes_dir = realpath(plugin_dir_path(__FILE__));
        $class_file = $class_name . '.php';
        require_once $classes_dir . DIRECTORY_SEPARATOR . $class_file;
    }
}








/**
 * Build settings fields
 * @return array Fields to be displayed on settings page
 */
    $args = array(
       'public'   => true,
       '_builtin' => false
    );

    $output = 'names'; // names or objects, note names is the default
    $operator = 'and'; // 'and' or 'or'

    $cpt_array = get_post_types(/*$args, $output, $operator*/);

    $settings = array(
    /*
     * start of a new section
     * */

    'setup' => array(
        'title'					=> __('Setup', 'jmacpt_textdomain'),
        'description'			=> __('Setup options.', 'jmacpt_textdomain'),

        /*
         * fields for this section section
         * */
        'fields'				=> array(
            array(
                'id' 			=> 'tag',
                'label'			=> __('Associate Tag', 'jmacpt_textdomain'),
                'description'	=> __('An alphanumeric token that uniquely identifies you as an Associate. To obtain an Associate Tag, refer to <a id="BecomeAssociateLink" href="http://docs.aws.amazon.com/AWSECommerceService/latest/DG/becomingAssociate.html" target="_blank">Becoming an Associate</a>.', 'jmacpt_textdomain'),
                'type'			=> 'text',
                'default'		=> ''
            ),
                array(
                'id' 			=> 'key',
                'label'			=> __('Access Key', 'jmacpt_textdomain'),
                'description'	=> __('Your Access Key ID which uniquely identifies you.', 'jmacpt_textdomain'),
                'type'			=> 'text',
                'default'		=> ''
            ),
                array(
                'id' 			=> 'secret',
                'label'			=> __('Secret Access Key', 'jmacpt_textdomain'),
                'description'	=> __('A key that is used in conjunction with the Access Key ID to cryptographically sign an API request. To retrieve your Access Key ID or Secret Access Key, refer to <a id="ManageYourAccountLink" href="http://docs.aws.amazon.com/AWSECommerceService/latest/DG/becomingDev.html" target="_blank">Becoming Book Advertising API Developer</a>.', 'jmacpt_textdomain'),
                'type'			=> 'text',
                'default'		=> ''
            ),
            array(
                'id' 			=> 'cache',
                'label'			=> __('Cache Time', 'jmacpt_textdomain'),
                'description'	=> __('Frequency of checks back to YouTube for info. Larger number for quicker page loads and to avoid hitting YouTube Api limits (86400 = 1 day or 0 for testing only).', 'jmacpt_textdomain'),
                'type'			=> 'number',
                'default'		=> '86400'
            ),
            array(
                'id' 			=> 'dev',
                'label'			=> __('Dev Mode', 'jmacpt_textdomain'),
                'description'	=> __('Dev may allow plugin to function on Windows localhost (Use Live in Live for security)', 'jmacpt_textdomain'),
                'type'			=> 'radio',
                'options'		=> array( 0 => 'Live' , 1 => 'Dev'),
                'default'		=> 0
            ),
                array(
                'id' 			=> 'cpt',
                'label'			=> __('Post Type', 'jmacpt_textdomain'),
                'description'	=> __('slug for your post type', 'jmacpt_textdomain'),
                'type'			=> 'text',
                'default'		=> ''
            )
        )
    )
);

$jmacpt_db_option = 'jmacpt_options_array';
$jmcpt_options_array = get_option($jmacpt_db_option);



if (is_admin()) {
    $jma_settings_page = new JMACPTSettings(
    array(
        'base' => 'jmacpt',
        'title' => 'Custom Post Type Display Options',
        'db_option' => $jmacpt_db_option,
        'settings' => $settings)
    );
}
function jmaama_clear_cache()
{
    global $wpdb;
    $plugin_options = $wpdb->get_results("SELECT option_name FROM $wpdb->options WHERE option_name LIKE '_transient_jma_ama%' OR option_name LIKE '_transient_timeout_jma_ama%'");
    foreach ($plugin_options as $option) {
        delete_option($option->option_name);
    }
}
add_action('update_option_' . $jmacpt_db_option, 'jmaama_clear_cache');

function jma_ama_save_post($post_id)
{
    global $post;
    if ($post->post_type != 'book') {
        return;
    }
    jmaama_clear_cache();
}
add_action('save_post', 'jma_ama_save_post');


/********************************************/

function jma_display_cpt_grid($atts)
{
    global $jmcpt_options_array;
    /*comment*/
    $defaults = array(
         'post_type' => $jmcpt_options_array['cpt'],
         'taxonomies' => 'book-category',
         'term' => '',
         'orderby' => 'title',
         'order' => 'ASC',
         'gutter' => 30,
         'posts_per_page' => -1,
         'buttons' => 0,
         'isotope' => 0,
         /* classes for individual items */
         'classes' => 'col-md-2 col-sm-3 col-xs-6',
     );
    extract(shortcode_atts($defaults, $atts));
    $atts = wp_parse_args($atts, $defaults);
    if ($taxonomies) {
        $taxonomies = explode(',', $taxonomies);
    } else {
        $taxonomies = get_object_taxonomies($post_type, 'names');
    }
    $jma_terms = get_terms($taxonomies);

    $trans_string = 'jma_ama';
    if (is_array($atts)) {
        foreach ($atts as $i => $att) {
            if ($i !== 'taxonomies') {
                $trans_string .= $att;
            }
        }
    }
    $trans_string .= implode('', $taxonomies);
    $trans_string = str_replace(' ', '', $trans_string);
    $return = get_transient($trans_string);
    if (false === $return || !$jmcpt_options_array['cache']) {
        ob_start();
        $iso_grid = $isotope? 'jma-iso-tax-grid-wrap':'jma-standard-tax-grid-wrap';
        echo '<div id="jma-tax-grid-wrap" class="cpt-grid ' . $iso_grid . '">';
        if ($buttons) {
            echo '<div id="all-buttons" style="text-align: center">';
            if (is_array($taxonomies) && count($taxonomies) > 1) {
                echo '<div class="taxonomies button-group btn-group" style="margin-bottom: 10px">';
                echo '<!--<button type="button" class="all-btn btn btn-default trigger is-checked" data-filter="*">All Books</button>-->';
                $i = 0;
                foreach ($taxonomies as $tax) {
                    $checked = $i ? '': ' is-checked';
                    $i++;
                    $tax = get_taxonomy($tax);
                    echo '<button type="button" class="btn trigger filters' . $checked . '" data-filter=".jma-column" data-tax="'.$tax->name.'">'.$tax->labels->singular_name.'</button>';
                }
                echo '</div><!--button-group--><br/>';
            }
            $i = 0;
            if (is_array($taxonomies)) {
                foreach ($taxonomies as $taxonomy) {
                    $styles = $i ?' style="height: 0;margin-bottom:0" ': ' style="height:auto;margin-bottom:15px" ';
                    $i++;
                    $jma_terms = get_terms(array('orderby' => 'slug', 'parent' => 0, 'taxonomy' => $taxonomy ));
                    echo '<div class="filters button-group btn-group terms ' . $taxonomy . '"' . $styles . '>';
                    if (count($taxonomies) === 1) {
                        echo '<button type="button" class="btn trigger is-checked" data-filter=".jma-column">All</button>';
                    }
                    foreach ($jma_terms as  $jma_term) {
                        $term_string = $jma_term->name;
                        if ($taxonomy === 'authors') {
                            $term_string = str_replace(';', ',', $term_string);
                            /*$haystack = $term_string;
                            $needle = ' ';
                            $replace = ', ';
                            $pos = strpos($haystack, $needle);
                            if ($pos !== false) {
                                $term_string = substr_replace($haystack, $replace, $pos, strlen($needle));
                            }*/
                        }
                        echo '<button type="button" class="btn trigger cat-id-'.$jma_term->term_id.'" data-filter=".'.$jma_term->slug.'">'.$term_string.'</button>';
                    }
                    echo '</div><!--button-group-->';
                }
            }
            echo '</div><!--all-buttons-->';
        }
        $gutter_style = $gutter? ' style="margin-left: -' . ($gutter/2) . 'px;margin-right: -' . ($gutter/2) . 'px"': '';
        echo '<div id="jma-cpt-grid-inner" ' . $gutter_style . '>';
        $args = array(
        'post_type'=>$post_type,
        'orderby'=>$orderby,
        'order'=>$order,
        'posts_per_page'=>$posts_per_page
    );
        if ($taxonomies && $term) {
            $args['tax_query'] = array(
        array(
            'taxonomy' => $taxonomies[0],
            'field'    => 'slug',
            'terms'    => $term,
        ),
    );
        }
        $custom_query = new WP_Query($args);
        echo '<!-- Start the Loop -->';
        $i = 1;
        while ($custom_query->have_posts()) {
            $custom_query->the_post();
            $jma_cpt_meta = get_post_meta($custom_query->post->ID, '_jma_amazon_id_data_key', true);
            $jma_taxes = wp_get_post_terms($custom_query->post->ID, $taxonomies, array('fields' => 'slugs'));
            $class_string = '';
            foreach ($jma_taxes as $jma_tax) {
                $class_string .= ' '.$jma_tax;
            }
            $gutter_style = ' style="padding-left: ' . ($gutter/2) . 'px;padding-right: ' . ($gutter/2) . 'px;margin-bottom: ' . $gutter . 'px "';
            echo '<div class="jma-column'.$class_string. ' ' . $classes . ' post-id-'.$custom_query->post->ID.'" ' . $gutter_style . '" data-order="'.$i.'">';

            $item = new JMACPTamazon_item($jmcpt_options_array, $jma_cpt_meta['amazon_id']);

            echo '</div><!-- .jma-column (end) -->';
        }
        echo '</div><!-- jma-cpt-grid-inner (end )-->';

        echo '<div class="clear"></div>';
        echo '</div><!-- jma-tax-wrap (end )-->';

        $x = ob_get_contents();
        ob_end_clean();
        wp_reset_query();
        $return = str_replace("\r\n", '', $x);
        set_transient($trans_string, $return, $jmcpt_options_array['cache']);
    }
    return $return;
}
add_shortcode('books', 'jma_display_cpt_grid');

function jma_amazon_book($atts)
{
    $defaults = array(
         'class' => 'jma-book',
     );
    global $jmcpt_options_array;
    extract(shortcode_atts($defaults, $atts));
    $atts = wp_parse_args($atts, $defaults);
    ob_start();

    echo '<div ';
    if ($atts) {
        foreach ($atts as $attribute => $value) {
            if ($attribute != 'amazon_id' && $attribute != 'align') {// check to make sure the attribute exists
                if ($attribute == 'class') {
                    if ($value != 'jma-book') {
                        $value .= ' jma-book';
                    }
                    if ($atts['align']) {
                        $value .= ' ' . $atts['align'];
                    }
                }
                echo $attribute . '="' . $value . '" ';
            }
        }
    }
    echo '>';
    $item = new JMACPTamazon_item($jmcpt_options_array, $atts['amazon_id']);
    echo '</div>';
    $x = ob_get_contents();
    ob_end_clean();
    return str_replace("\r\n", '', $x);
}
add_shortcode('book', 'jma_amazon_book');

function jma_cpt_redirect()
{
}
add_action('template_redirect', 'jma_cpt_redirect');

if (!function_exists('jma_add_amazon_id_input_box')) {
    function jma_add_amazon_id_input_box()
    {
        $screens = array('book');
        $screens = apply_filters('input_screens_filter', $screens);
        foreach ($screens as $screen) {
            add_meta_box(
                'jma_amazon_id_input_section',
                __('Amazon ID', 'jma_textdomain'),
                'jma_amazon_id_input_box',
                $screen,
                'normal',
                'high'
            );
        }
    }
}
add_action('add_meta_boxes', 'jma_add_amazon_id_input_box');

/*
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
if (!function_exists('jma_amazon_id_input_box')) {
    function jma_amazon_id_input_box($post)
    {
        // Add an nonce field so we can check for it later.
        wp_nonce_field('jma_amazon_id_input_box', 'jma_amazon_id_input_box_nonce');

        /*
         * Use get_post_meta() to retrieve an existing value
         * from the database and use the value for the form.
         */

        $amazon_vals = array('amazon_id' => '');
        if (get_post_meta($post->ID, '_jma_amazon_id_data_key', true)) {
            $amazon_vals = get_post_meta($post->ID, '_jma_amazon_id_data_key', true);
        }

        echo '<p></p>';

        echo '<label for="amazon_id">';
        _e('amazon_id.', 'jma_textdomain');
        echo '</label><br/><br/> ';

        echo '<input type="text" name="amazon_id" value="'.$amazon_vals['amazon_id'].'">';
    }
}
/*
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
if (!function_exists('jma_save_amazon_id_postdata')) {
    function jma_save_amazon_id_postdata($post_id)
    {
        /*
         * We need to verify this came from the our screen and with proper authorization,
         * because save_post can be triggered at other times.
         */

        // Check if our nonce is set.
        if (!isset($_POST['jma_amazon_id_input_box_nonce'])) {
            return $post_id;
        }

        $nonce = $_POST['jma_amazon_id_input_box_nonce'];

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($nonce, 'jma_amazon_id_input_box')) {
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
        $jma_data['amazon_id'] = sanitize_text_field($_POST['amazon_id']);

        // Update the meta field in the database.
        update_post_meta($post_id, '_jma_amazon_id_data_key', $jma_data);
    }
}
add_action('save_post', 'jma_save_amazon_id_postdata');
register_activation_hook(__FILE__, 'jma_save_amazon_id_postdata');





function jmacpt_register_post_types()
{
    $labels = array(
        'name' => _x('Books', 'themeblvd'),
        'singular_name' => _x('Book', 'themeblvd'),
        'add_new' => _x('Add New', 'themeblvd'),
        'add_new_item' => _x('Add New Book', 'themeblvd'),
        'edit_item' => _x('Edit Book', 'themeblvd'),
        'new_item' => _x('New Book', 'themeblvd'),
        'view_item' => _x('View Book', 'themeblvd'),
        'search_items' => _x('Search Books', 'themeblvd'),
        'not_found' => _x('No Books found', 'themeblvd'),
        'not_found_in_trash' => _x('No Books found in Trash', 'themeblvd'),
        'parent_item_colon' => _x('Parent Book:', 'themeblvd'),
        'menu_name' => _x('Books', 'themeblvd'),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
    'supports' => array( 'title' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array( 'slug' => 'books'),
        'capability_type' => 'post'
    );

    register_post_type('book', $args);
}

function jmacpt_register_custom_taxonomies()
{
    $labels = array(
        'name' => _x('Book Category Name', 'themeblvd'),
        'singular_name' => _x('Book Category', 'themeblvd'),
        'search_items' => _x('Search Book Categories', 'themeblvd'),
        'popular_items' => _x('Popular Book Categories', 'themeblvd'),
        'all_items' => _x('All Book Categories', 'themeblvd'),
        'parent_item' => _x('Parent Book Category', 'themeblvd'),
        'parent_item_colon' => _x('Parent Book Category:', 'themeblvd'),
        'edit_item' => _x('Edit Book Category', 'themeblvd'),
        'update_item' => _x('Update Book Category', 'themeblvd'),
        'add_new_item' => _x('Add New Book Category', 'themeblvd'),
        'new_item_name' => _x('New Book Category', 'themeblvd'),
        'add_or_remove_items' => _x('Add or remove Book Categories', 'themeblvd'),
        'choose_from_most_used' => _x('Choose from most used Book Categories', 'themeblvd'),
        'menu_name' => _x('Book Categories', 'themeblvd'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => true,
        'hierarchical' => true,
        'rewrite' => array( 'slug' => 'book-category')
    );

    register_taxonomy('book-category', array('book'), $args);

    $labels = array(
        'name' => _x('Authors', 'themeblvd'),
        'singular_name' => _x('Author', 'themeblvd'),
        'search_items' => _x('Search Authors', 'themeblvd'),
        'popular_items' => _x('Popular Authors', 'themeblvd'),
        'all_items' => _x('All Authors', 'themeblvd'),
        'parent_item' => _x('Parent Author', 'themeblvd'),
        'parent_item_colon' => _x('Parent Author:', 'themeblvd'),
        'edit_item' => _x('Edit Author', 'themeblvd'),
        'update_item' => _x('Update Author', 'themeblvd'),
        'add_new_item' => _x('Add New Author', 'themeblvd'),
        'new_item_name' => _x('New Author', 'themeblvd'),
        'add_or_remove_items' => _x('Add or remove Authors', 'themeblvd'),
        'choose_from_most_used' => _x('Choose from most used Authors', 'themeblvd'),
        'menu_name' => _x('Authors', 'themeblvd'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => true,
        'hierarchical' => false
    );

    register_taxonomy('authors', array('book'), $args);
}
function jma_cpt_init()
{
    jmacpt_register_post_types();
    jmacpt_register_custom_taxonomies();
}
add_action('init', 'jma_cpt_init');

function jmacpt_rewrite_flush()
{
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'jmacpt_rewrite_flush');
//add_action('after_switch_theme', 'jmacpt_rewrite_flush');

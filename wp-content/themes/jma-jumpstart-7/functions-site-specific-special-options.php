<?php
//add site specific postframework code below
// Add buttons to html editor http://www.wpexplorer.com/adding-wordpress-custom-quicktags/

function jma_scroll_global_config($setup)
{
    $setup['display']['scroll_effects'] = false;
    return $setup;
}
//add_filter('themeblvd_global_config', 'jma_scroll_global_config');


add_filter('widget_text', 'do_shortcode');

function jma_child_image_sizes($sizes)
{
    unset($sizes['tb_x_large']);
    unset($sizes['tb_large']);
    unset($sizes['tb_medium']);
    unset($sizes['tb_square_x_large']);
    unset($sizes['tb_square_large']);
    unset($sizes['tb_square_medium']);
    unset($sizes['slider-x-large']);
    unset($sizes['slider-large']);
    unset($sizes['slider-medium']);
    $sizes['sm_grid'] = array(
        'name'      => 'Small Grid',
        'width'     => 320,
        'height'    => 180,
        'crop'      => true
    );

    return $sizes;
}
add_filter('themeblvd_image_sizes', 'jma_child_image_sizes');

function jma_popup($popup_id, $trigger_text, $popup_title = '', $popup_content, $trigger_class = 'btn btn-default', $fade = true, $trigger_wrap_el = '')
{
    $x = $open = $close= '';
    if ($trigger_wrap_el) {
        $open = '<'. $trigger_wrap_el . '>';
        $close = '<'. $trigger_wrap_el . '>';
    }
    $fade = fade? ' fade': '';
    $x .= sprintf('%s<a href="#popup_' . $popup_id . '" title="' . $popup_title . '" class="' . $trigger_class . '" target="" data-toggle="modal">' . $trigger_text . '</a>%s', $open, $close);

    $x .= '<div class="modal' . $fade . '" id="popup_' . $popup_id . '" tabindex="-1" role="dialog" aria-hidden="true">';
    $x .= '<div class="modal-dialog">';
    $x .= '<div class="modal-content">';
    $x .= '<div class="modal-header">';
    $x .= '<button type="button" class="close" data-dismiss="modal">×</button>';
    $x .= '<h3>' . $popup_title . '</h3>';
    $x .= '</div><!-- modal-header (end) -->';
    $x .= '<div class="modal-body">';
    $x .= '<p>';
    $x .= $popup_content;
    $x .= '</p>';
    $x .= '</div><!-- .modal-body (end) -->';
    $x .= '<div class="modal-footer">';
    $x .= '<a href="#" class="btn btn-default" data-dismiss="modal">Close</a>';
    $x .= '</div><!-- .modal-footer (end) -->';
    $x .= '</div><!-- .modal-content (end) -->';
    $x .= '</div><!-- .modal-dialog (end) -->';
    $x .= '</div><!-- .modal (end) -->';
    return $x;
}
function jma_popup_shortcode($atts, $content = null)
{
    ob_start();
    extract(shortcode_atts(array(
        'trigger_text' => 'read more',
        'popup_title' => '',
        'trigger_class' => 'jma_pop_inline',
        'trigger_wrap_el' => ''
        ), $atts));
    echo  jma_popup(rand(1, 999999), $trigger_text, $popup_title, do_shortcode($content), $trigger_class, true, $trigger_wrap_el);

    $x = ob_get_contents();
    ob_end_clean();
    return $x;
}
add_shortcode('jma_popup', 'jma_popup_shortcode');

/* get happening by expire date*/

/**
 * Custom query for post lists/post grids
 */
function my_custom_posts_query($query, $args)
{
    if ($args['query'] == 'expires_first') {
        $query = array(
            'cat' => 1,
             'order' => 'ASC',
             'meta_key' => '_expiration-date',
             'orderby' => 'meta_value'
        );
        if (is_front_page()) {
            $query['posts_per_page'] = 5;
        }
    }
    return $query;
}
add_filter('themeblvd_posts_args', 'my_custom_posts_query', 10, 2);

function jma_sidebar_filter($sidebar_layout)
{
    if (get_post_type() == 'portfolio_item') {
        $sidebar_layout = 'full_width';
    }
    return $sidebar_layout;
}
add_filter('themeblvd_sidebar_layout', 'jma_sidebar_filter');

function jma_post_filter($setup)
{
    $setup['options']['tb_thumb_link']['std'] = 'post';//link from say the grid to the post
    $setup['options']['tb_thumb_link_single']['std'] = 'thumbnail';//link the single page featured image to enlarged lightbox
    if ($_GET['post_type'] == 'portfolio_item' || get_post_type($_GET['post']) == 'portfolio_item') {//just for the portfolio post type
        $setup['options']['tb_thumb']['std'] = 'hide';
    }//hide the featured image on the single post

    return $setup;
}
add_filter('themeblvd_post_meta', 'jma_post_filter');


function jma_register_subject_post_types()
{
    $labels = array(
        'name' => _x('Subjects', 'themeblvd'),
        'singular_name' => _x('Subject', 'themeblvd'),
        'add_new' => _x('Add New', 'themeblvd'),
        'add_new_item' => _x('Add New Subject', 'themeblvd'),
        'edit_item' => _x('Edit Subject', 'themeblvd'),
        'new_item' => _x('New Subject', 'themeblvd'),
        'view_item' => _x('View Subject', 'themeblvd'),
        'search_items' => _x('Search Subjects', 'themeblvd'),
        'not_found' => _x('No subjects found', 'themeblvd'),
        'not_found_in_trash' => _x('No subjects found in Trash', 'themeblvd'),
        'parent_item_colon' => _x('Parent Subject:', 'themeblvd'),
        'menu_name' => _x('Subjects', 'themeblvd'),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'supports' => array( 'title', 'editor', 'custom-fields', 'thumbnail', 'excerpt' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array( 'slug' => 'subjects'),
        'capability_type' => 'post'
    );

    register_post_type('subject', $args);
}

function jma_register_subject_taxonomies()
{
    $labels = array(
        'name' => _x('Subject Category Name', 'themeblvd'),
        'singular_name' => _x('Subject Category', 'themeblvd'),
        'search_items' => _x('Search Subject Categories', 'themeblvd'),
        'popular_items' => _x('Popular Subject Categories', 'themeblvd'),
        'all_items' => _x('All Subject Categories', 'themeblvd'),
        'parent_item' => _x('Parent Subject Category', 'themeblvd'),
        'parent_item_colon' => _x('Parent Subject Category:', 'themeblvd'),
        'edit_item' => _x('Edit Subject Category', 'themeblvd'),
        'update_item' => _x('Update Subject Category', 'themeblvd'),
        'add_new_item' => _x('Add New Subject Category', 'themeblvd'),
        'new_item_name' => _x('New Subject Category', 'themeblvd'),
        'add_or_remove_items' => _x('Add or remove Subject Categories', 'themeblvd'),
        'choose_from_most_used' => _x('Choose from most used Subject Categories', 'themeblvd'),
        'menu_name' => _x('Subject Categories', 'themeblvd'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => true,
        'hierarchical' => true,
        'rewrite' => array( 'slug' => 'subject_cats'),
        'query_var' => 'subject_cat'
    );

    register_taxonomy('subject_cat', array('subject'), $args);

    $labels = array(
        'name' => _x('Class Name', 'themeblvd'),
        'singular_name' => _x('Class', 'themeblvd'),
        'search_items' => _x('Search Classes', 'themeblvd'),
        'popular_items' => _x('Popular Classes', 'themeblvd'),
        'all_items' => _x('All Classes', 'themeblvd'),
        'parent_item' => _x('Parent Class', 'themeblvd'),
        'parent_item_colon' => _x('Parent Class:', 'themeblvd'),
        'edit_item' => _x('Edit Class', 'themeblvd'),
        'update_item' => _x('Update Class', 'themeblvd'),
        'add_new_item' => _x('Add New Class', 'themeblvd'),
        'new_item_name' => _x('New Class', 'themeblvd'),
        'add_or_remove_items' => _x('Add or remove Classes', 'themeblvd'),
        'choose_from_most_used' => _x('Choose from most used Classes', 'themeblvd'),
        'menu_name' => _x('Classes', 'themeblvd'),
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => true,
        'hierarchical' => true,
        'rewrite' => array( 'slug' => 'classes'),
        'query_var' => 'classes'
    );

    register_taxonomy('classes', array('subject'), $args);
}
function jma_subject_init()
{
    jma_register_subject_post_types();
    jma_register_subject_taxonomies();
}
add_action('init', 'jma_subject_init');

function jma_subject_rewrite_flush()
{
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'jma_subject_rewrite_flush');

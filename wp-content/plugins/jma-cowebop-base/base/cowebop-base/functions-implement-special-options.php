<?php

/**
 * @function jma_implement_special_options implements html changes required by
 * selected user options
 *
 */
if (!function_exists('jma_implement_special_options')) {
    function jma_implement_special_options()
    {
        global $post;
        add_filter('themeblvd_toggle', 'jma_child_themeblvd_toggle');
        add_filter('themeblvd_icon_shims', '__return_true');
        remove_action('themeblvd_header_content', 'themeblvd_header_content_default');//clear the header default content
        remove_action('themeblvd_header_menu', 'themeblvd_header_menu_default');
        add_action('themeblvd_header_content', 'jma_header_content_default');//add our loop for sortable header
        add_action('themeblvd_header_content', 'themeblvd_mobile_header_menu');//add our loop for sortable header
        remove_all_actions('themeblvd_mobile_header');

        add_filter('themeblvd_footer_copyright', 'jma_copy_text');

        $jma_spec_options = jma_get_theme_values();
        if ($jma_spec_options['add_search_popup']) {
            add_filter('themeblvd_primary_menu_args', 'jma_menu_filter');
            add_filter('themeblvd_do_floating_search', 'jma_do_floating_search');
        }
        $jma_high_sidebar = $jma_spec_options[ 'jma_high_sidebar' ];// grab the value for extra 'right', 'left', or 'none'
        $jma_body_style = $jma_spec_options[ 'body_shape' ];	//boxed, stretch ...

        add_action('wp_head', 'jma_google');//google fonts (if necessary)

        remove_action('themeblvd_breadcrumbs', 'themeblvd_breadcrumbs_default');
        add_action('themeblvd_before_layout', 'themeblvd_breadcrumbs_default');//move breadcrumbs insode of #main

        if (is_page_template('template_builder.php') && $jma_body_style == 'stretch_bordered') {
            //wrap the custom template with div .jma-custom-wrap
            add_action('themeblvd_content_top', 'jma_custom_border_top', 1);
            add_action('themeblvd_content_bottom', 'jma_custom_border_bottom', 9999);
        }
        if ($jma_body_style == 'dark_modular') {//remove ad_above_content and breadcrumbs from before content-sidebar-wrap
            remove_action('themeblvd_before_layout', 'themeblvd_breadcrumbs_default');
            add_action('themeblvd_content_top', 'themeblvd_breadcrumbs_default', 3);
            remove_action('themeblvd_main_top', 'themeblvd_widgets_above_content');
            remove_action('themeblvd_breadcrumbs', 'themeblvd_breadcrumbs_default');



            add_action('themeblvd_content_top', 'themeblvd_widgets_above_content', 2);//add ad_above_content & br. cr. to top of content
            add_action('themeblvd_content_top', 'themeblvd_breadcrumbs_default', 3);//add ad_above_content & br. cr. to top of content
            remove_action('themeblvd_main_bottom', 'themeblvd_main_bottom_default');
            add_action('themeblvd_content_bottom', 'themeblvd_main_bottom_default');
        }
        if ($jma_high_sidebar == 'left' || $jma_high_sidebar == 'right') {
            add_action('themeblvd_header_after', 'jma_add_outside_col_top');// same html markup weather 'right' or 'left'
        }

        add_filter('body_class', 'jma_add_classes');

        if (($jma_spec_options['title_page_top'] && $jma_body_style != 'dark_modular') &&
            (is_search() ||
            ((is_page() || is_single() || is_home())) ||
            (is_archive() && themeblvd_get_option('archive_mode', null, 'blog') != 'false'))
        ) {
            $title_hook = $jma_spec_options['body_shape'] == 'stretch'? 'themeblvd_header_after':'themeblvd_main_top';
            add_action($title_hook, 'jma_add_title', 20);
        }
        if ($jma_spec_options['alt_sticky_logo']) {//add different log for header
            add_filter('themeblvd_sticky_logo_uri', 'alt_sticky_logo');
        }

        //function in header-images.php displays header images (hooked in loop below)
        add_action('jma_header_image', 'jma_header_image_html');
    }
}
add_action('template_redirect', 'jma_implement_special_options');

/**
 * @function alt_sticky_logo allows a custom logo if paret theme sticky menu is in use
 *
 */
function alt_sticky_logo($x)
{
    $jma_spec_options = jma_get_theme_values();
    return $jma_spec_options['alt_sticky_logo'];
}

function jma_add_classes($classes)
{
    global $jma_spec_options;
    if ($jma_spec_options['body_shape'] == 'stretch' || $jma_spec_options['body_shape'] == 'stretch_bordered') {
        $classes[] = 'stretched';
    } else {
        $classes[] = 'boxed';
    }
    if (jma_images_on()) {
        $classes[] = 'images-on';
    }
    if ($jma_spec_options['title_page_top'] == 1) {
        $classes[] = 'jma-banner-title';
    }
    return $classes;
}


/**
 * @function jma_custom_border_top wrap the custom template with div .jma-custom-wrap
 * @function jma_custom_border_bottom wrap the custom template with div .jma-custom-wrap
 *
 */
function jma_custom_border_top()
{
    echo '<div class="jma-custom-wrap">';
}
function jma_custom_border_bottom()
{
    echo '</div><!--jma-custom-wrap-->';
}

/**
 * @function jma_add_outside_col_top add html for outside sidebar
 *
 */
if (!function_exists('jma_add_outside_col_top')) {
    function jma_add_outside_col_top()
    {
        ?>
		<div class="jma-outside-sidebar clearfix" >
			<div class="outside-sidebar-inner clearfix">
	            <div class="outside-sidebar-widget-wrap clearfix">
	    			<?php jma_sidebar_top();//new hook (unused/available)?>
	    			<?php jma_sidebar_middle();//new hook this one has the wdiget area attached?>
	    			<?php jma_sidebar_bottom();/*new hook (unused/available)*/ ?>
	            </div>
			</div>
			<div style="clear: both; width: 100%"></div>
		</div><?php
    }
}

/**
 * @function jma_google add google fonts from child theme options and includes filter for extra fonts
 *
 */
function jma_google()
{
    $jma_spec_options = jma_get_theme_values();
    $typography_arrays[] = $jma_spec_options[ 'typography_body' ];
    $typography_arrays[] = $jma_spec_options[ 'typography_header' ];
    $typography_arrays[] = $jma_spec_options[ 'typography_special' ];

    $typography_arrays = apply_filters('dynamic_types_filter', $typography_arrays);

    foreach ($typography_arrays as $typography_array) {
        themeblvd_include_fonts($typography_array);
    }
}


/**
 * @function jma_menu_args_filter add the secondary menu
 *
 */
function jma_menu_args_filter($args)
{
    $args = array(
                'walker'			=> new ThemeBlvd_Main_Menu_Walker(),
                'menu_id' 			=> 'secondary-menu',
                'menu_class'		=> 'tb-secondary-menu tb-to-side-menu sf-menu sf-menu-with-fontawesome clearfix',
                'container' 		=> '',
                'fallback_cb' 		=> false,
                'theme_location'	=> 'jma_secondary_menu'
            );
    return $args;
}
add_filter('themeblvd_jma_secondary_menu_menu_args', 'jma_menu_args_filter');

/**
 * @function jma_reg_menus register the secondary menu
 *
 */
function jma_reg_menus($menus)
{
    $menus['jma_secondary_menu'] = __('Secondary Navigation', 'themeblvd');
    return $menus;
}
add_filter('themeblvd_nav_menus', 'jma_reg_menus');
//end add the secondary menu



/**
 * @function jma_menu_filter add search icon and functionality to main menu
 *
 */
function jma_menu_filter($args)
{
    $content = str_replace(array('"#"', 'tb-search-trigger'), array('"noclick"', 'tb-search-trigger menu-btn'), themeblvd_get_floating_search_trigger($args));
    $args['items_wrap'] = '<ul id="%1$s" class="%2$s">%3$s<li id="menu-search-popup" class="menu-item">' .  $content . '</li></ul>';
    return $args;
}

/**
     * function jma_child_themeblvd_toggle
     * filter toggle ements to replace plus/minus with angle right and down
     * @param $output vaulue from parent theme
     * @return replaced classed (replace panel heading to "break" parent theme jQuery)
     */

function jma_child_themeblvd_toggle($output)
{
    $output = str_replace(array( 'panel-heading','plus-circle', 'minus-circle'), array( 'jma-panel-heading','angle-right', 'angle-down'), $output);
    return $output;
}
/**
 * @function jma_add_title add page title or banner content to the page
 *
 */
if (!function_exists('jma_add_title')) {
    function jma_add_title()
    {
        global $post;
        global $jma_spec_options;
        $title_inner_element = $jma_spec_options['title_page_top'] == 2 && (is_page($post->ID) || is_single($post->ID))? 'h2': 'h1';
        $title_element = $jma_spec_options['title_page_top'] == 2 && (is_page($post->ID) || is_single($post->ID))? 'div': 'header';
        if (get_post_meta(get_the_ID(), '_jma_banner_data_key', true)) {
            $banner_value =  get_post_meta(get_the_ID(), '_jma_banner_data_key', true);
        }
        $banner_text = $banner_value['banner_text'];
        $title = false;
        $opening = '<' . $title_element . ' id="full-page-title"><div id="full-page-title-inner" class="entry-header"><' . $title_inner_element . ' class="entry-title">';
        $closing = '</' . $title_inner_element . '></div></' . $title_element . '><!--full-page-title-->';
        if (is_page() || is_single()) {
            if ($jma_spec_options['title_page_top'] == 1) {
                $title = 'hide' != get_post_meta($post->ID, '_tb_title', true)? get_the_title(): false;
            } elseif ($banner_text) {
                $title = $banner_text;
            } else {
                $title = $jma_spec_options['title_page_top_default_text'];
            }
        } elseif (is_search()) {
            $title = 'Search Results for "' . get_search_query() . '"';
        } elseif (is_tax()) {
            global $wp_query;
            $term = $wp_query->get_queried_object();
            $title = $term->name;
        } elseif (is_archive()) {
            $title = single_cat_title('', false);
        } elseif (is_home()) {
            $blog_page_id = get_option('page_for_posts');
            $title = get_page($blog_page_id)->post_title;
        }
        if ($title) {
            $opening = apply_filters('banner_title_opening_filter', $opening);
            $title = apply_filters('banner_title_filter', $title);
            $closing = apply_filters('banner_title_closing_filter', $closing);
            echo $opening . $title . $closing;
        }
    }
}


/**
 * @function jma_copy_text filter to prepend copyright text with symbol and current year
 *
 */

function jma_copy_text($current)
{
    global $jma_spec_options;
    $current = ($jma_spec_options['footer_copyright'])? $current: '';
    $return = '<div class="clearfix"><div class="float-at-768 col-sm-12">' . $current;
    if ($jma_spec_options['schema_company']) {
        $return .= '<div id="schema_block" class="schema_organization clearfix" itemscope itemtype="http://schema.org/Organization">
			<span class="date">&copy; '. date('Y'). '&nbsp; </span><a class="schema_url" target="_blank" itemprop="url" href="' . $jma_spec_options['schema_url'] . '">
			<span class="schema_name" itemprop="name">' . $jma_spec_options['schema_company'] . '</span>
			</a>';
        if ($jma_spec_options['schema_streetorpobox']) {
            $str_po = jmaStartsWith($jma_spec_options['schema_streetorpobox'], 'P.O. Box')? 'postOfficeBoxNumber': 'streetAddress';
            $return .= ' <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
			 	<div class="street divide-left nowrap" itemprop="' . $str_po . '">' . $jma_spec_options['schema_streetorpobox'] . ' </div><!--postOfficeBoxNumber-->
			 	<div class="city_state">
	                <span class="nowrap">
			 		<span class="locale" itemprop="addressLocality">' . $jma_spec_options['schema_city'] . ', </span>
			 		<span class="region" itemprop="addressRegion"> ' . $jma_spec_options['schema_state'] . '&nbsp;&nbsp;</span>
			 		<span class="postalcode" itemprop="postalCode">' . $jma_spec_options['schema_zip'] . ' </span>
	                </span>
			 	</div>
			 	<meta itemprop="addressCountry" content="' . $jma_spec_options['schema_country'] . '" />
			 </div>';
        }

        if ($jma_spec_options['schema_email']) {
            $return .= '<div class="email divide-left"><a itemprop="email" href="mailto:' . $jma_spec_options['schema_email'] . '">' . $jma_spec_options['schema_email'] . '</a></div>';
        }

        if ($jma_spec_options['schema_phone']) {
            $return .= ' <div class="phone divide-left">Phone:&nbsp;<span class="nowrap" itemprop="telephone">' . $jma_spec_options['schema_phone'] . '</span></div>';
        }
        $return .= '</div>';
        $return .= '</div>';
        $return .= '</div>';
    }
    return $return;
}
/**
 * @function jma_do_floating_search activates the search icon functinality
 *
 */
if (!function_exists('jma_do_floating_search')) {
    function jma_do_floating_search()
    {
        return true;
    }
}

themeblvd_edit_option('layout', 'header_mobile', 'mobile_logo', 'std', 'default');


/**
 * @function jma_header_content_default loop thru the sortable header elements
 * replaces
 * themeblvd_header_content_default on themeblvd_header_content hook
 * and
 * themeblvd_header_menu_default on themeblvd_header_menu hook
 */
function jma_header_content_default()
{
    global $jma_spec_options;

    $items = $jma_spec_options['header_content'];
    //echo '<pre>';print_r($items);echo '</pre>';echo jma_images_on();
    if (is_array($items)) {
        foreach ($items as $item) {

        //build class
            $jma_class = 'jma-header-item ';
            foreach ($item as $selector => $element) {
                if ($element == 1) {
                    $jma_class .= ' ' . $selector;
                }
            }
            $jma_class .= ' ' . $item['header_element'];
            if ($item['menu_align']) {
                $jma_class .= ' ' . $item['menu_align'];
            }
            if ($item['menu_vert_align']) {
                $jma_class .= ' ' . $item['menu_vert_align'];
            }
            if ($jma_spec_options['add_search_popup'] && $item['header_element'] == 'access') {
                $jma_class .= ' has-search';
            }
            if ($item['sidebar']['type']) {
                $jma_class .= ' sidebar';
            }
            if ($item['custom_class']) {
                $jma_class .= ' '. $item['custom_class'];
            }

            //end build class for nav

            $widget_html = '<div class="jma-header-right">' . themeblvd_get_widgets($item['sidebar']['sidebar']) . '</div>';
            if (strpos($item['header_element'], 'content')) {
                // CONTENT CODE CONTENT CODE
                $jma_class .= ' header-content';

                /* opening tag for content */  ?>
			<div class="<?php echo $jma_class ?>" role="banner">

		<?php
            } else {// MENU CODE MENU CODE

                //do_action parent theme code to open menu
                do_action('themeblvd_header_menu_before');

                //build child theme attributes for menu
                $logo_image_data = $item['header_element'] == 'access' && $item['logo']? ' data-logoimageheight="' . $jma_spec_options['logo']['image_height'] . '"': '';

                $kid_sticky_data = $jma_spec_options['child_sticky_menu']? ' data-usechildsticky="true"': '';

                echo '<nav id="' . $item['header_element'] . '" class="header-nav ' . $jma_class . '" role="navigation"' .  $logo_image_data . $kid_sticky_data . '>';
            }


            // CODE FOR ALL ELEMENTS (at this point we have opening tags )

            /* this will either build simple header content then underlay image or add menu (with logo if called for) */
            if ((strpos($item['header_element'], 'access')!== false) || $item['logo'] || $item['sidebar']['type']) {
                ?>

			<div class="wrap clearfix"><div class="clearfix"><div class="clearfix">
				<?php
                /**
                 * @hooked themeblvd_header_logo_default - 10
                 */
                if ($item['logo']) {//maybe logo followed by either menu or sidebar or neither
                    do_action('themeblvd_header_logo');
                }
                if ($item['sidebar']['type']) {
                    echo $widget_html;
                }
                if (!strpos($item['header_element'], 'content')) {//cant have menu with sidebar
                    $menu = $item['header_element'] == 'access'? 'primary': 'jma_secondary_menu';
                    wp_nav_menu(themeblvd_get_wp_nav_menu_args($menu));
                    do_action('themeblvd_header_menu_addon');
                } ?>
			</div></div></div><!-- .wrap (end) -->

			<?php
            }// end this will either build simple header content then underlay image or add menu (with logo if called for)
            //adds all the image code here (image is considered a content item)
            if ($item['header_element'] == 'image jma-header-content' && jma_images_on()) {
                do_action('jma_header_image');
            }

            if (strpos($item['header_element'], 'content')) {/* closing element for content*/ ?>
			</div><!-- .header-content (end) -->
		<?php
            } else {// closing elements for nav?>
			</nav><!-- access -->
			<div style="clear:both"></div>
		<?php do_action('themeblvd_header_menu_after');
            }
        }
    }
}

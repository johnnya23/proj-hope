<?php
// $dynamic_styles is filterable with examples at top of functions-site-specific-special-options.php
// filtering is preferable to altering this file for the sake of updates.
$dynamic_styles = array();


// FORMAT FOR INPUT
// $dynamic_styles[] = array($selector, array($property, $value)[,array($property, $value)...])

//in format above format media queries  i.e. max-768@$selector, ...
// $dynamic_styles[] = array(max(or min)-$width@$selector, array($property, $value)[,array($property, $value)...])


$base_menus = ' body #branding > .wrap ';//d.wrap only applies to main menu
$ul = '.header-nav .wrap ul.sf-menu ';//remove .header-nav
$main_bg = '.header-nav';
$body_shape = $jma_spec_options['body_shape'];
if ($jma_spec_options['style_sticky']) {
    $base_menus = ' body #branding > div ';//div is general enough to apply to both sticky and main menus
    $ul = '.wrap ul.sf-menu ';
    $main_bg = '.header-nav, #sticky-menu';
    if ($jma_spec_options['style_sticky'] == 2) {
        $main_bg = '.header-nav';
        $dynamic_styles[10] =  array('#sticky-menu ' . $ul . ' > ' . 'li > a',
            array('color', $jma_spec_options['typography_header_color'] . '!important')
        );
    }
} else {
    $dynamic_styles[10] =  array('#sticky-menu .wrap ul.sf-menu ' . 'li  a:hover',
        array('opacity','0.6')
    );
}
if ($jma_spec_options['style_sticky'] != 1) {
    $dynamic_styles[20] =  array('#sticky-menu' ,
        array('-webkit-box-shadow', '0px 2px 15px 0px rgba(0,0,0,0.4)'),
        array('-moz-box-shadow', '0px 2px 15px 0px rgba(0,0,0,0.4)'),
        array('box-shadow', '0px 2px 15px 0px rgba(0,0,0,0.4)'),
    );
    if (!$jma_spec_options['style_sticky']) {
        $dynamic_styles[30] =  array('#sticky-menu ul .sf-mega, #sticky-menu ul .non-mega-sub-menu' ,
            array('-webkit-box-shadow', '0px 2px 15px 0px rgba(0,0,0,0.4)'),
            array('-moz-box-shadow', '0px 2px 15px 0px rgba(0,0,0,0.4)'),
            array('box-shadow', '0px 2px 15px 0px rgba(0,0,0,0.4)'),
        );
    }
}
$dynamic_styles[40] =  array($main_bg ,
    array('background-color', $jma_spec_options['menu_background_color']),
    array('border-top', 'solid 1px ' . $jma_spec_options['menu_background_color']),
    array('border-bottom', 'solid 1px ' . $jma_spec_options['menu_background_color'])
);
$dynamic_styles[50] =  array('#access.fix-menu' ,// add child sticky-menu
    array('background-color', get_trans($jma_spec_options['menu_background_color'], 0.9))
);
if ($root_off) {
    $dynamic_styles[60] =  array('#access.fix-menu' ,// add child sticky-menu when menu root bg off selected
        array('background-color', get_trans($jma_spec_options['header_background_color'], 0.9) . '!important')
    );
}
if ($jma_spec_options[ 'body_shape' ] == 'boxed' || $jma_spec_options[ 'body_shape' ] == 'dark_modular') {
    $dynamic_styles[70] =  array('min-' . ($jma_spec_options['site_width']+55) . '@#access.fix-menu' ,
        array('width', ($jma_spec_options['site_width']) . 'px')
    );
    $dynamic_styles[80] =  array('max-' . ($jma_spec_options['site_width']+54) . '@#access.fix-menu' ,
        array('left', '20px'),
        array('right', '20px')
    );
    $dynamic_styles[80] =  array('.footer-content>.wrap>.row' ,
        array('margin', '0!important')
    );
}
$dynamic_styles[90] =  array(' body #branding > .wrap ' . $ul . ' > ' . 'li',
    array('border-left', 'solid 1px ' . $jma_spec_options['menu_background_color'])
);
$dynamic_styles[100] =  array($base_menus . $ul . ' > ' . 'li:first-child',
    array('border-left', 'none')
);
$dynamic_styles[110] =  array($base_menus . $ul . 'li a, ' . $base_menus . $ul . 'li .mega-section-header, ' . $base_menus . $ul . 'li .mega-section-header:hover a',
    array('color', $jma_spec_options['menu_font_color'] )
);//body #branding > .wrap .header-nav .wrap ul.sf-menu li a
$dynamic_styles[115] =  array($base_menus . '.remove_root_bg ' . $ul . '>li> a ',
    array('color', $jma_spec_options['header_font_color'])
);
$dynamic_styles[120] =  array($base_menus . $ul . 'li.current_page_item > a, ' . $base_menus . $ul . 'li.current-menu-item > a, ' . $base_menus . $ul . 'li.current-menu-ancestor > a, ' . $base_menus . $ul . 'li.current-post-parent > a, ' . $base_menus . $ul . 'li.current-menu-parent > a, ' . $base_menus . $ul . 'li.current-menu-item > a:hover',
    array('color', $jma_spec_options['menu_font_current'] . '!important'),
    array('background-color', $jma_spec_options['menu_background_current'])
);
$dynamic_styles[130] =  array($base_menus . $ul . 'li a:hover',
    array('color', $jma_spec_options['menu_font_hover']),
    array('background-color', $jma_spec_options['menu_background_hover'])
);
if ($jma_spec_options['menu_item_highlight']) {
    $padding_adjust_for_top_highlite = $padding_adjust_for_bottom_highlite = 0;
    if ($jma_spec_options['menu_item_highlight'] == 'top') {
        $padding_adjust_for_top_highlite =  -4;
    } else {
        $padding_adjust_for_bottom_highlite = -4;
    }
    $dynamic_styles[140] =  array($base_menus . $ul .'> '. 'li > a',
        array('border-' . $jma_spec_options['menu_item_highlight'] . '-style', 'solid'),
        array('border-' . $jma_spec_options['menu_item_highlight'] . '-width', '4px'),
        array('border-' . $jma_spec_options['menu_item_highlight'] . '-color', 'transparent')
    );
    $dynamic_styles[150] =  array($base_menus . $ul .'> '. 'li.current_page_item > a, ' . $base_menus . $ul .'> '. 'li.current-menu-item > a, ' . $base_menus . $ul .'> '. 'li.current-menu-ancestor > a, ' . $base_menus . $ul .'> '. 'li.current-post-parent > a, ' . $base_menus . $ul .'> '. 'li.current-menu-parent > a, ' . $base_menus . $ul .'> '. 'li.current-menu-item > a:hover',
        array('border-' . $jma_spec_options['menu_item_highlight'] . '-color', $jma_spec_options['menu_font_current'])
    );
    $dynamic_styles[160] =  array($base_menus . $ul .'> '. 'li > a:hover',
        array('border-' . $jma_spec_options['menu_item_highlight'] . '-color', $jma_spec_options['menu_font_hover'])
    );
}
$logo_padding_adjustment = 8;//this value equals top and bottom padding of .site-logo
$logo_padding_adjustment = apply_filters('logo_padding_adjustment_filter', $logo_padding_adjustment);/* in case you manually change the verical padding on thelogo */
switch ($jma_spec_options['logo']['type']) {
    case 'image':
        $logo_height = $jma_spec_options['logo']['image_height'] + $logo_padding_adjustment;
        break;
    case 'title':
        $logo_height = 33 + $logo_padding_adjustment;
        break;
    default:
        $logo_height = 57 + $logo_padding_adjustment;
}
$dynamic_styles[170] =  array($base_menus . 'ul.sf-menu > li > a',
    array('padding-left', $jma_spec_options['menu_item_padding'] . 'px'),
    array('padding-right', $jma_spec_options['menu_item_padding'] . 'px'),
    array('padding-top', $jma_spec_options['menu_item_vert_padding'] + $padding_adjust_for_top_highlite . 'px'),
    array('padding-bottom', $jma_spec_options['menu_item_vert_padding'] + $padding_adjust_for_bottom_highlite . 'px')
);
if ($logo_in_menu) {
    $logo_height = apply_filters('logo_height_filter', $logo_height);
    $menu_logo_vert_padding = ($logo_height - $jma_spec_options['menu_font_size'])/2;

    $dynamic_styles[190] =  array($base_menus . '.middle ul.sf-menu > li > a',
        array('padding-top', $menu_logo_vert_padding + $padding_adjust_for_top_highlite . 'px'),
        array('padding-bottom', $menu_logo_vert_padding + $padding_adjust_for_bottom_highlite . 'px')
    );
    $dynamic_styles[200] =  array($base_menus . '.bottom ul.sf-menu',
        array('margin-top', ($logo_height - $jma_spec_options['menu_font_size'] - $jma_spec_options['menu_item_vert_padding']*2) . 'px' )
    );
    $dynamic_styles[210] =  array($base_menus . '.fix-menu ul.sf-menu > li > a, ' . $base_menus . '.slide-menu ul.sf-menu > li > a',
        array('padding-top', $jma_spec_options['menu_item_vert_padding'] + $padding_adjust_for_top_highlite . 'px'),
        array('padding-bottom', $jma_spec_options['menu_item_vert_padding'] + $padding_adjust_for_bottom_highlite . 'px')
    );
    $dynamic_styles[220] =  array($base_menus . '.header-nav.fix-menu.middle .header_logo_image img',
        array('height', (($jma_spec_options['menu_item_vert_padding']*2 + $jma_spec_options['menu_font_size'])-4) . 'px!important'),
        array('width', 'auto')
    );
    $dynamic_styles[230] =  array('max-' . ($jma_spec_options['site_width'] +20) . '@.header-nav.sidebar .jma-header-right',
        array('right', '20px!important'),
    );
}

$dynamic_styles[240] =  array($base_menus . 'ul.sf-menu ul, '. $base_menus . 'ul.sf-menu .sf-mega',
    array('background-color', $jma_spec_options['menu_background_color']),
    array('background-color', get_tint($jma_spec_options['menu_background_color'], 0.9)),
    array('border-color', $jma_spec_options['menu_background_color'])
);

$dynamic_styles[250] =  array($base_menus . '#access .header_logo_image img',
    array('height', $jma_spec_options['logo']['image_height'] . 'px'),
    array('width', 'auto')
);
$dynamic_styles[260] =  array('.sf-menu li .menu-btn, .sf-menu ul.sub-menu .menu-btn, .sf-menu .mega-section-header',
    array('font-size', $jma_spec_options['menu_font_size'] . 'px')
);

if ($body_shape == 'dark_modular' || $body_shape == 'boxed') {
    $dynamic_styles[270] = array(' .tb-sticky-menu > .wrap',
        array('margin-left', 'auto'),
        array('margin-right', 'auto'),
        array('max-width', $jma_spec_options['site_width'].'px')
    );
}


// end menu display


//define arrays for fonts
$font_selectors = array(
    'body',
    '.header-font, h1, h2, h3, h4, h5, h6,.text-dark h1, .text-dark h2, .text-dark h3, .text-dark h4, .text-dark h5, .text-dark h6, #access .tb-primary-menu li a, #access2 .tb-secondary-menu li a, .tb-sticky-menu .tb-primary-menu li a.menu-btn, .tb-sticky-menu .tb-primary-menu ul.sub-menu li a.menu-btn, .tb-sticky-menu .tb-primary-menu .mega-section-header',
    '.special-font',
);
$body_input =  $jma_spec_options['typography_body'];
$header_input =  $jma_spec_options['typography_header'];
$special_input =  $jma_spec_options['typography_special'];

$body_input['color'] =  $jma_spec_options['typography_body_color'];
$header_input['color'] =  $jma_spec_options['typography_header_color'];
$special_input['color'] =  $jma_spec_options['typography_special_color'];
$font_input = array(
    $body_input,
    $header_input,
    $special_input,
);

foreach ($font_selectors as $key => $font) {
    $x = font_handler($font_input[$key]);
    $dynamic_styles['menu'.$key] = array(
        $font, $x[0],$x[1]
    );
}

$dynamic_styles[1000] = array('.btn, .btn-primary, body .theme-default .nivo-caption a.btn, body .search, .tb-button, .comment-reply-link, #comments .comment-body .reply a, .btn:focus, .tb-button:focus, .comment-reply-link:focus, #comments .comment-body .reply a:focus, input[type="submit"], button[type="submit"]',
    array('color', $jma_spec_options['button_font']),
    array('background-color',  $jma_spec_options['button_back']),
    array('border-color', $jma_spec_options['button_font']),
    array('border','solid!important'),
);
$border_array = get_tint($jma_spec_options['typography_body_color']);
$dynamic_styles[1010] = array('textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"], .uneditable-input, select',
    array('border-color', $border_array['light_hex'])
);
$dynamic_styles[1020] = array('.btn:hover, body .theme-default .nivo-caption a.btn:hover, .btn:focus, .btn:active, .btn.active, .btn-primary:hover, .tb-button:hover, .comment-reply-link:hover, #comments .comment-body .reply a:hover, input[type="submit"]:hover',
    array('color', $jma_spec_options['button_font_hover']),
    array('background-color',  $jma_spec_options['button_back_hover']),
    array('border-color', $jma_spec_options['button_font_hover']),
);

//  page background display
if ($body_shape == 'dark_modular') {
    $page_selectors ='#content > .inner, .fixed-sidebar .fixed-sidebar-inner, .outside-sidebar-widget-wrap, #custom-main';
} elseif (($jma_spec_options['jma_high_sidebar'] == 'left' || $jma_spec_options['jma_high_sidebar'] == 'right')) {
    $page_selectors ='#container';
} elseif ($body_shape == 'boxed') {
    $page_selectors ='#main> .wrap, #custom-main';
} elseif ($body_shape == 'stretch_bordered') {
    $page_selectors ='#main> .wrap, .jma-custom-wrap';
} else {//stretch
    $page_selectors ='body #wrapper';
}
$dynamic_styles[1030] = array($page_selectors . ',.tb-sticky-menu, .tb-primary-menu ul.non-mega-sub-menu, .tb-primary-menu .sf-mega',
    array('background', $jma_spec_options['site_page_color'])
);
// end page background display

//  header image display
/*  adjust for full width image  */

$dynamic_styles[2020] = array('.jma-header-image-wrap',
    array('border-color', $jma_spec_options['header_image_border_color']),
    array('border-width', $jma_spec_options['header_image_border_width'] . 'px'),
    array('border-style', 'solid')
);

// end header image display

//page border display
if ($body_shape == 'boxed') {
    $border_selector = '#container';
}
if ($body_shape == 'stretch_bordered') {
    $border_selector = '#main > .wrap, .sidebar-layout-full_width .jma-custom-wrap';
}
if ($body_shape == 'dark_modular') {
    $border_selector = '#top #branding, .site-footer, #content > .inner, .sidebar-layout-full_width #custom-main, .fixed-sidebar .fixed-sidebar-inner, .outside-sidebar-widget-wrap';
}
if ($body_shape != 'stretch') {
    if ($jma_spec_options['border_shadow'] == 'on') {
        $dynamic_styles[3060] = array($border_selector,
            array('-moz-box-shadow', '0 2px 10px ' . $jma_spec_options['footer_background_color']),
            array('-webkit-box-shadow', '0 2px 10px ' . $jma_spec_options['footer_background_color']),
            array('box-shadow', '0 2px 10px ' . $jma_spec_options['footer_background_color'])
        );
    }
}

if ($body_shape == 'boxed') {
    $dynamic_styles[3000] = array($border_selector,
        array('max-width', $jma_spec_options['site_width'].'px'),
        array('margin-left', 'auto'),
        array('margin-right', 'auto'),
        array('border', 'solid 1px ' . $jma_spec_options['footer_background_color'])
    );
    $dynamic_styles[3010] = array('.site-main  #sidebar_layout',
        array('padding', '0 20px')
    );
    $dynamic_styles[3020] = array('.tb-sticky-menu',
        array('margin-left', '-50%'),
        array('max-width', ($jma_spec_options['site_width']) .'px'),
        array('left', '50%')
    );
    $dynamic_styles[3030] = array('min-' . $jma_spec_options['site_width'] . '@.tb-sticky-menu',
        array('margin-left', '-' . ($jma_spec_options['site_width']/2) .'px'),
    );
}
if ($body_shape == 'stretch_bordered') {
    $dynamic_styles[3040] = array($border_selector,
        array('border-left', 'solid 1px ' . $jma_spec_options['footer_background_color']),
        array('border-right', 'solid 1px ' . $jma_spec_options['footer_background_color'])
    );
    $dynamic_styles[3050] = array('.site-main  #sidebar_layout',
        array('padding', '0 20px')
    );
}
if ($body_shape == 'dark_modular') {
    $dynamic_styles[3070] = array('#top,  #custom-main, #main , #bottom',
        array('max-width', $jma_spec_options['site_width'].'px'),
        array('margin-left', 'auto'),
        array('margin-right', 'auto'),
    );
}
//end page border display

//stretch specific styles
if (($body_shape == 'stretch' || $body_shape == 'stretch_bordered') && $jma_spec_options['jma_high_sidebar'] == 'none') {
    $dynamic_styles[3080] = array('#container',
        array('-moz-box-shadow', 'none'),
        array('-webkit-box-shadow', 'none'),
        array('box-shadow', 'none')
    );
    $dynamic_styles[3090] = array('#wrapper',
        array('padding', '0 ')/* Lose gutters on sides as window shrinks */
    );
    $dynamic_styles[3100] = array('#access > div, #access2 > div, .tb-sticky-menu > .wrap',
        array('margin-left', 'auto'),
        array('margin-right', 'auto'),
        array('max-width', ($jma_spec_options['site_width']).'px')
    );
    if ($body_shape == 'stretch') {
        $dynamic_styles[3110] = array('.header-top > .wrap, .header-above > .wrap, .header-content,.header-content.image .wrap>div>div, #main, .element-section > .element, .site-footer > .wrap > div > .wrap',
            array('margin-left', 'auto'),
            array('margin-right', 'auto'),
            array('max-width', ($jma_spec_options['site_width'] + 40).'px'),
            array('padding-left', '20px'),
            array('padding-right', '20px')
        );
        $dynamic_styles[3120] = array('.element-section',
            array('padding-left', ' 0'),
            array('padding-right', ' 0')
        );
    } else {
        $dynamic_styles[3130] = array('.header-top > .wrap, .header-above > .wrap, .header-content,.header-content.image .wrap>div>div, #main, #custom-main, .site-footer > .wrap > div > .wrap',
            array('margin-left', 'auto'),
            array('margin-right', 'auto'),
            array('max-width', ($jma_spec_options['site_width'] + 40).'px'),
            array('padding-left', '20px'),
            array('padding-right', '20px')
        );
    }
}
//end stretch specific

// extra sidebar specific styles
if ($jma_spec_options['jma_high_sidebar'] != 'none') {
    $dynamic_styles[4000] = array('#container',
        array('max-width', $jma_spec_options['site_width'].'px'),
        array('margin-left', 'auto'),
        array('margin-right', 'auto')
    );
    $opposite = $jma_spec_options['jma_high_sidebar'] == 'left' ? 'right': 'left';
    $dynamic_styles[4010] = array('.jma-outside-sidebar',
        array('width', '25%'),
        array('float', $jma_spec_options['jma_high_sidebar'])
    );
    $dynamic_styles[4020] = array('.outside-sidebar-inner',
        array('margin-bottom', '-25000px'),
        array('padding-bottom', '25000px'),
        array('border-color', $jma_spec_options['menu_background_color'])
    );
    $dynamic_styles[4030] = array('.outside-sidebar-widget-wrap',
        array('margin-bottom', '20px')
    );
    $dynamic_styles[4040] = array('min-900@#top, #custom-main, #main , #full-page-title',
        array('width', '75%'),
        array('float', $opposite)
    );
    $dynamic_styles[4050] = array('min-900@#full-page-title',
        array('width', '100%')
    );
    $dynamic_styles[4060] = array('#custom-main, #main ',
        array('clear', 'none')
    );
    $dynamic_styles[4070] = array('#main > div, #custom-main .element-section',
        array('border', 'none'),
        array('background', 'none'),
        array('margin', '0 ')
    );
    $hidden = $body_shape != 'dark_modular'?'hidden': 'visible';
    $dynamic_styles[4080] = array('#container',
        array('position', 'relative'),
        array('overflow', $hidden)
    );
    $dynamic_styles[4090] = array('#bottom',
        array('position', 'relative'),
        array('clear', 'both'),
        array('z-index', '1000')
    );
    if ($body_shape != 'dark_modular') {
        $dynamic_styles[4100] = array('.outside-sidebar-inner',
            array('padding-top', '20px'),
            array('padding-left', '20px'),
            array('padding-right', '20px'),
            array('border-'.$opposite.'-style', 'solid'),
            array('border-'.$opposite.'-width', '1px')
        );
    } else {
        $dynamic_styles[4110] = array('max-900@.outside-sidebar-inner',
            array('padding-'.$opposite, ' 0')
        );
        $dynamic_styles[4120] = array('min-900@.outside-sidebar-inner',
            array('margin-top', ' 0')
        );
    }
    $dynamic_styles[4130] = array('max-900@.jma-outside-sidebar, #top, #custom-main, #main ',
        array('width', '100%'),
        array('clear', 'both'),
        array('float', 'none')
    );
    $dynamic_styles[4140] = array('max-900@.jma-outside-sidebar div.widget',
        array('width', '30%'),
        array('margin-left', '2%'),
        array('float', 'left')
    );
    $dynamic_styles[4150] = array('max-900@.outside-sidebar-inner',
        array('border-'.$opposite.'-width', ' 0')
    );
}
//end extra sidebar specific

// creases for non-dark modular
$split_value =  768;
if ($body_shape != 'dark_modular') {
    if (!$jma_spec_options['title_page_top'] || $body_shape == 'stretch') {
        $dynamic_styles[5000] = array('#main > .wrap',//before we get to the creases
        array('padding', '30px 0')
    );
    } else {
        $dynamic_styles[5005] = array('.site-main  #sidebar_layout',//before we get to the creases
    array('padding-top', '30px')
);
    }
    if ($jma_spec_options['side_creases_off'] == 0) {
        $dynamic_styles[5010] = array('min-' . $split_value . '@div.sidebar_right div.right-sidebar div.fixed-sidebar-inner, div.double_sidebar_right div.left-sidebar div.fixed-sidebar-inner, div.double_sidebar div.right-sidebar div.fixed-sidebar-inner',
            array('background-image', 'url(' . $css_uri . 'images/sidebar-fold/sidebar-right.png)'),
            array('background-repeat', 'repeat-y'),
            array('background-position', 'top left'),
            array('position', 'relative')
        );
        $dynamic_styles[5020] = array('min-' . $split_value . '@div.sidebar_right div.right-sidebar div.fixed-sidebar-inner::before, div.double_sidebar_right div.left-sidebar div.fixed-sidebar-inner::before, div.double_sidebar div.right-sidebar div.fixed-sidebar-inner::before',
            array('content', '""'),
            array('background-image', 'url(' . $css_uri . 'images/sidebar-fold/sidebar-right-top.png)'),
            array('background-repeat', 'no-repeat'),
            array('background-position', 'top left'),
            array('display', 'block'),
            array('position', 'absolute'),
            array('top', '-50px'),
            array('left', ' 0'),
            array('width', '9px'),
            array('height', '50px')
        );
        $dynamic_styles[5030] = array('min-' . $split_value . '@div.sidebar_right div.right-sidebar div.fixed-sidebar-inner::after, div.double_sidebar_right div.left-sidebar div.fixed-sidebar-inner::after, div.double_sidebar div.right-sidebar div.fixed-sidebar-inner::after',
            array('content', '""'),
            array('background-image', 'url(' . $css_uri . 'images/sidebar-fold/sidebar-right-bottom.png)'),
            array('background-repeat', 'no-repeat'),
            array('background-position', 'bottom left'),
            array('display', 'block'),
            array('position', 'absolute'),
            array('bottom', '-50px'),
            array('left', ' 0'),
            array('width', '9px'),
            array('height', '50px')
        );
        $dynamic_styles[5040] = array('min-' . $split_value . '@div.sidebar_left div.left-sidebar div.fixed-sidebar-inner, div.double_sidebar_left div.right-sidebar div.fixed-sidebar-inner, div.double_sidebar div.left-sidebar div.fixed-sidebar-inner',
            array('background-image', 'url(' . $css_uri . 'images/sidebar-fold/sidebar-left.png)'),
            array('background-repeat', 'repeat-y'),
            array('background-position', 'top right'),
            array('position', 'relative')
        );
        $dynamic_styles[5050] = array('min-' . $split_value . '@div.sidebar_left div.left-sidebar div.fixed-sidebar-inner::before, div.double_sidebar_left div.right-sidebar div.fixed-sidebar-inner::before, div.double_sidebar div.left-sidebar div.fixed-sidebar-inner::before',
            array('content', '""'),
            array('background-image', 'url(' . $css_uri . 'images/sidebar-fold/sidebar-left-top.png)'),
            array('background-repeat', 'no-repeat'),
            array('background-position', 'top right'),
            array('display', 'block'),
            array('position', 'absolute'),
            array('top', '-50px'),
            array('right', ' 0'),
            array('width', '9px'),
            array('height', '50px')
        );
        $dynamic_styles[5060] = array('min-' . $split_value . '@div.sidebar_left div.left-sidebar div.fixed-sidebar-inner::after, div.double_sidebar_left div.right-sidebar div.fixed-sidebar-inner::after, div.double_sidebar div.left-sidebar div.fixed-sidebar-inner::after',
            array('content', '""'),
            array('background-image', 'url(' . $css_uri . 'images/sidebar-fold/sidebar-left-bottom.png)'),
            array('background-repeat', 'no-repeat'),
            array('background-position', 'bottom right'),
            array('display', 'block'),
            array('position', 'absolute'),
            array('bottom', '-50px'),
            array('right', ' 0'),
            array('width', '9px'),
            array('height', '50px')
        );
        $dynamic_styles[5070] = array('.fixed-sidebar .widget:last-child',
            array('padding-bottom', ' 0')
        );
        $dynamic_styles[5080] = array('.fixed-sidebar',
            array('margin-bottom', '30px')
        );
    } elseif (($jma_spec_options['side_creases_off'] == 1)) {
        $dynamic_styles[5090] = array('min-' . $split_value . '@div.sidebar_left div.left-sidebar div.fixed-sidebar-inner, div.double_sidebar_left div.right-sidebar div.fixed-sidebar-inner, div.double_sidebar div.left-sidebar div.fixed-sidebar-inner',
            array('border-right', '1px solid '. $jma_spec_options['footer_background_color'])
        );
        $dynamic_styles[5100] = array('min-' . $split_value . '@div.sidebar_right div.right-sidebar div.fixed-sidebar-inner, div.double_sidebar_right div.left-sidebar div.fixed-sidebar-inner, div.double_sidebar div.right-sidebar div.fixed-sidebar-inner',
            array('border-left', '1px solid '. $jma_spec_options['footer_background_color'])
        );
    }
    $dynamic_styles[5110] = array('div.fixed-sidebar-inner',
        array('margin-top', '30px')
    );
    $dynamic_styles[5120] = array('min-' . $split_value . '@div.sidebar_left div.left-sidebar div.fixed-sidebar-inner, div.double_sidebar_left div.right-sidebar div.fixed-sidebar-inner, div.double_sidebar div.left-sidebar div.fixed-sidebar-inner',
        array('padding-right', '20px')
    );
    $dynamic_styles[5130] = array('min-' . $split_value . '@div.sidebar_right div.right-sidebar div.fixed-sidebar-inner, div.double_sidebar_right div.left-sidebar div.fixed-sidebar-inner, div.double_sidebar div.right-sidebar div.fixed-sidebar-inner',
        array('padding-left', '20px')
    );// end creases for non-dark modular
} else {// dark modular specific styles
    $dynamic_styles[6000] = array('#custom-main, #main ',
        array('margin', '20px auto')
    );
    $dynamic_styles[6010] = array('#custom-main .element-section',
        array('padding', '20px')
    );
    $dynamic_styles[6020] = array('.outside-sidebar-inner',
        array('padding-top', '0 '),
        array('padding-'.$jma_spec_options['jma_high_sidebar'], '0 '),
        array('padding-'.$opposite, '12.5%')
    );
    $dynamic_styles[6030] = array('.outside-sidebar-inner',
        array('margin-top', '20px')
    );
    $dynamic_styles[6040] = array('.outside-sidebar-widget-wrap',
        array('padding', '20px')
    );
    $dynamic_styles[6050] = array('#content > .inner, .fixed-sidebar .fixed-sidebar-inner',
        array('padding', '20px')
    );
    $dynamic_styles[6060] = array('#bottom',
        array('margin-bottom', '20px')
    );
    if ($jma_spec_options['jma_high_sidebar'] != 'none') {
        $dynamic_styles[6070] = array('.tb-sticky-menu',
            array('left', ' 0')
        );
    }
    $dynamic_styles[6080] = array('max-768@.outside-sidebar-inner',
        array('padding-'.$opposite, ' 0')
    );
}
// end dark modular specific
// title to top styles
if ($jma_spec_options['title_page_top']) {
    if ($body_shape == 'stretch') {
        $dynamic_styles[7000] = array('#full-page-title-inner h1, #full-page-title-inner h2',
            array('max-width', $jma_spec_options['site_width'] . 'px'),
            array('margin-left', 'auto'),
            array('margin-right', 'auto'),
            array('margin-bottom', '0 ')
        );
    }
    $banner_padding_top = $jma_spec_options['banner_shadows']? '10px': ' 0';
    $dynamic_styles[7010] = array('#full-page-title',
        array('padding-top', $banner_padding_top),
        array('padding-bottom', '5px'),
        array('background', $jma_spec_options['site_page_color']),
        array('position', 'relative'),
        array('z-index', '0'),
        array('overflow', 'hidden')
    );


    $banner_padding_x = $body_shape == 'stretched'? ' 0': ' 20px';
    $banner_border_color = $jma_spec_options['banner_bg_color']? $jma_spec_options['banner_bg_color']: $jma_spec_options['footer_background_color'];
    $banner_shadow_color = $jma_spec_options['banner_bg_color']? '#000000': $jma_spec_options['footer_background_color'];
    if (!$jma_spec_options['banner_shadows']) {
        $banner_border_style = array('#full-page-title-inner',
            array('padding', $jma_spec_options['banner_height'] . 'px' . $banner_padding_x),
            array('border-top', 'solid 1px ' . $banner_border_color),
            array('border-bottom', 'solid 1px ' . $banner_border_color)
        );
    } else {
        $banner_border_style = array('#full-page-title-inner',
            array('padding', $jma_spec_options['banner_height'] . 'px' . $banner_padding_x),
            array('-moz-box-shadow', '0 0 10px ' . $banner_shadow_color),
            array('-webkit-box-shadow', '0 0 10px ' . $banner_shadow_color),
            array('box-shadow', '0 0 10px ' . $banner_shadow_color)
        );
    }
    $dynamic_styles[7020] = $banner_border_style;


    if ($jma_spec_options['banner_bg_image'] || $jma_spec_options['banner_bg_color']) {
        $banner_image = $jma_spec_options['banner_bg_image']? 'url("'. $jma_spec_options['banner_bg_image'] . '")': 'none';
        $dynamic_styles[7030] = array('#full-page-title-inner',
            array('background-image', $banner_image),
            array('background-repeat', $jma_spec_options['banner_bg_repeat']),
            array('background-color', $jma_spec_options['banner_bg_color']),
            array('background-position', 'center'),
        );
    }
    if ($jma_spec_options['banner_font_color']) {
        $dynamic_styles[7040] = array('#full-page-title-inner h1, #full-page-title-inner h2',
            array('color', $jma_spec_options['banner_font_color'])
        );
    }
    $dynamic_styles[7050] = array('#full-page-title-inner h1, #full-page-title-inner h2',
        array('font-size', $jma_spec_options['banner_font_size'] . 'px'),
        array('line-height', '1'),
        array('margin-left', 'auto'),
        array('margin-right', 'auto')
    );
    if ($jma_spec_options['title_page_top'] == 1) {
        $dynamic_styles[7060] = array('#content .inner',
            array('margin-top', '30px')
        );
    }
}
// general site display (all options)
if ($jma_spec_options['body_bg']) {
    $bg_size = $jma_spec_options['body_bg_repeat'] == 'no-repeat' ? array('background-size', '100% auto'): '';
    $dynamic_styles[9000] = array('html',
        array('background-image', 'url("'. $jma_spec_options['body_bg'] . '")'),
        array('background-repeat', $jma_spec_options['body_bg_repeat']),
        array('background-attachment', 'fixed'),
        array('background-position', 'center'),
        $bg_size
    );
}
$dynamic_styles[9010] = array('.entry-title a, h1 a, h2 a, h3 a, a, .breadcrumb>li+li:before, .widget_categories a:not(:hover), .widget_archive a:not(:hover), .widget_pages a:not(:hover), .widget_nav_menu a:not(:hover), .widget_recent_entries a:not(:hover), .widget_meta a:not(:hover), .widget_rss a:not(:hover)',
    array('color', $jma_spec_options['link_font_color'])
);
$dynamic_styles[9020] = array('.entry-title a:hover, h1 a:hover, h2 a:hover, h3 a:hover, a:hover',
    array('color', $jma_spec_options['hover_font_color'])
);
$dynamic_styles[9030] = array('#branding',
    array('background', $jma_spec_options['header_background_color']),
    array('color', $jma_spec_options['header_font_color'])
);
$dynamic_styles[9040] = array('.site-footer,  .header-top, .mobile-nav, .tb-mobile-panel ',
    array('background-color', $jma_spec_options['footer_background_color']),
    array('color', $jma_spec_options['footer_font_color']),
);

$dynamic_styles[9050] = array('.site-footer a,.header-top a, .header-top .tb-social-icons>li>a, .header-top-nav .tb-search-trigger, .header-top-nav .tb-cart-trigger , .tb-mobile-panel .tb-mobile-menu>li>.menu-btn, .tb-mobile-panel .tb-mobile-menu>li>.menu-btn:hover, .tb-mobile-panel .tb-mobile-menu>li>.menu-btn:focus, .tb-mobile-panel .tb-mobile-menu>li>.menu-btn:active, .tb-nav-trigger:hover .hamburger span,.tb-mobile-panel .header-text, .tb-social-icons.light>li>a ',
    array('color', $jma_spec_options['footer_font_color']),
);

$dynamic_styles[9060] = array('.tb-mobile-panel .tb-mobile-menu>li>.menu-btn, .tb-mobile-panel .tb-mobile-menu>li>.menu-btn:hover, .tb-mobile-panel .tb-mobile-menu>li>.menu-btn:focus, .tb-mobile-panel .tb-mobile-menu>li>.menu-btn:active,  .tb-nav-trigger:hover, .mobile-nav>li>a ',
    array('background-color', $jma_spec_options['footer_background_color']),
);
$dynamic_styles[9070] = array('.tb-thumb-link .thumb-link-icon',
    array('background-color', get_trans($jma_spec_options['footer_background_color'], 0.6)),
);

$dynamic_styles[9080] = array('.tb-nav-trigger:hover .hamburger span, .tb-nav-trigger .hamburger span',
    array('background-color', get_trans($jma_spec_options['footer_font_color']), 0.9),
);

$dynamic_styles[9090] = array('html',
    array('background-color', $jma_spec_options['site_background_color'])
);
if ($body_shape == 'stretch_bordered' || $body_shape == 'stretch') {
    $dynamic_styles[9100] = array('#wrapper',
        array('background-color', $jma_spec_options['site_background_color'])
    );
    $dynamic_styles[9110] = array('html',
        array('background-color', $jma_spec_options['footer_background_color'])
    );
}
$dynamic_styles[9120] = array('.element-section',
    array('padding-bottom', $jma_spec_options['builder_section_vert']),
    array('padding-top', $jma_spec_options['builder_section_vert'])
);
$dynamic_styles[9130] = array('.element-section>.element, .element-columns .element',
    array('margin-bottom', $jma_spec_options['builder_element_vert'])
);
$site_width = $jma_spec_options['site_width'];
if (array_key_exists('social_media_pos', $jma_spec_options) && $jma_spec_options['social_media_pos']) {
    $site_width = $jma_spec_options['social_media_pos']['wp_footer']? $jma_spec_options['site_width']+25: $jma_spec_options['site_width'];
}
$dynamic_styles = apply_filters('dynamic_styles_filter', $dynamic_styles);
$jma_css_values =  generic_output($dynamic_styles);
/* create html output from  $jma_css_values */

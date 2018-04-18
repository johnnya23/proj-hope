<?php
themeblvd_add_option_tab('jma_styles_header', 'Header Styles', true);

// Add General section to new tab   border_shadow
$name = 'Header Setup';
$description = 'A couple of additional changes to basic layout.';
$options = array(

     array(
    'name'      => 'Sortable Header Items',
    'desc'      => 'Add, remove or reorder items as desired. Use checkboxes and dropdowns to configure each item type and item properties. Generally include the Logo and Primary menu once each. If combining menu with logo remember to align menu to right.',
    'id'        => 'header_content',
    'std'       => array(
                    'item_1' => array(
                        'header_element'	=> 'jma-header-content',
                        'menu_align' => false,
                        'sidebar'	=> '',
                        'logo' => 1,
                        'sm_device' => '',
                        'lg_device' => '',
                        'remove_root_bg' => 1,
                        'custom_class' => '',
                    ),
                    'item_2' => array(
                        'header_element'	=> 'access',
                        'menu_align' => false,
                        'sidebar'	=> '',
                        'logo' => 0,
                        'sm_device' => '',
                        'lg_device' => '',
                        'remove_root_bg' => 0,
                        'custom_class' => '',
                    ),
                    'item_3' => array(
                        'header_element'	=> 'image jma-header-content',
                        'menu_align' => false,
                        'sidebar'	=> '',
                        'logo' => 0,
                        'sm_device' => '',
                        'lg_device' => '',
                        'remove_root_bg' => 1,
                        'custom_class' => '',
                    ),
                ),
    'type' 		=> 'sortable_header'
    ),
    array(
        'name'      => 'Add Search Popup to Primary Menu',
        'desc'      => '',
        'id'        => 'add_search_popup',
        'std'       => 1,
        'type' 		=> 'checkbox'
    ),
    array(
        'name' 		=> 'Add Menu Styling to Sticy Menu',
        'desc' 		=> 'Repeat setting for image above (if applicable)',
        'id' 		=> 'style_sticky',
        'std'		=> 0,
        'type' 		=> 'radio',
        'options'   => array(
            0 => 'Leave All White',
            1 => 'Match Reguler Menus',
            2 => 'Match Reguler Menus and Leave Sticky Root White (we may want this if the menu bg conflicts with the logo)'
            )
    ),
    array(
    'name'      => __('Child Theme Sticky Menu', 'themeblvd'),
    'desc'      => __('Use the child themes sticky menu (make sure parent sticky is off)', 'themeblvd'),
    'id'        => 'child_sticky_menu',
    'std'       => 1,
    'type'      => 'checkbox'
    ),
    array(
    'name'      => __('Alternate Sticky Logo', 'themeblvd'),
    'desc'      => __('Cange the log in the sticky menu', 'themeblvd'),
    'id'        => 'alt_sticky_logo',
    'std'       => '',
    'type'      => 'upload'
    )
);
themeblvd_add_option_section('jma_styles_header', 'jma_header_options', $name, $description, $options, true);

                // Add Styles > Menu section
$menu_options = array(
    array(
    'name' 		=> 'Menu Font Size',
    'desc' 		=> 'Menu Font Size',
    'id' 		=> 'menu_font_size',
    'std'		=> '16',
    'type' 		=> 'text'
    ),
    array(
    'name' 		=> 'Root Menu Item Horizontal Paddings',
    'desc' 		=> 'Root menu item padding in px (don\'t add unit abbreviation)',
    'id' 		=> 'menu_item_padding',
    'std'		=> '20',
    'type' 		=> 'text'
    ),
    array(
    'name' 		=> 'Root Menu Item Vertical Padding',
    'desc' 		=> 'Root menu item padding in px (don\'t add unit abbreviation)',
    'id' 		=> 'menu_item_vert_padding',
    'std'		=> '18',
    'type' 		=> 'text'
    ),
    array(
    'name' 		=> 'Root Border',
    'desc' 		=> 'Add a highlight either above or below current and hover root items',
    'id' 		=> 'menu_item_highlight',
    'std'		=> 0,
    'type' 		=> 'radio',
    'options'   => array(
        0 => 'None',
        'bottom' => 'Bottom',
        'top' => 'Top'
        )
    ),
    array(
    'name'      => __('Menu Background Color', 'themeblvd'),
    'desc'      => __('The color for the menu background', 'themeblvd'),
    'id'        => 'menu_background_color',
    'std'       => '#000000',
    'type'      => 'color'
    ),
    array(
    'name'      => __('Menu Font Color', 'themeblvd'),
    'desc'      => __('The color for the menu font', 'themeblvd'),
    'id'        => 'menu_font_color',
    'std'       => '#ffffff',
    'type'      => 'color'
    ),
    array(
    'name'      => __('Menu Hover Background Color', 'themeblvd'),
    'desc'      => __('The hover color for the menu background', 'themeblvd'),
    'id'        => 'menu_background_hover',
    'std'       => '#ffffff',
    'type'      => 'color'
    ),
    array(
    'name'      => __('Menu Hover Font Color', 'themeblvd'),
    'desc'      => __('The hover color for the menu font', 'themeblvd'),
    'id'        => 'menu_font_hover',
    'std'       => '#000000',
    'type'      => 'color'
    ),
    array(
    'name'      => __('Menu Current Page Background Color', 'themeblvd'),
    'desc'      => __('The color for the current menu item tab background', 'themeblvd'),
    'id'        => 'menu_background_current',
    'std'       => '#cccccc',
    'type'      => 'color'
    ),
    array(
    'name'      => __('Menu Current Page Font Color', 'themeblvd'),
    'desc'      => __('The color for the current menu item tab font', 'themeblvd'),
    'id'        => 'menu_font_current',
    'std'       => '#660000',
    'type'      => 'color'
    )
);
themeblvd_add_option_section('jma_styles_header', 'jma_menu', __('Menu Options', 'themeblvd'), null, $menu_options, false);

themeblvd_edit_option('layout', 'extras', 'breadcrumbs', 'std', 'hide');
themeblvd_edit_option('layout', 'header_sticky', 'sticky', 'std', 'hide');

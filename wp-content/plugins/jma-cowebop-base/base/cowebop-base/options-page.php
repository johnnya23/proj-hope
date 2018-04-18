<?php
themeblvd_add_option_tab('jma_styles_page', 'Page Styles', true);
// Add General section to new tab   border_shadow
$name = 'Page Setup';
$description = 'A couple of additional changes to basic layout.';
$options = array(
    array(
    'name' 		=> 'Body Shape',
    'desc' 		=> 'Boxed, Stretch or Modular',
    'id' 		=> 'body_shape',
    'std'		=> 'boxed',
    'type' 		=> 'select',
    'options'   => array(
        'boxed' => 'Boxed',
        'stretch' => 'Stretch(no page border)',
        'stretch_bordered' => 'Stretch(with page border)',
        'dark_modular' => 'Modular'
        )
    ),
    array(
    'name' 		=> 'Body Shadow',
    'desc' 		=> 'For Boxed and Stretch with Border, add a little shadow outside of border',
    'id' 		=> 'border_shadow',
    'std'		=> 'on',
    'type' 		=> 'select',
    'options'   => array(
        'on' => 'On',
        'off' => 'Off'
        )
    ),
    array(
    'name'      => __('Body Background Image (optional)', 'themeblvd'),
    'desc'      => __('A body background color can be chosen below', 'themeblvd'),
    'id'        => 'body_bg',
    'std'       => '',
    'type'      => 'upload'
    ),
    array(
    'name' 		=> 'Body Background Image Repeat',
    'desc' 		=> 'Repeat setting for image above (if applicable)',
    'id' 		=> 'body_bg_repeat',
    'std'		=> 'repeat',
    'type' 		=> 'select',
    'options'   => array(
        'repeat' => 'Repeat Horizontally and Vertically',
        'repeat-x' => 'Repeat Horizontally',
        'repeat-y' => 'Repeat Vertically',
        'no-repeat' => 'None (for a large image)'
        )
    ),
    array(
    'name'      => __('Site Width', 'themeblvd'),
    'desc'      => __('The over-all width of the site content', 'themeblvd'),
    'id'        => 'site_width',
    'std'       => 1100,
    'type'      => 'text'
    ),
    array(
    'name'      => __('Favicon', 'themeblvd'),
    'desc'      => __('The favicon for your site. . Should be of type .ico', 'themeblvd'),
    'id'        => 'site_favicon',
    'std'       =>  plugin_dir_url(__FILE__).'/images/favicon.ico',
    'type'      => 'upload'
    ),
    array(
    'name' 		=> 'Use High Sidebar?',
    'desc' 		=> 'Sidebar up one side of pages? ',
    'id' 		=> 'jma_high_sidebar',
    'std'       => 'none',
    'type'      => 'select',
    'options'   => array(
        'none' => 'Header all the way across (standard configuration)',
        'left' => 'Left Sidebar up the side (available in "Boxed" and "Modular" only)',
        'right' => 'Right Sidebar up the side (available in "Boxed" and "Modular" only)'
        )
    ),
    array(
    'name'      => __('Remove Sidebar "Creases"', 'themeblvd'),
    'desc'      => __('Replace the creases along the sidebars with simple lines', 'themeblvd'),
    'id'        => 'side_creases_off',
    'std'       => 0,
    'type' 		=> 'radio',
    'options'   => array(
        0 => 'Shaded Creases',
        1 => 'Line Separator',
        2 => 'No Separator'
        )
    ),
    array(
    'name'      => __('Builder Section Vertical Spacing', 'themeblvd'),
    'desc'      => __('Persentage adjustment for verical spacing of builder sections (Jason uses 80px)', 'themeblvd'),
    'id'        => 'builder_section_vert',
    'std'       => '30px',
    'type' 		=> 'select',
    'options'   => array(
        '80px' => '80px',
        '70px' => '70px',
        '60px' => '60px',
        '50px' => '50px',
        '40px' => '40px',
        '30px' => '30px',
        '20px' => '20px',
        '10px' => '10px',
        )
    ),
    array(
    'name'      => __('Builder Element Vertical Spacing', 'themeblvd'),
    'desc'      => __('Persentage adjustment for verical spacing of builder sections (Jason uses 60px)', 'themeblvd'),
    'id'        => 'builder_element_vert',
    'std'       => '30px',
    'type' 		=> 'select',
    'options'   => array(
        '60px' => '60px',
        '50px' => '50px',
        '40px' => '40px',
        '30px' => '30px',
        '20px' => '20px',
        '10px' => '10px',
        )
    ),
    array(
    'name'      => __('Site Background Color', 'themeblvd'),
    'desc'      => __('The color for the site background', 'themeblvd'),
    'id'        => 'site_background_color',
    'std'       => '#d4d4d4',
    'type'      => 'color'
    ),
    array(
    'name'      => __('Header Background Color', 'themeblvd'),
    'desc'      => __('The color for the header background. For header font color see typography', 'themeblvd'),
    'id'        => 'header_background_color',
    'std'       => '#999999',
    'type'      => 'color'
    ),
    array(
    'name'      => __('Site Page Color', 'themeblvd'),
    'desc'      => __('The color for the site page.', 'themeblvd'),
    'id'        => 'site_page_color',
    'std'       => '#ffffff',
    'type'      => 'color'
    ),
    array(
    'name'      => __('Footer Background Color', 'themeblvd'),
    'desc'      => __('The color for the footer background (this will often match the header background). This selection also controls page border and shadow. For footer font color see typography', 'themeblvd'),
    'id'        => 'footer_background_color',
    'std'       => '#4d4d4d',
    'type'      => 'color'
    )
);

themeblvd_add_option_section('jma_styles_page', 'jma_options', $name, $description, $options, true);


        // Add Styles > Typography section
$typography_options = array(
    array(
        'name' 		=> __('Primary Font', 'themeblvd'),
        'desc' 		=> __('This applies to most of the text on your site.', 'themeblvd'),
        'id' 		=> 'typography_body',
        'std' 		=> array('size' => '','face' => 'arial', 'google' => ''),
        'atts'		=> array('face'),
        'type' 		=> 'typography'
    ),
    array(
        'name'      => __('Primary Font Color', 'themeblvd'),
        'desc'      => __('The color for the page font', 'themeblvd'),
        'id'        => 'typography_body_color',
        'std'       => '#aaaaaa',
        'type'      => 'color'
    ),
    array(
        'name' 		=> __('Title Font', 'themeblvd'),
        'desc' 		=> __('This applies to all of the primary headers throughout your site (h1, h2, h3, h4, h5, h6). The class "header-font" will also contain these values.', 'themeblvd'),
        'id' 		=> 'typography_header',
        'std' 		=> array('size' => '','face' => 'times', 'google' => ''),
        'atts'		=> array('face'),
        'type' 		=> 'typography'
    ),
    array(
        'name'      => __('Title Font Color', 'themeblvd'),
        'desc'      => __('The color for the title font', 'themeblvd'),
        'id'        => 'typography_header_color',
        'std'       => '#006600',
        'type'      => 'color'
    ),
    array(
        'name' 		=> __('Special Font', 'themeblvd'),
        'desc' 		=> __('There are a few special areas in this theme where this font will get used. The class "special-font" will also contain these values.', 'themeblvd'),
        'id' 		=> 'typography_special',
        'std' 		=> array('size' => '','face' => 'times', 'google' => ''),
        'atts'		=> array('face'),
        'type' 		=> 'typography'
    ),
    array(
        'name'      => __('Special Font Color', 'themeblvd'),
        'desc'      => __('The color for the special font', 'themeblvd'),
        'id'        => 'typography_special_color',
        'std'       => '#000066',
        'type'      => 'color'
    ),
    array(
    'name'      => __('Link Font Color', 'themeblvd'),
    'desc'      => __('The color for the link font', 'themeblvd'),
    'id'        => 'link_font_color',
    'std'       => '#006600',
    'type'      => 'color'
    ),
    array(
    'name'      => __('Link Hover Color', 'themeblvd'),
    'desc'      => __('The color for the link on hover', 'themeblvd'),
    'id'        => 'hover_font_color',
    'std'       => '#00aa00',
    'type'      => 'color'
    ),
    array(
    'name'      => __('Header Font Color', 'themeblvd'),
    'desc'      => __('The color for the header font', 'themeblvd'),
    'id'        => 'header_font_color',
    'std'       => '#ffffff',
    'type'      => 'color'
    ),
    array(
    'name'      => __('Footer Font Color', 'themeblvd'),
    'desc'      => __('The color for the footer font', 'themeblvd'),
    'id'        => 'footer_font_color',
    'std'       => '#ffffff',
    'type'      => 'color'
    )
);
        themeblvd_add_option_section('jma_styles_page', 'typography', __('Typography', 'themeblvd'), null, $typography_options, false);

$name = 'Site Banner';
$description = 'If first option is set to none, skip the rest.';
$options = array(
    array(
    'name'      => __('Banner Content', 'themeblvd'),
    'desc'      => __('Choose banner content. Not for use with modular page style.', 'themeblvd'),
    'id'        => 'title_page_top',
    'std'       => 0,
    'type' 		=> 'radio',
    'options'   => array(
        0 => 'None',
        1 => 'Title',
        2 => 'Custom (defined in page settings or default text below)'
        ),
    ),
    array(
    'name'      => __('Banner Borders', 'themeblvd'),
    'desc'      => __('Shadows or 1px lines.', 'themeblvd'),
    'id'        => 'banner_shadows',
    'std'       => 0,
    'type' 		=> 'radio',
    'options'   => array(
        0 => 'Lines',
        1 => 'Shadows'
        ),
    ),
    array(
    'name'      => __('Default Banner Text', 'themeblvd'),
    'desc'      => __('Only for use with bottom custom choice above (if page text and this field are blank no banner will be displayed)', 'themeblvd'),
    'id'        => 'title_page_top_default_text',
    'std'       => '',
    'type'      => 'text',
    ),
    array(
    'name'      => __('Banner Background Image (optional)', 'themeblvd'),
    'desc'      => __('A banner background color can be chosen below', 'themeblvd'),
    'id'        => 'banner_bg_image',
    'std'       => '',
    'type'      => 'upload',
    ),
    array(
    'name' 		=> 'Banner Background Repeat',
    'desc' 		=> 'Repeat the image or center ',
    'id' 		=> 'banner_bg_repeat',
    'std'       => 'no-repeat',
    'type'      => 'select',
    'options'   => array(
        'no-repeat' => 'no-repeat',
        'repeat' => 'repeat'
        ),
    ),
    array(
    'name'      => __('Banner Vertical Padding', 'themeblvd'),
    'desc'      => __('Top and Bottom Padding (in pixels omit abrieviation)', 'themeblvd'),
    'id'        => 'banner_height',
    'std'       => 10,
    'type'      => 'text',
    ),
    array(
        'name'      => __('Font Size', 'themeblvd'),
        'desc'      => __('Font Size (in pixels omit abrieviation)', 'themeblvd'),
        'id'        => 'banner_font_size',
        'std'       => 32,
        'type'      => 'text',
    ),
    array(
    'name'      => __('Banner Background Color', 'themeblvd'),
    'desc'      => __('The color for the banner background', 'themeblvd'),
    'id'        => 'banner_bg_color',
    'std'       => '',
    'type'      => 'color' ,
    ),
    array(
    'name'      => __('Banner Font Color', 'themeblvd'),
    'desc'      => __('The color for the banner font', 'themeblvd'),
    'id'        => 'banner_font_color',
    'std'       => '',
    'type'      => 'color',
    ),
);
themeblvd_add_option_section('jma_styles_page', 'jma_banner', $name, $description, $options, false);
                // Add Styles > buttons
$button_options = array(
    array(
    'name'      => __('Button Background Color', 'themeblvd'),
    'id'        => 'button_back',
    'std'       => '#ffffff',
    'type'      => 'color'
    ),
    array(
    'name'      => __('Button Font Color', 'themeblvd'),
    'id'        => 'button_font',
    'std'       => '#666666',
    'type'      => 'color'
    ),
    array(
    'name'      => __('Button Background Color Hover', 'themeblvd'),
    'id'        => 'button_back_hover',
    'std'       => '#cccccc',
    'type'      => 'color'
    ),
    array(
    'name'      => __('Button Font Color Hover', 'themeblvd'),
    'id'        => 'button_font_hover',
    'std'       => '#000000',
    'type'      => 'color'
    )
);
themeblvd_add_option_section('jma_styles_page', 'jma_button', __('Button Options', 'themeblvd'), __('On hover the bottom gradient color will fill the entire button (font color will change if desired)', 'themeblvd'), $button_options, false);


/* change default footer text */
themeblvd_edit_option('layout', 'contact', 'social_footer', 'std', false);

$new_footer_text = 'probably clear this and use fields below';
themeblvd_edit_option('layout', 'footer', 'footer_copyright', 'std', $new_footer_text);

themeblvd_edit_option('content', 'list', 'list_more_text', 'std', 'Read More <i class="fas fa-long-arrow-alt-right"></i>');
themeblvd_edit_option('content', 'list', 'list_more_text', 'desc', 'Fontawesome 5 sub = Read More &lt;i class="fas fa-long-arrow-alt-right"&gt;&lt;/i&gt;');

$schema_options = array(
    'schema_Company' => 'CoWEBop Marketing',
    'schema_Url' => 'http://cowebop.com/',
    'schema_StreetOrPOBox' => '13722 Legend Way',
    'schema_City' => 'Broomfield',
    'schema_State' => 'CO',
    'schema_Zip' => '80023',
    'schema_Country' => 'US',
    'schema_Email' => 'tracy@cowebop.com',
    'schema_Phone' => '303.459.2686'
);
foreach ($schema_options as $schema_option => $default) {
    $pobox_desc = $schema_option === 'schema_StreetOrPOBox'? ' start with exactly "P.O. Box" (no quotes) if this is a P.O. Box.': '';
    $schema_desc = str_replace('schema_', '', $schema_option);
    $schema_id = strtolower($schema_option);
    themeblvd_add_option('layout', 'footer', $schema_id, array(
    'name'  => $schema_desc,
    'desc'  => $schema_desc . ' for schema' . $pobox_desc,
    'id'    => $schema_id,
    'std'   => $default,
    'type'  => 'text'
));
}

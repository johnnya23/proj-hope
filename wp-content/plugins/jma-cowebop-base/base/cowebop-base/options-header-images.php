<?php
themeblvd_add_option_tab('jma_styles_header_images', 'Header Images', true); // 3rd parameter is true so tab will be at start.

$slideshow_decs_add = '';
$jma_final = array();
if (function_exists('themeblvd_get_select')) {
    $jma_final = array('' => 'choose a slider or if necessary create one.') + themeblvd_get_select('sliders');
}
$name = 'Header Image Options';
$description = 'This section applies only if images are turned on below or images can be turned on and off on a page by page basis. <span style="color: red">When using this section set the width and height values first, then hit save and move on to creating sliders and setting other values/uploads. This will ensure that your images are cropped to the correct size. If you change width and height settings install and run the plugin: Regenerate Thumbnails, By Viper007Bond</span>';
$options = array(
    array(
    'name' 		=> 'Turn Page Images On',
    'desc' 		=> 'Use Images In header of pages instead of default (see "Current Page Header Content" for more options)',
    'id' 		=> 'jma_header_images',
    'std'		=> 0,
    'type' 		=> 'radio',
    'options'   => array(
        0 => 'Images Off',
        1 => 'Images On'
        )
    ),
    array(
    'name' 		=> 'Turn Post Images On',
    'desc' 		=> 'Use Images In header of posts instead of default (see "Current Page Header Content" for more options)',
    'id' 		=> 'jma_post_header_images',
    'std'		=> 0,
    'type' 		=> 'radio',
    'options'   => array(
        0 => 'Images Off',
        1 => 'Images On'
        )
    ),
    array(
    'name' 		=> 'Turn Archive Images On',
    'desc' 		=> 'Use Images In header of archive instead of default will use default image (use a page with the appropriate template to get "Current Page Header Content" for more options)',
    'id' 		=> 'jma_archive_header_images',
    'std'		=> 0,
    'type' 		=> 'radio',
    'options'   => array(
        0 => 'Images Off',
        1 => 'Images On'
        )
    ),
    array(
    'name' 		=> 'Front Page Image Width',
    'desc' 		=> 'Width of header image in px (don\'t add unit abbreviation)',
    'id' 		=> 'header_image_width',
    'std'		=> '1600',
    'type' 		=> 'text'
    ),
    array(
    'name' 		=> 'Front Page Image Height',
    'desc' 		=> 'Height of header image in px (don\'t add unit abbreviation)',
    'id' 		=> 'header_image_height',
    'std'		=> '400',
    'type' 		=> 'text'
    ),
    array(
    'name' 		=> 'Interior Page Image Width',
    'desc' 		=> 'Width of header image in px (don\'t add unit abbreviation) CAN BE SAME AS ABOVE',
    'id' 		=> 'header_interior_width',
    'std'		=> '1600',
    'type' 		=> 'text'
    ),
    array(
    'name' 		=> 'Interior Page Image Height',
    'desc' 		=> 'Height of header image in px (don\'t add unit abbreviation) CAN BE SAME AS ABOVE',
    'id' 		=> 'header_interior_height',
    'std'		=> '400',
    'type' 		=> 'text'
    ),
    array(
    'name'      => 'Choose Home Slideshow',
    'desc'      => 'Select a slideshow for the homepage or leave blank for default image. If a static page is selected in SETTINGS > READING this option will be over-ridden by the options on that page.' ,
    'id'        => 'front_page_slideshow',
    'std'       => '',
    'type'      => 'select',
    'options'   => $jma_final
    ),
    array(
    'name'      => __('Header Image', 'themeblvd'),
    'desc'      => __('The default image for the header of your site.', 'themeblvd'),
    'id'        => 'default_header_image',
    'std'       => plugin_dir_url(__FILE__).'/images/default.jpg',
    'type'      => 'upload'
    )
);
themeblvd_add_option_section('jma_styles_header_images', 'jma_header_image_options', $name, $description, $options);

$name = 'Header Area Options';
$description = 'By default if the header image is as wide or wider than the width of the content div the the header image will fill the entire header area with the logo and header widget overlaying the image(slideshow). The options below allow us to change that presentation';
$options = array(
    array(
    'name'      => __('Header Image Border Color', 'themeblvd'),
    'desc'      => __('The color for the border around the header image', 'themeblvd'),
    'id'        => 'header_image_border_color',
    'std'       => '',
    'type'      => 'color'
    ),
    array(
    'name' 		=> 'Header Image Border Width',
    'desc' 		=> 'Thickness of header image border in px (don\'t add unit abbreviation)',
    'id' 		=> 'header_image_border_width',
    'std'		=> '0',
    'type' 		=> 'text'
    ),
    array(
    'name' 		=> 'Front Page Header Image Margin Top',
    'desc' 		=> 'Margin above header on homepage image in px (don\'t add unit abbreviation)',
    'id' 		=> 'header_image_home_margin_top',
    'std'		=> '0',
    'type' 		=> 'text'
    ),
    array(
    'name' 		=> 'Interior Page Header Image Margin Top',
    'desc' 		=> 'Margin above header image in px (don\'t add unit abbreviation can be same as above)',
    'id' 		=> 'header_image_margin_top',
    'std'		=> '0',
    'type' 		=> 'text'
    ),
    array(
    'name' 		=> 'Front Page Header Image Margin Bottom',
    'desc' 		=> 'Margin below header image in px (don\'t add unit abbreviation)',
    'id' 		=> 'header_image_home_margin_bottom',
    'std'		=> '0',
    'type' 		=> 'text'
    ),
    array(
    'name' 		=> 'Interior Page Header Image Margin Bottom',
    'desc' 		=> 'Margin below header image in px (don\'t add unit abbreviation can be same as above)',
    'id' 		=> 'header_image_margin_bottom',
    'std'		=> '0',
    'type' 		=> 'text'
    )
);
themeblvd_add_option_section('jma_styles_header_images', 'jma_header_image_display_options', $name, $description, $options);

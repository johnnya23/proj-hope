<?php
/**
 * Header Elements buttons option type
 *
 * @since 2.5.0
 */
if ( is_admin() ){
	class JMA_Sortable_Headers extends Theme_Blvd_Sortable_Option {
	
		/**
		 * Constructor
		 *
		 * @since 2.5.0
		 */
		public function __construct() {
	
			// Set type
			$this->type = 'sortable_header';
	
			// Run parent
			parent::__construct();
	
		}
	
		/**
		 * Get options
		 *
		 * @since 2.5.0
		 */
		public function get_options() {
			$options = array(
				array(
					'id' 		=> 'header_element',
					'name'		=> __('Type of Header Element', 'themeblvd'),
					'type'		=> 'select',
					'std'		=> 'header-content',
					'options'	=> array(
				        'jma-header-content' => 'Content',
				        'access' => 'Primary Menu',
				        'access2' => 'Secondary Menu',
				        'image jma-header-content' => 'Header Image or Slider',
						),
					'trigger'	=> true // Triggers this option's value to be used in toggle
				),
				array(
					'id' 		=> 'menu_align',
					'name'		=> __('Menu Alignment (if appl)', 'themeblvd'),
					'type'		=> 'select',
					'std'		=> false,
					'options'	=> array(
				        false => 'Left',
				        'center' => 'Center',
				        'right' => 'Right',
						)
				),
				array(
					'id' 		=> 'menu_vert_align',
					'name'		=> __('Vertical Menu Alignment (if appl)', 'themeblvd'),
					'type'		=> 'select',
					'std'		=> false,
					'options'	=> array(
				        false => 'Top',
				        'middle' => 'Center',
				        'bottom' => 'Bottom',
						)
				),
				array(
					'id' 		=> 'logo',
					'name'		=> __('Add the Logo', 'themeblvd'),
					'type'		=> 'checkbox',
					'std'		=> 0 ,
				),
				array(
					'id' 		=> 'remove_root_bg',
					'name'		=> __('Remove Root Menu Background (if appl)', 'themeblvd'),
					'type'		=> 'checkbox',
					'std'		=> 0 ,
				),
				array(
					'id' 		=> 'sm_device',
					'name'		=> __('Show only on less than 768px screen width', 'themeblvd'),
					'type'		=> 'checkbox',
					'std'		=> 0 ,
				),
				array(
					'id' 		=> 'lg_device',
					'name'		=> __('Show only on more than 767px screen width', 'themeblvd'),
					'type'		=> 'checkbox',
					'std'		=> 0 ,
				),
				array(
					'id' 		=> 'sidebar',
					'name'		=> __('Header Content', 'themeblvd'),
					'desc'		=> __('Floating widget content.', 'themeblvd'),
					'type'		=> 'content',
					'options'	=> array( 'widget' )
				),
				array(
					'id' 		=> 'custom_class',
					'name'		=> __('Custom Class', 'themeblvd'),
					'desc'		=> __('Add a class for styling (optional).', 'themeblvd'),
					'std'		=> '' ,
					'type'		=> 'text',
				)
			);
			return $options;
		}
	
		/**
		 * Get labels
		 *
		 * @since 2.5.0
		 */
		public function get_labels() {
			$labels = array(
				'add' 					=> __('Add Header Elements','themeblvd'),
				'delete' 				=> __('Delete Header Element','themeblvd'),
				'delete_confirm'		=> __('Are you sure you want to delete this header element?', 'themeblvd'),
				'delete_all' 			=> __('Delete All Header Elements','themeblvd'),
				'delete_all_confirm' 	=> __('Are you sure you want to delete all header elements?','themeblvd')
			);
			return $labels;
		}
	
	}
}
/**
 * Instantiate sortable option objects, so everything 
 * is hooked into place, and ready to display.
 */
function jma_setup_sortable_options() {
	if ( class_exists('JMA_Sortable_Headers') ) { 
		$GLOBALS["jma_sortable_header"] = new JMA_Sortable_Headers();
	}
}
add_action('after_setup_theme', 'jma_setup_sortable_options');

/**
 * Display option.
 */
function jma_option_type( $output, $option, $option_name, $val ) {

	global $jma_sortable_header;

	if ( $option['type'] == 'sortable_header' ) {
		$output .= $jma_sortable_header->get_display( $option['id'], $option_name, $val );
		$output = str_replace('section-sortable_header', 'section-sortable_header section-sortable', $output);
	}

	return $output;
}
add_filter('themeblvd_option_type', 'jma_option_type', 10, 4);

/**
 * Sanitize option
 */
function jma_sanitize_sortable_header( $input ) {

	$output = array();

	if ( $input && is_array($input) ) {
		foreach ( $input as $item_id => $item ) {
			// just an example of basic text sanitization on each input ...  
			if(array_key_exists( 'header_element', $item))
				$output[$item_id]['header_element'] = apply_filters( 'themeblvd_sanitize_text', $item['header_element'] );
			else
				$output[$item_id]['header_element'] = false;

			if(array_key_exists( 'menu_align', $item))
				$output[$item_id]['menu_align'] = apply_filters( 'themeblvd_sanitize_text', $item['menu_align'] );
			else
				$output[$item_id]['menu_align'] = false;

			if(array_key_exists( 'menu_vert_align', $item))
				$output[$item_id]['menu_vert_align'] = apply_filters( 'themeblvd_sanitize_text', $item['menu_vert_align'] );
			else
				$output[$item_id]['menu_vert_align'] = false;

			if(array_key_exists( 'sidebar', $item))
				$output[$item_id]['sidebar'] = apply_filters( 'themeblvd_sanitize_content', $item['sidebar'] );
			else
				$output[$item_id]['sidebar'] = false;


			if(array_key_exists( 'sm_device', $item))
				$output[$item_id]['sm_device'] = apply_filters( 'themeblvd_sanitize_checkbox', $item['sm_device'] );
			else
				$output[$item_id]['sm_device'] = false;


			if(array_key_exists( 'lg_device', $item))
				$output[$item_id]['lg_device'] = apply_filters( 'themeblvd_sanitize_checkbox', $item['lg_device'] );
			else
				$output[$item_id]['lg_device'] = false;


			if(array_key_exists( 'custom_class', $item))
				$output[$item_id]['custom_class'] = apply_filters( 'themeblvd_sanitize_text_box', $item['custom_class'] );
			else
				$output[$item_id]['custom_class'] = false;


			if(array_key_exists( 'remove_root_bg', $item))
				$output[$item_id]['remove_root_bg'] = apply_filters( 'themeblvd_sanitize_checkbox', $item['remove_root_bg'] );
			else
				$output[$item_id]['remove_root_bg'] = false;


			if(array_key_exists( 'logo', $item))
				$output[$item_id]['logo'] = apply_filters( 'themeblvd_sanitize_checkbox', $item['logo'] );
			else
				$output[$item_id]['logo'] = false;


			
		}
	}

	return $output;
}
add_filter('themeblvd_sanitize_sortable_header', 'jma_sanitize_sortable_header');

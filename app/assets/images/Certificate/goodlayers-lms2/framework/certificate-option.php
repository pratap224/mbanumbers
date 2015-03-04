<?php
	/*	
	*	Goodlayers Certificate Option File
	*/	
	 
	// create the certificate post type
	add_action( 'init', 'gdlr_lms_create_certificate' );
	function gdlr_lms_create_certificate() {
		register_post_type( 'certificate',
			array(
				'labels' => array(
					'name'               => __('Certificate', 'gdlr-lms'),
					'singular_name'      => __('Certificate', 'gdlr-lms'),
					'add_new'            => __('Add New', 'gdlr-lms'),
					'add_new_item'       => __('Add New Certificate', 'gdlr-lms'),
					'edit_item'          => __('Edit Certificate', 'gdlr-lms'),
					'new_item'           => __('New Certificate', 'gdlr-lms'),
					'all_items'          => __('All Certificates', 'gdlr-lms'),
					'view_item'          => __('View Certificate', 'gdlr-lms'),
					'search_items'       => __('Search Certificate', 'gdlr-lms'),
					'not_found'          => __('No certificates found', 'gdlr-lms'),
					'not_found_in_trash' => __('No certificates found in Trash', 'gdlr-lms'),
					'parent_item_colon'  => '',
					'menu_name'          => __('Certificates', 'gdlr-lms')
				),
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				//'rewrite'            => array( 'slug' => 'certificate'  ),
				//'capability_type'    => array('certificate', 'certificates'),
				'map_meta_cap' 		 => true,
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => 5,
				'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields' )
			)
		);
		
		add_filter('single_template', 'gdlr_lms_register_certificate_template');
	}
	
	// register single certificate template
	function gdlr_lms_register_certificate_template($template) {
		global $wpdb, $post, $current_user;
		
		if( $post->post_type == 'certificate' ){
			$template = dirname(dirname( __FILE__ )) . '/single-certificate.php';
		}

		return $template;	
	}

	// enqueue the necessary admin script
	add_action('admin_enqueue_scripts', 'gdlr_lms_certificate_script');
	function gdlr_lms_certificate_script() {
		global $post; if( !empty($post) && $post->post_type != 'certificate' ) return;
		
		wp_enqueue_style('gdlr-lms-meta-box', plugins_url('/stylesheet/meta-box.css', __FILE__));
		wp_enqueue_style('gdlr-date-picker', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
		
		wp_enqueue_script('jquery-ui-datepicker');	
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-slider');	
		wp_enqueue_script('gdlr-lms-meta-box', plugins_url('/javascript/meta-box.js', __FILE__));
	}

	// add the certificate option
	add_action('add_meta_boxes', 'gdlr_lms_add_certificate_meta_box');	
	add_action('pre_post_update', 'gdlr_lms_save_certificate_meta_box');
	function gdlr_lms_add_certificate_meta_box(){
		add_meta_box('certificate-option', __('Certificate Option', 'gdlr-lms'), 
			'gdlr_lms_create_certificate_meta_box', 'certificate', 'normal', 'high');
	}
	function gdlr_lms_create_certificate_meta_box(){
		global $post;
		
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'certificate_meta_box', 'certificate_meta_box_nonce' );

		/////////////////////////////////////
		//// certificate setting section ////
		/////////////////////////////////////
		
		$certificate_settings = array(
			'enable-printer' => array(
				'title' => __('Online Course', 'gdlr-lms'),
				'type' => 'checkbox',
				'default' => 'enable'
			),
			'custom-css' => array(
				'title' => __('Custom Certificate Css', 'gdlr-lms'),
				'type' => 'textarea'
			),
			'fill-default' => array(
				'title' => __('Fill Default Shortcode Text', 'gdlr-lms'),
				'type' => 'button',
				'default' => __('Fill Shortcode', 'gdlr-lms')
			),
			'shortcode-description' => array(
				'title' => __('Shortcode Description', 'gdlr-lms'),
				'type' => 'description',
				'default' => 
'<br><span class="head">Wrapper - </span>[gdlr_cer_wrapper border="yes" background="XXX" class="XXX"][/gdlr_cer_wrapper]' .
'<br><span class="head">Caption - </span>[gdlr_cer_caption font_size="19px" class="XXX"]This is to certify that[/gdlr_cer_caption]' .
'<br><span class="head">Student name - </span>[gdlr_cer_student_name font_size="34px" class="XXX"]' .
'<br><span class="head">Course name - </span>[gdlr_cer_course_name font_size="25px" class="XXX"]' .
'<br><span class="head">Marks - </span>[gdlr_cer_mark font_size="19px" class="XXX"]With Marks[/gdlr_cer_mark]' .
'<br><span class="head">Date - </span>[gdlr_cer_date font_size="15px" class="XXX" format="j/n/Y"]Date[/gdlr_cer_date]' . 
'<br><span class="head">Signature - </span>[gdlr_cer_signature image="XXX" font_size="15px" class="XXX"]Sam White, Course Instructor[/gdlr_cer_signature]'

			),
		);
		$certificate_val = gdlr_lms_decode_preventslashes(get_post_meta($post->ID, 'gdlr-lms-certificate-settings', true));
		$certificate_settings_val = empty($certificate_val)? array(): json_decode($certificate_val, true);
		
		echo '<div class="gdlr-lms-meta-wrapper">';
		echo '<h3>' . __('Certificate Settings', 'gdlr-lms') . '</h3>';
		foreach($certificate_settings as $slug => $certificate_setting){
			$certificate_setting['slug'] = $slug;
			$certificate_setting['value'] = empty($certificate_settings_val[$slug])? '': $certificate_settings_val[$slug];
			gdlr_lms_print_meta_box($certificate_setting);
		}
		echo '<textarea name="gdlr-lms-certificate-settings">' . esc_textarea($certificate_val) . '</textarea>';
		echo '</div>';
	}
	function gdlr_lms_save_certificate_meta_box($post_id){
	
		// verify nonce & user's permission
		if(!isset($_POST['certificate_meta_box_nonce'])){ return; }
		if(!wp_verify_nonce($_POST['certificate_meta_box_nonce'], 'certificate_meta_box')){ return; }
		if(!current_user_can('edit_post', $post_id)){ return; }

		// save value
		if( isset($_POST['gdlr-lms-certificate-settings']) ){
			update_post_meta($post_id, 'gdlr-lms-certificate-settings', gdlr_lms_preventslashes($_POST['gdlr-lms-certificate-settings']));
		}
		
	}

?>
<?php
	/*	
	*	Goodlayers Course Option File
	*/	
	 
	// create the course post type
	add_action( 'init', 'gdlr_lms_create_cause' );
	function gdlr_lms_create_cause() {
		register_post_type( 'course',
			array(
				'labels' => array(
					'name'               => __('Course', 'gdlr-lms'),
					'singular_name'      => __('Course', 'gdlr-lms'),
					'add_new'            => __('Add New', 'gdlr-lms'),
					'add_new_item'       => __('Add New Course', 'gdlr-lms'),
					'edit_item'          => __('Edit Course', 'gdlr-lms'),
					'new_item'           => __('New Course', 'gdlr-lms'),
					'all_items'          => __('All Courses', 'gdlr-lms'),
					'view_item'          => __('View Course', 'gdlr-lms'),
					'search_items'       => __('Search Course', 'gdlr-lms'),
					'not_found'          => __('No courses found', 'gdlr-lms'),
					'not_found_in_trash' => __('No courses found in Trash', 'gdlr-lms'),
					'parent_item_colon'  => '',
					'menu_name'          => __('Courses', 'gdlr-lms')
				),
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				//'rewrite'            => array( 'slug' => 'course'  ),
				'capability_type'    => array('course', 'courses'),
				'map_meta_cap' 		 => true,
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => 5,
				'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields' )
			)
		);

		// create course categories
		register_taxonomy(
			'course_category', array("course"), array(
				'hierarchical' => true,
				'show_admin_column' => true,
				'label' => __('Course Categories', 'gdlr-lms'), 
				'singular_label' => __('Course Category', 'gdlr-lms'), 
				'rewrite' => array('slug' => 'course_cateogry'),
				'capabilities' => array('manage_terms'=>'course_taxes', 'edit_terms'=>'course_taxes_edit', 
					'delete_terms'=>'course_taxes_edit', 'assign_terms'=>'course_taxes')
				));
		register_taxonomy_for_object_type('course_category', 'course');

		// create course tag
		register_taxonomy(
			'course_tag', array('course'), array(
				'hierarchical' => false, 
				'show_admin_column' => true,
				'label' => __('Course Tags', 'gdlr-lms'), 
				'singular_label' => __('Course Tag', 'gdlr-lms'),  
				'rewrite' => array( 'slug' => 'course_category' ),
				'capabilities' => array('manage_terms'=>'course_taxes', 'edit_terms'=>'course_taxes', 
					'delete_terms'=>'course_taxes', 'assign_terms'=>'course_taxes')
				));
		register_taxonomy_for_object_type('course_tag', 'course');	
		
		add_filter('single_template', 'gdlr_lms_register_course_template');
	}
	
	// register single course template
	function gdlr_lms_register_course_template($template) {
		global $wpdb, $post, $current_user;
		
		if( $post->post_type == 'course' ){
			$template = '';
			if( is_user_logged_in() && isset($_GET['course_type']) ){
				$authorization = false;
				
				if( $current_user->ID == $post->post_author ){
					$authorization = true;
				}else{

					// check if purchase before
					$sql  = 'SELECT id, payment_status, attendance, attendance_section FROM ' . $wpdb->prefix . 'gdlrpayment ';
					$sql .= 'WHERE course_id=' . $post->ID . ' AND student_id=' . $current_user->ID;
					$find_row = $wpdb->get_row($sql);

					if(!empty($find_row)){
						if( $find_row->payment_status == 'paid' ){
							$authorization = true;
							
							$lms_page = (empty($_GET['course_page']))? 1: intval($_GET['course_page']);
							$course_val = gdlr_lms_decode_preventslashes(get_post_meta($post->ID, 'gdlr-lms-content-settings', true));
							$course_options = empty($course_val)? array(): json_decode($course_val, true);							

							if( $find_row->attendance_section < $lms_page){
								$current_date = strtotime(date('Y-m-d H:i:s'));
								$available_date = strtotime($find_row->attendance) + (intval($course_options[$lms_page-2]['wait-time']) * 86400);
								if( $lms_page > 1 && $current_date < $available_date ){
									global $gdlr_time_left;
									$gdlr_time_left = $available_date - $current_date;
								}else{
									$wpdb->update( $wpdb->prefix . 'gdlrpayment', 
										array('attendance'=>date('Y-m-d H:i:s'), 'attendance_section'=>$lms_page), array('id'=>$find_row->id), 
										array('%s', '%d'), array('%d')
									);
								}
							}
						}

					// check whether it is free course	
					}else{
						$course_val = gdlr_lms_decode_preventslashes(get_post_meta($post->ID, 'gdlr-lms-course-settings', true));
						$course_options = empty($course_val)? array(): json_decode($course_val, true);

						if( empty($course_options['price']) && empty($course_options['discount-price']) ){
							$authorization = true;
							
							$course_options['booked-seat'] = intval($course_options['booked-seat']) + 1;
							update_post_meta($post->ID, 'gdlr-lms-course-settings', json_encode($course_options));
							
							$running_number = intval(get_post_meta($post->ID, 'student-booking-id', true));
							$running_number = empty($running_number)? 1: $running_number + 1;
							update_post_meta($post->ID, 'student-booking-id', $running_number);	
										
							$code  = substr(get_user_meta($current_user->ID, 'first_name',true), 0, 1) . substr(get_user_meta($current_user->ID, 'last_name',true), 0, 1);
							$code .= $running_number . $course_options['course-code'] . $post->ID;							
							
							$data = serialize(array(
								'amount' => 1,
								'price' => 0,
								'code' => $code
							));							
							
							$wpdb->insert( $wpdb->prefix . 'gdlrpayment', 
								array('course_id'=>$post->ID, 'student_id'=>$current_user->ID, 'author_id'=>$post->post_author,
									'payment_date'=>date('Y-m-d'), 'payment_info'=>'', 'payment_status'=>'paid', 'price'=>'0',
									'payment_info'=>$data, 'attendance'=>date('Y-m-d H:i:s')), 
								array('%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s', '%s') 
							);
						}
					}
				}
				
				if($authorization){
					if($_GET['course_type'] == 'content'){
							$template .=  'single-course-content.php';
					}else if($_GET['course_type'] == 'quiz'){
							$template .=  'single-course-quiz.php';
					}
				}
			}
			$template = empty($template)? 'single-course.php': $template;
			$template = dirname(dirname( __FILE__ )) . '/' . $template;
		
		}else if( $post->post_type == 'quiz' ){
			if( $current_user->ID == $post->post_author ){
				$template = dirname(dirname( __FILE__ )) . '/single-course-quiz.php';
			}else{
				$template = get_template_directory() . '/404.php';
			}
		}
		
		return $template;	
	}

	// enqueue the necessary admin script
	add_action('admin_enqueue_scripts', 'gdlr_lms_course_script');
	function gdlr_lms_course_script() {
		global $post; if( !empty($post) && $post->post_type != 'course' ) return;
		
		wp_enqueue_style('gdlr-lms-meta-box', plugins_url('/stylesheet/meta-box.css', __FILE__));
		wp_enqueue_style('gdlr-date-picker', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
		
		wp_enqueue_script('jquery-ui-datepicker');	
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-slider');	
		wp_enqueue_script('gdlr-lms-meta-box', plugins_url('/javascript/meta-box.js', __FILE__));
	}

	// add the course option
	add_action('add_meta_boxes', 'gdlr_lms_add_course_meta_box');	
	add_action('pre_post_update', 'gdlr_lms_save_course_meta_box');
	function gdlr_lms_add_course_meta_box(){
		add_meta_box('course-option', __('Course Option', 'gdlr-lms'), 
			'gdlr_lms_create_course_meta_box', 'course', 'normal', 'high');
	}
	function gdlr_lms_create_course_meta_box(){
		global $post;
		
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'course_meta_box', 'course_meta_box_nonce' );

		////////////////////////////////
		//// course setting section ////
		////////////////////////////////
		
		$course_settings = array(
			'online-course' => array(
				'title' => __('Online Course', 'gdlr-lms'),
				'type' => 'checkbox',
				'default' => 'enable',
				'description' => __('Course content section will be ignored when this option is disabled.', 'gdlr-lms')
			),
			'course-code' => array(
				'title' => __('Course Code', 'gdlr-lms'),
				'type' => 'text',
				'description' => __('Use to generate code after submit payment evidence.', 'gdlr-lms')
			),
			'quiz' => array(
				'title' => __('Course Quiz', 'gdlr-lms'),
				'type' => 'combobox',
				'options' => gdlr_lms_get_post_list('quiz')
			),			
			'location' => array(
				'title' => __('Location', 'gdlr-lms'),
				'type' => 'text',
				'class' => 'long',
				'wrapper-class' => 'online-course-disable'
			),			
			'duration' => array(
				'title' => __('Duration', 'gdlr-lms'),
				'type' => 'text',
				'class' => 'small',
				'description' => __('Days', 'gdlr-lms')
			),
			'start-date' => array(
				'title' => __('Start Date', 'gdlr-lms'),
				'type' => 'datepicker',
				'wrapper-class' => 'online-course-disable'
			),
			'end-date' => array(
				'title' => __('End Date', 'gdlr-lms'),
				'type' => 'datepicker',
				'wrapper-class' => 'online-course-disable'
			),			
			'expired-date' => array(
				'title' => __('Expired Date', 'gdlr-lms'),
				'type' => 'datepicker',
				'description' => __('(If any)', 'gdlr-lms')
			),
			'max-seat' => array(
				'title' => __('Max Seat', 'gdlr-lms'),
				'type' => 'text',
				'wrapper-class' => 'online-course-disable'
			),
			'booked-seat' => array(
				'title' => __('Booked Seat', 'gdlr-lms'),
				'type' => 'text',
				'wrapper-class' => 'online-course-disable'
			),	
			'price' => array(
				'title' => __('Price', 'gdlr-lms'),
				'type' => 'text',
				'class' => 'small',
				'description' => __('Leaving this field blankfor free course (Only number is allowed here)', 'gdlr-lms'),
			),
			'discount-price' => array(
				'title' => __('Discount Price', 'gdlr-lms'),
				'type' => 'text',
				'class' => 'small',
				'description' => __('(Only number is allowed here)', 'gdlr-lms')
				
			),
			
			// badge and certificate
			'enable-badge' => array(
				'title' => __('Enable Badge', 'gdlr-lms'),
				'type' => 'checkbox',
				'default' => 'disable',
				'wrapper-class' => 'online-course-enable'
			),
			'badge-percent' => array(
				'title' => __('% Of Score To Get Badge', 'gdlr-lms'),
				'type' => 'text',
				'wrapper-class' => 'online-course-enable'
			),
			'badge-title' => array(
				'title' => __('Badge Title', 'gdlr-lms'),
				'type' => 'text',
				'wrapper-class' => 'online-course-enable'
			),
			'badge-file' => array(
				'title' => __('Badge File', 'gdlr-lms'),
				'type' => 'upload',
				'wrapper-class' => 'online-course-enable'
			),
			'enable-certificate' => array(
				'title' => __('Enable Certificate', 'gdlr-lms'),
				'type' => 'checkbox',
				'default' => 'disable',
				'wrapper-class' => 'online-course-enable'
			),
			'certificate-percent' => array(
				'title' => __('% Of Score To Get Certificate', 'gdlr-lms'),
				'type' => 'text',
				'wrapper-class' => 'online-course-enable'
			),
			'certificate-template' => array(
				'title' => __('Certificate Template', 'gdlr-lms'),
				'type' => 'combobox',
				'options' => gdlr_lms_get_post_list('certificate'),
				'wrapper-class' => 'online-course-enable'
			),
		);
		$course_val = gdlr_lms_decode_preventslashes(get_post_meta($post->ID, 'gdlr-lms-course-settings', true));
		$course_settings_val = empty($course_val)? array(): json_decode($course_val, true);
		
		echo '<div class="gdlr-lms-meta-wrapper">';
		echo '<h3>' . __('Course Settings', 'gdlr-lms') . '</h3>';
		foreach($course_settings as $slug => $course_setting){
			$course_setting['slug'] = $slug;
			$course_setting['value'] = empty($course_settings_val[$slug])? '': $course_settings_val[$slug];
			gdlr_lms_print_meta_box($course_setting);
		}
		echo '<textarea name="gdlr-lms-course-settings">' . esc_textarea($course_val) . '</textarea>';
		echo '</div>';
		
		/////////////////////
		//// tab section ////
		/////////////////////
		
		$course_content_options = array(
			'section-name' => array(
				'title' => __('Section Name', 'gdlr-lms'),
				'type' => 'text'
			),	
			'pdf-download-link' => array(
				'title' => __('PDF Download Link', 'gdlr-lms'),
				'type' => 'upload'
			),			
			'wait-time' => array(
				'title' => __('Student have to wait', 'gdlr-lms'),
				'type' => 'text',
				'class' => 'small',
				'description' => __('days before continuing to next section.', 'gdlr-lms'),
			),
			'course-content' => array(
				'type' => 'wysiwyg'
			),			
		);		
		$course_content_val = gdlr_lms_decode_preventslashes(get_post_meta($post->ID, 'gdlr-lms-content-settings', true));
		$course_content_options_val = empty($course_content_val)? array(): json_decode($course_content_val, true);		
		
		echo '<div class="gdlr-lms-meta-wrapper gdlr-tabs">';
		echo '<h3>' . __('Course Content', 'gdlr-lms') . '</h3>';
		echo '<div class="course-tab-add-new">';
		echo '<span class="head">+</span>';
		echo '<span class="tail">' . __('Add Section', 'gdlr-lms') . '</span>';
		echo '</div>'; // course-tab-add-new
		echo '<div class="course-tab-title">';
		echo '<span class="active">1</span>';
		for( $i = 2; $i <= sizeof($course_content_options_val); $i++ ){
			echo '<span>' . $i . '</span>';
		} 
		echo '</div>'; // course-tab-title
		echo '<div class="course-tab-content">';
		echo '<div class="course-tab-remove">Delete</div>';
		foreach($course_content_options as $slug => $course_content_option){
			$course_content_option['slug'] = $slug;
			$course_content_option['value'] = empty($course_content_options_val[0][$slug])? '': $course_content_options_val[0][$slug];
			gdlr_lms_print_meta_box($course_content_option);
		}		
		echo '</div>'; // course-tab-content
		echo '<textarea name="gdlr-lms-content-settings">' . esc_textarea($course_content_val) . '</textarea>';
		echo '</div>';	
	}
	function gdlr_lms_save_course_meta_box($post_id){
	
		// verify nonce & user's permission
		if(!isset($_POST['course_meta_box_nonce'])){ return; }
		if(!wp_verify_nonce($_POST['course_meta_box_nonce'], 'course_meta_box')){ return; }
		if(!current_user_can('edit_post', $post_id)){ return; }

		// save value
		if( isset($_POST['gdlr-lms-course-settings']) ){
			update_post_meta($post_id, 'gdlr-lms-course-settings', gdlr_lms_preventslashes($_POST['gdlr-lms-course-settings']));
		}
		if( isset($_POST['gdlr-lms-content-settings']) ){
			update_post_meta($post_id, 'gdlr-lms-content-settings', gdlr_lms_preventslashes($_POST['gdlr-lms-content-settings']));
		}
		
	}

?>
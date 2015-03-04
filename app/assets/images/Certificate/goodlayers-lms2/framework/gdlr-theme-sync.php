<?php
	/*	
	*	Function to sync with goodlayers theme
	*/	

	// add course in page builder area
	add_filter('gdlr_page_builder_option', 'gdlr_register_course_item');
	function gdlr_register_course_item( $page_builder = array() ){
		global $gdlr_spaces;
	
		$page_builder['content-item']['options']['course'] = array(
			'title'=> __('Course', 'gdlr-lms'), 
			'type'=>'item',
			'options'=>array_merge(gdlr_page_builder_title_option(true), array(					
				'category'=> array(
					'title'=> __('Category' ,'gdlr-lms'),
					'type'=> 'multi-combobox',
					'options'=> gdlr_get_term_list('course_category'),
					'description'=> __('You can use Ctrl/Command button to select multiple categories or remove the selected category. <br><br> Leave this field blank to select all categories.', 'gdlr-lms')
				),					
				'course-style'=> array(
					'title'=> __('Course Style' ,'gdlr-lms'),
					'type'=> 'combobox',
					'options'=> array(
						'grid' => __('Grid Style', 'gdlr-lms'),
						'grid-2' => __('Grid 2nd Style', 'gdlr-lms'),
						'medium' => __('Medium Style', 'gdlr-lms'),
						'full' => __('Full Style', 'gdlr-lms'),
					),
				),					
				'num-fetch'=> array(
					'title'=> __('Num Fetch' ,'gdlr-lms'),
					'type'=> 'text',	
					'default'=> '8',
					'description'=> __('Specify the number of courses you want to pull out.', 'gdlr-lms')
				),	
				'num-excerpt'=> array(
					'title'=> __('Num Excerpt' ,'gdlr-lms'),
					'type'=> 'text',	
					'default'=> '20',
					'wrapper-class'=>'course-style-wrapper full-wrapper'
				),					
				'course-size'=> array(
					'title'=> __('Course Size' ,'gdlr-lms'),
					'type'=> 'combobox',
					'options'=> array(
						'4'=>'1/4',
						'3'=>'1/3',
						'2'=>'1/2',
						'1'=>'1/1'
					),
					'default'=>'3',
					'wrapper-class'=>'course-style-wrapper grid-wrapper grid-2-wrapper'
				),					
				'course-layout'=> array(
					'title'=> __('Course Layout Order' ,'gdlr-lms'),
					'type'=> 'combobox',
					'options'=> array(
						'fitRows' =>  __('FitRows ( Order items by row )', 'gdlr-lms'),
						'carousel' => __('Carousel ( Only For Grid Style )', 'gdlr-lms'),
					),
					'wrapper-class'=>'course-style-wrapper grid-wrapper grid-2-wrapper'
				),					
				'thumbnail-size'=> array(
					'title'=> __('Thumbnail Size' ,'gdlr-lms'),
					'type'=> 'combobox',
					'options'=> gdlr_get_thumbnail_list()
				),	
				'orderby'=> array(
					'title'=> __('Order By' ,'gdlr-lms'),
					'type'=> 'combobox',
					'options'=> array(
						'date' => __('Publish Date', 'gdlr-lms'), 
						'title' => __('Title', 'gdlr-lms'), 
						'rand' => __('Random', 'gdlr-lms'), 
					)
				),
				'order'=> array(
					'title'=> __('Order' ,'gdlr-lms'),
					'type'=> 'combobox',
					'options'=> array(
						'desc'=>__('Descending Order', 'gdlr-lms'), 
						'asc'=> __('Ascending Order', 'gdlr-lms'), 
					)
				),			
				'pagination'=> array(
					'title'=> __('Enable Pagination' ,'gdlr-lms'),
					'type'=> 'checkbox'
				),	
				'margin-bottom' => array(
					'title' => __('Margin Bottom', 'gdlr-lms'),
					'type' => 'text',
					'default' => $gdlr_spaces['bottom-blog-item'],
					'description' => __('Spaces after ending of this item', 'gdlr-lms')
				),				
			))
		);
		
		$page_builder['content-item']['options']['course-search'] = array(
			'title'=> __('Course Search', 'gdlr-lms'), 
			'type'=>'item',
			'options'=>array_merge(gdlr_page_builder_title_option(true), array(					
				'margin-bottom' => array(
					'title' => __('Margin Bottom', 'gdlr-lms'),
					'type' => 'text',
					'default' => $gdlr_spaces['bottom-blog-item'],
					'description' => __('Spaces after ending of this item', 'gdlr-lms')
				)
			))
		);

		return $page_builder;
	}
	
	// add action to check for course item
	add_action('gdlr_print_item_selector', 'gdlr_check_course_item', 10, 2);
	function gdlr_check_course_item( $type, $settings = array() ){
		if($type == 'course'){
			echo gdlr_lms_print_course_item($settings, true);
		}else if($type == 'course-search'){
			echo gdlr_lms_print_course_search($settings, true);
		}
	}
	
	// add instructor in page builder area
	add_filter('gdlr_page_builder_option', 'gdlr_register_instructor_item');
	function gdlr_register_instructor_item( $page_builder = array() ){
		global $gdlr_spaces;
	
		$page_builder['content-item']['options']['instructor'] = array(
			'title'=> __('Instructor', 'gdlr-lms'), 
			'type'=>'item',
			'options'=>array_merge(gdlr_page_builder_title_option(true), array(					
				'instructor-type' => array(
					'title'=> __('Instructor Type' ,'gdlr-lms'),
					'type'=> 'combobox',
					'options'=> array(
						'single' => __('Single Instructor', 'gdlr-lms'),
						'multiple' => __('Instructor List', 'gdlr-lms')
					),
				),	
				'user'=> array(
					'title'=> __('Select User' ,'gdlr-lms'),
					'type'=> 'combobox',
					'options'=> gdlr_lms_get_user_list(),
					'wrapper-class' => 'instructor-type-wrapper single-wrapper'
				),	
				'role'=> array(
					'title'=> __('Role' ,'gdlr-lms'),
					'type'=> 'combobox',
					'options'=> gdlr_lms_get_role_list(),
					'wrapper-class' => 'instructor-type-wrapper multiple-wrapper'
				),		
				'instructor-style'=> array(
					'title'=> __('Instructor Style' ,'gdlr-lms'),
					'type'=> 'combobox',
					'options'=> array(
						'grid' => __('Grid Style', 'gdlr-lms'),
						'grid-2' => __('Grid 2nd Style', 'gdlr-lms')
					),
				),					
				'num-fetch'=> array(
					'title'=> __('Num Fetch' ,'gdlr-lms'),
					'type'=> 'text',	
					'default'=> '8',
					'wrapper-class' => 'instructor-type-wrapper multiple-wrapper',
					'description'=> __('Specify the number of instructor you want to pull out.', 'gdlr-lms')
				),	
				'num-excerpt'=> array(
					'title'=> __('Num Excerpt' ,'gdlr-lms'),
					'type'=> 'text',	
					'default'=> '20'
				),					
				'instructor-size'=> array(
					'title'=> __('Instructor Size' ,'gdlr-lms'),
					'type'=> 'combobox',
					'options'=> array(
						'4'=>'1/4',
						'3'=>'1/3',
						'2'=>'1/2',
						'1'=>'1/1'
					),
					'default'=>'3',
					'wrapper-class' => 'instructor-type-wrapper multiple-wrapper'
				),				
				'thumbnail-size'=> array(
					'title'=> __('Thumbnail Size' ,'gdlr-lms'),
					'type'=> 'combobox',
					'options'=> gdlr_get_thumbnail_list()
				),	
				'orderby'=> array(
					'title'=> __('Order By' ,'gdlr-lms'),
					'type'=> 'combobox',
					'options'=> array(
						'display_name' => __('Display Name', 'gdlr-lms'), 
						'ID' => __('ID', 'gdlr-lms'), 
						'post_count' => __('Post Count', 'gdlr-lms'), 
					),
					'wrapper-class' => 'instructor-type-wrapper multiple-wrapper'
				),
				'order'=> array(
					'title'=> __('Order' ,'gdlr-lms'),
					'type'=> 'combobox',
					'options'=> array(
						'asc'=> __('Ascending Order', 'gdlr-lms'), 
						'desc'=>__('Descending Order', 'gdlr-lms')
					),
					'wrapper-class' => 'instructor-type-wrapper multiple-wrapper'
				),			
				//'pagination'=> array(
				//	'title'=> __('Enable Pagination' ,'gdlr-lms'),
				//	'type'=> 'checkbox'
				//),	
				'margin-bottom' => array(
					'title' => __('Margin Bottom', 'gdlr-lms'),
					'type' => 'text',
					'default' => $gdlr_spaces['bottom-blog-item'],
					'description' => __('Spaces after ending of this item', 'gdlr-lms')
				),				
			))
		);

		return $page_builder;
	}
	
	// add action to check for instructor item
	add_action('gdlr_print_item_selector', 'gdlr_check_instructor_item', 10, 2);
	function gdlr_check_instructor_item( $type, $settings = array() ){
		if($type == 'instructor'){
			echo gdlr_lms_print_instructor_item($settings, true);
		}
	}	
	
?>
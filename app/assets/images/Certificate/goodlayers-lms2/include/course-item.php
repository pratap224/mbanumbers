<?php
	/*	
	*	Goodlayers Course File
	*/		
	
	// print course search
	function gdlr_lms_print_course_search( $settings, $page_builder = false ){
	
		if( $page_builder ){
			$item_id = empty($settings['page-item-id'])? '': ' id="' . $settings['page-item-id'] . '" ';

			global $gdlr_spaces;
			$margin = (!empty($settings['margin-bottom']) && 
				$settings['margin-bottom'] != $gdlr_spaces['bottom-blog-item'])? 'margin-bottom: ' . $settings['margin-bottom'] . ';': '';
			$margin_style = (!empty($margin))? ' style="' . $margin . '" ': '';		
		
			echo gdlr_get_item_title($settings);
		}else{
			$item_id = ''; $margin_style= "";
		}

		$search_val = get_search_query();
		if( empty($search_val) ){
			$search_val = __("Keywords" , "gdlr_translate");
		}
		$categories = gdlr_lms_get_term_list('course_category');
		
		echo '<div class="course-search-wrapper" ' . $item_id . $margin_style . ' >';
?>
<form class="gdlr-lms-form" action="<?php echo home_url(); ?>/" >
	<div class="course-search-column gdlr-lms-1">
		<span class="gdlr-lms-combobox">
			<select name="course_category" >
				<option value="" ><?php _e('Category', 'gdlr-lms'); ?></option>
				<?php
					foreach( $categories as $slug => $category ){
						echo '<option value="' . $slug . '" >' . $category . '</option>';
					}
				?>
			</select>
		</span>
	</div>
	<div class="course-search-column gdlr-lms-2">
		<span class="gdlr-lms-combobox">
			<select name="course_type" id="gender" >
				<option value="" ><?php _e('Type', 'gdlr-lms'); ?></option>
				<option value="online" ><?php _e('Online Course', 'gdlr-lms'); ?></option>
				<option value="onsite" ><?php _e('Onsite Course', 'gdlr-lms'); ?></option>
			</select>
		</span>	
	</div>
	<div class="course-search-column gdlr-lms-3">
		<input type="text" name="s" id="s" autocomplete="off" placeholder="<?php echo $search_val; ?>" />
	</div>
	<div class="course-search-column gdlr-lms-4">
		<input type="hidden" name="post_type" value="course" />
		<input class="gdlr-lms-button" type="submit" value="<?php _e('Search!', 'gdlr-lms'); ?>" />
	</div>
	<div class="clear"></div>
</form>

<?php		
		echo '</div>'; // course-search-wrapper
	}
	
	// print course item
	function gdlr_lms_print_course_item( $settings, $page_builder = false ){

		if( $page_builder ){
			$item_id = empty($settings['page-item-id'])? '': ' id="' . $settings['page-item-id'] . '" ';

			global $gdlr_spaces;
			$margin = (!empty($settings['margin-bottom']) && 
				$settings['margin-bottom'] != $gdlr_spaces['bottom-blog-item'])? 'margin-bottom: ' . $settings['margin-bottom'] . ';': '';
			$margin_style = (!empty($margin))? ' style="' . $margin . '" ': '';		
		
			if( in_array($settings['course-style'], array('grid', 'grid-2')) &&
				$settings['course-layout'] == 'carousel' ){
				$settings['carousel'] = true;
			}
		
			echo gdlr_get_item_title($settings);
		}else{
			$item_id = ''; $margin_style= "";
		}

		echo '<div class="course-item-wrapper" ' . $item_id . $margin_style . ' >';

		// query course section
		$args = array('post_type' => 'course', 'suppress_filters' => false);
		$args['posts_per_page'] = (empty($settings['num-fetch']))? '3': $settings['num-fetch'];
		$args['orderby'] = (empty($settings['orderby']))? 'post_date': $settings['orderby'];
		$args['order'] = (empty($settings['order']))? 'desc': $settings['order'];
		$args['paged'] = (get_query_var('paged'))? get_query_var('paged') : 1;
	
		if( !empty($settings['category']) ){
			$args['tax_query'] = array(
				array('terms'=>explode(',', $settings['category']), 'taxonomy'=>'course_category', 'field'=>'slug')
			);		
		}			
		$query = new WP_Query( $args );

		$settings['course-layout'] = empty($settings['course-layout'])? 'fitRows': $settings['course-layout'];
		$settings['course-size'] = empty($settings['course-size'])? 3: $settings['course-size'];		
		if( $settings['course-style'] == 'grid' ){
			if($settings['course-layout'] == 'carousel'){
				gdlr_lms_print_course_grid_carousel($query, $settings['thumbnail-size'], $settings['course-size']);
			}else{
				gdlr_lms_print_course_grid($query, $settings['thumbnail-size'], $settings['course-size']);
			}
		}else if( $settings['course-style'] == 'grid-2' ){
			if($settings['course-layout'] == 'carousel'){
				gdlr_lms_print_course_grid2_carousel($query, $settings['thumbnail-size'], $settings['course-size']);
			}else{
				gdlr_lms_print_course_grid2($query, $settings['thumbnail-size'], $settings['course-size']);
			}
		}else if( $settings['course-style'] == 'medium' ){
			gdlr_lms_print_course_medium($query, $settings['thumbnail-size']);
		}else if( $settings['course-style'] == 'full' ){
			gdlr_lms_print_course_full($query, $settings['thumbnail-size'], $settings['num-excerpt']);
		}
		
		if($settings['pagination'] == 'enable'){
			echo gdlr_lms_get_pagination($query->max_num_pages, $args['paged']);
		}		
		
		echo '</div>'; // course-item-wrapper
	}

	// course full
	function gdlr_lms_print_course_full($query, $thumbnail, $num_excerpt = 50){
		global $gdlr_lms_excerpt_length; $gdlr_lms_excerpt_length = $num_excerpt;
		add_filter('excerpt_more', 'gdlr_lms_excerpt_more');	
		add_filter('excerpt_length', 'gdlr_lms_set_excerpt_length', 999);

		echo '<div class="gdlr-lms-course-full-wrapper">';
		while( $query->have_posts() ){ $query->the_post();
			$course_val = gdlr_lms_decode_preventslashes(get_post_meta(get_the_ID(), 'gdlr-lms-course-settings', true));
			$course_options = empty($course_val)? array(): json_decode($course_val, true);
		
			echo '<div class="gdlr-lms-course-full gdlr-lms-item">';
			gdlr_lms_print_course_thumbnail($thumbnail);
			
			echo '<div class="gdlr-lms-course-info-wrapper">';
			gdlr_lms_print_course_info($course_options);
			gdlr_lms_print_course_price($course_options);
			gdlr_lms_print_course_button($course_options, array('buy', 'book'));			
			echo '</div>';
			
			echo '<div class="gdlr-lms-course-content">';
			echo '<h3 class="gdlr-lms-course-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
			
			echo gdlr_lms_print_course_rating(get_the_ID());
			
			echo '<div class="gdlr-lms-course-excerpt">' . get_the_excerpt() . '</div>';
			echo '</div>'; // course-content
			
			echo '<div class="clear"></div>';
			echo '</div>'; // course-full
		}
		wp_reset_postdata();
		
		remove_filter('excerpt_more', 'gdlr_lms_excerpt_more');	
		remove_filter('excerpt_length', 'gdlr_lms_set_excerpt_length');
		echo '</div>'; // course-full-wrapper	
	}
	
	// course medium
	function gdlr_lms_print_course_medium($query, $thumbnail){
		echo '<div class="gdlr-lms-course-medium-wrapper">';
		while( $query->have_posts() ){ $query->the_post();
			$course_val = gdlr_lms_decode_preventslashes(get_post_meta(get_the_ID(), 'gdlr-lms-course-settings', true));
			$course_options = empty($course_val)? array(): json_decode($course_val, true);
		
			echo '<div class="gdlr-lms-course-medium gdlr-lms-item">';
			gdlr_lms_print_course_thumbnail($thumbnail);
			
			echo '<div class="gdlr-lms-course-content">';
			echo '<h3 class="gdlr-lms-course-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
			
			echo gdlr_lms_print_course_rating(get_the_ID());
			
			gdlr_lms_print_course_info($course_options);
			gdlr_lms_print_course_price($course_options);
			gdlr_lms_print_course_button($course_options, array('buy', 'book'));
			
			echo '</div>'; // course-content
			echo '<div class="clear"></div>';
			echo '</div>'; // course-medium
		}
		wp_reset_postdata();
		echo '</div>'; // course-medium-wrapper	
	}
	
	// course grid
	function gdlr_lms_print_course_grid($query, $thumbnail, $column = 3){
		$count = 0;
	
		echo '<div class="gdlr-lms-course-grid-wrapper">';
		while( $query->have_posts() ){ $query->the_post();
			if($count % $column == 0){ echo '<div class="clear"></div>'; } $count++; 
			
			$course_val = gdlr_lms_decode_preventslashes(get_post_meta(get_the_ID(), 'gdlr-lms-course-settings', true));
			$course_options = empty($course_val)? array(): json_decode($course_val, true);
		
			echo '<div class="gdlr-lms-course-grid gdlr-lms-col' . $column . '">';
			echo '<div class="gdlr-lms-item">';
			gdlr_lms_print_course_thumbnail($thumbnail);
			
			echo '<div class="gdlr-lms-course-content">';
			echo '<h3 class="gdlr-lms-course-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
			
			echo gdlr_lms_print_course_rating(get_the_ID());
			
			gdlr_lms_print_course_info($course_options);
			gdlr_lms_print_course_price($course_options);
			gdlr_lms_print_course_button($course_options, array('buy', 'book'));
			
			echo '</div>'; // course-content
			echo '<div class="clear"></div>';
			echo '</div>'; // lms-item
			echo '</div>'; // course-grid
		}
		wp_reset_postdata();
		echo '<div class="clear"></div>';
		echo '</div>'; // course-grid-wrapper	
	}	
	
	// course grid carousel
	function gdlr_lms_print_course_grid_carousel($query, $thumbnail, $column = 3){
		$count = 0;
	
		echo '<div class="gdlr-lms-course-grid-wrapper gdlr-lms-carousel">';
		echo '<div class="flexslider" data-type="carousel" data-nav-container="course-item-wrapper" data-columns="' . $column . '" >';	
		echo '<ul class="slides" >';	
		while( $query->have_posts() ){ $query->the_post();
			$course_val = gdlr_lms_decode_preventslashes(get_post_meta(get_the_ID(), 'gdlr-lms-course-settings', true));
			$course_options = empty($course_val)? array(): json_decode($course_val, true);
		
			echo '<li class="gdlr-lms-course-grid gdlr-lms-item">';
			gdlr_lms_print_course_thumbnail($thumbnail);
			
			echo '<div class="gdlr-lms-course-content">';
			echo '<h3 class="gdlr-lms-course-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
			
			gdlr_lms_print_course_info($course_options);
			gdlr_lms_print_course_price($course_options);
			gdlr_lms_print_course_button($course_options, array('buy', 'book'));
			
			echo '</div>'; // course-content
			echo '<div class="clear"></div>';
			echo '</li>'; // course-grid
		}
		wp_reset_postdata();
		echo '</ul>';
		echo '</div>'; // flexslider
		echo '</div>'; // course-grid-wrapper	
	}		
	
	// course grid
	function gdlr_lms_print_course_grid2($query, $thumbnail, $column = 3){
		$count = 0;
	
		echo '<div class="gdlr-lms-course-grid2-wrapper">';
		while( $query->have_posts() ){ $query->the_post();
			if($count % $column == 0){ echo '<div class="clear"></div>'; } $count++; 
			
			$course_val = gdlr_lms_decode_preventslashes(get_post_meta(get_the_ID(), 'gdlr-lms-course-settings', true));
			$course_options = empty($course_val)? array(): json_decode($course_val, true);
		
			$lms_item_class = (empty($course_options['price']) && empty($course_options['discount-price']))? 'gdlr-lms-free': '';
		
			echo '<div class="gdlr-lms-course-grid2 gdlr-lms-col' . $column . '">';
			echo '<div class="gdlr-lms-item ' . $lms_item_class . '">';
			gdlr_lms_print_course_thumbnail($thumbnail);
			
			echo '<div class="gdlr-lms-course-content">';
			echo '<h3 class="gdlr-lms-course-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
			
			// price
			echo '<div class="gdlr-lms-course-price">';
			if( !empty($course_options['price']) && empty($course_options['discount-price']) ){
				echo '<span class="price-button">' . gdlr_lms_money_format($course_options['price']) . '</span>';
			}else if( !empty($course_options['discount-price']) ){
				echo '<span class="price-button">' . gdlr_lms_money_format($course_options['discount-price']) . '</span>';
			}else{
				echo '<span class="price-button blue">' . __('Free' ,'gdlr-lms') . '</span>';
			}
			echo '</div>';
			
			// date
			echo '<div class="gdlr-lms-course-info" >';
			echo '<i class="icon-time"></i>';
			echo '<span class="tail">' . gdlr_lms_date_format($course_options['start-date']); 
			echo empty($course_options['end-date'])? '': ' - ' . gdlr_lms_date_format($course_options['end-date']);
			echo '</span>';
			echo '</div>';
			
			echo '<div class="clear"></div>';
			echo '</div>'; // course-content
			echo '</div>'; // lms-item
			echo '</div>'; // course-grid2
		}
		wp_reset_postdata();
		echo '<div class="clear"></div>';
		echo '</div>'; // course-grid-wrapper	
	}		
	
	// course grid
	function gdlr_lms_print_course_grid2_carousel($query, $thumbnail, $column = 3){
		$count = 0;
	
		echo '<div class="gdlr-lms-course-grid2-wrapper gdlr-lms-carousel">';
		echo '<div class="flexslider" data-type="carousel" data-nav-container="course-item-wrapper" data-columns="' . $column . '" >';	
		echo '<ul class="slides" >';		
		while( $query->have_posts() ){ $query->the_post();
			$course_val = gdlr_lms_decode_preventslashes(get_post_meta(get_the_ID(), 'gdlr-lms-course-settings', true));
			$course_options = empty($course_val)? array(): json_decode($course_val, true);
		
			$lms_item_class = (empty($course_options['price']) && empty($course_options['discount-price']))? 'gdlr-lms-free': '';
		
			echo '<li class="gdlr-lms-course-grid2 gdlr-lms-item ' . $lms_item_class . '">';
			gdlr_lms_print_course_thumbnail($thumbnail);
			
			echo '<div class="gdlr-lms-course-content">';
			echo '<h3 class="gdlr-lms-course-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
			
			// price
			echo '<div class="gdlr-lms-course-price">';
			if( !empty($course_options['price']) && empty($course_options['discount-price']) ){
				echo '<span class="price-button">' . gdlr_lms_money_format($course_options['price']) . '</span>';
			}else if( !empty($course_options['discount-price']) ){
				echo '<span class="price-button">' . gdlr_lms_money_format($course_options['discount-price']) . '</span>';
			}else{
				echo '<span class="price-button blue">' . __('Free' ,'gdlr-lms') . '</span>';
			}
			echo '</div>';
			
			// date
			echo '<div class="gdlr-lms-course-info" >';
			echo '<i class="icon-time"></i>';
			echo '<span class="tail">' . gdlr_lms_date_format($course_options['start-date']); 
			echo empty($course_options['end-date'])? '': ' - ' . gdlr_lms_date_format($course_options['end-date']);
			echo '</span>';
			echo '</div>';
			
			echo '<div class="clear"></div>';
			echo '</div>'; // course-content
			echo '</li>'; // course-grid2
		}
		wp_reset_postdata();
		echo '</ul>';
		echo '</div>';
		echo '</div>'; // course-grid-wrapper	
	}	
	
	// print course info
	function gdlr_lms_print_course_info($course_options, 
		$options = array('instructor', 'type', 'date', 'place', 'seat'), $additional_code = ''){
		
		echo '<div class="gdlr-lms-course-info">';
		foreach( $options as $value ){
			switch($value){
				case 'instructor':
					if( !empty($course_options['author_id']) ){
						$user_info = get_user_meta($course_options['author_id']);
					}else{
						global $post;
						$user_info = get_user_meta($post->post_author);
					}
					if( !empty($user_info) ){
						echo '<div class="gdlr-lms-info" >';
						echo '<span class="head">' . __('Instructor', 'gdlr-lms') . '</span>';
						echo '<span class="tail">' . $user_info['first_name'][0] . ' ' . $user_info['last_name'][0] . '</span>';
						echo '</div>';
					}
					break;
				case 'type': 
					if( !empty($course_options['online-course']) ){
						echo '<div class="gdlr-lms-info" >';
						echo '<span class="head">' . __('Type', 'gdlr-lms') . '</span>';
						echo '<span class="tail">';
						if( $course_options['online-course'] == 'enable' ){
							echo __('Online Course', 'gdlr-lms');
						}else{
							echo __('Onsite Course', 'gdlr-lms');
						}
						echo '</span>';
						echo '</div>';
					}
					break;
				case 'date': 
					if( !empty($course_options['start-date']) ){
						echo '<div class="gdlr-lms-info" >';
						echo '<span class="head">' . __('Date', 'gdlr-lms') . '</span>';
						echo '<span class="tail">' . gdlr_lms_date_format($course_options['start-date']); 
						echo empty($course_options['end-date'])? '': ' - ' . gdlr_lms_date_format($course_options['end-date']);
						echo '</span>';
						echo '</div>';
					}
					break;
				case 'place': 
					if( $course_options['online-course'] == 'disable' && !empty($course_options['location']) ){
						echo '<div class="gdlr-lms-info" >';
						echo '<span class="head">' . __('Place', 'gdlr-lms') . '</span>';
						echo '<span class="tail">' . $course_options['location'] . '</span>';
						echo '</div>';
					}
					break;
				case 'price': 
					echo '<div class="gdlr-lms-info" >';
					echo '<span class="head">' . __('Price', 'gdlr-lms') . '</span>';
					echo '<span class="tail">';
					echo empty($course_options['discount-price'])? gdlr_lms_money_format($course_options['price']): gdlr_lms_money_format($course_options['discount-price']);
					echo '</span>';
					echo '</div>';
					
					break;
				case 'seat': 
					if( $course_options['online-course'] == 'disable' && !empty($course_options['max-seat']) ){
						echo '<div class="gdlr-lms-info" >';
						echo '<span class="head">' . __('Seat', 'gdlr-lms') . '</span>';
						echo '<span class="tail">' . intval($course_options['booked-seat']) . '/' . intval($course_options['max-seat']) . '</span>';
						echo '</div>';
					}
					break;
			}
		}
		echo $additional_code;
		echo '</div>';
	}
	
	// course rating
	function gdlr_lms_print_course_rating($course_id){
		global $gdlr_lms_rating;
		
		if( empty($gdlr_lms_rating) ){ $gdlr_lms_rating = get_option('gdlr_lms_rating', array('course_id'=>'score')); }
		if( empty($gdlr_lms_rating[$course_id]) ) return;
		
		$num_user = 0;
		$all_score = 0;
		foreach($gdlr_lms_rating[$course_id] as $score){ $num_user++;
			$all_score += floatval($score);
		}
		
		$star_count = 0;
		$rating_score = $all_score / $num_user;
		echo '<div class="gdlr-lms-rating-wrapper">';
		while($star_count < 5){ $star_count++;
			if( $rating_score > 1 ){
				$rating_score--;
				echo '<i class="icon-star"></i>';
			}else if( $rating_score > 0.75 ){
				$rating_score = 0;
				echo '<i class="icon-star"></i>';
			}else if( $rating_score > 0.25 ){
				$rating_score = 0;
				echo '<i class="icon-star-half-full"></i>';
			}else{
				echo '<i class="icon-star-empty"></i>';
			}
		}
		echo '<span class="gdlr-lms-rating-amount">(' . $num_user . ' ' . __('ratings', 'gdlr-lms') . ')</span>';
		echo '</div>';
	}
	
	// check if it's already paid course
	function gdlr_lms_check_course_registered(){
		global $wpdb, $post, $current_user;
		
		if( is_user_logged_in() ){
			$sql  = 'SELECT payment_status FROM ' . $wpdb->prefix . 'gdlrpayment ';
			$sql .= 'WHERE course_id=' . $post->ID . ' AND student_id=' . $current_user->ID;
			$find_row = $wpdb->get_row($sql);
			
			if(!empty($find_row)) return $find_row->payment_status;
		}
		return false;
	}
	
	// print course price
	function gdlr_lms_print_course_price($course_options){
		echo '<div class="gdlr-lms-course-price">';
		echo '<span class="head">' . __('Price', 'gdlr-lms') . '</span>';
		if( !empty($course_options['price']) && empty($course_options['discount-price']) ){
			echo '<span class="price">' . gdlr_lms_money_format($course_options['price']) . '</span>';
		}else if( !empty($course_options['discount-price']) ){
			echo '<span class="price with-discount">' . gdlr_lms_money_format($course_options['price']) . '</span>';
			echo '<span class="discount-price">' . gdlr_lms_money_format($course_options['discount-price']) . '</span>';
		}else{
			echo '<span class="price">' . __('Free' ,'gdlr-lms') . '</span>';
		}
		echo '</div>';
	}
	
	// print course button
	function gdlr_lms_print_course_button($course_options, $options = array('buy', 'book', 'learn')){
		global $gdlr_lms_option;
		
		echo '<div class="gdlr-course-button" >';	
		if( !is_user_logged_in() ){
			$lightbox_open = 'login-form';
			gdlr_lms_sign_in_lightbox_form();
		}else{
		
			if( in_array('buy', $options) || in_array('book', $options) ){
				$payment_status = gdlr_lms_check_course_registered();
				
				if((empty($course_options['price']) && empty($course_options['discount-price'])) || $payment_status == 'paid'){
					if( empty($course_options['online-course']) || $course_options['online-course'] == 'enable' ){
						$options = array('start');
					}else if( $payment_status == 'reserved' ){
						$options = array('booking-status');
					}else if( $payment_status != 'paid' ){
						$options = array('book');
					}else{
						$options = array();
					}
				}else if( $payment_status == 'pending' || $payment_status == 'submitted' ){
					$options = array('proceed-payment');
				}
				
				if(in_array('buy', $options) && !empty($gdlr_lms_option['payment-method']) && $gdlr_lms_option['payment-method'] == 'receipt'){
					unset($options[array_search('buy', $options)]);
				}
			}
		}
		
		foreach( $options as $value ){
			switch($value){
				case 'buy': 
					echo '<a data-rel="gdlr-lms-lightbox" data-lb-open="';
					echo empty($lightbox_open)? 'buy-form': $lightbox_open;
					echo '" class="gdlr-lms-button cyan" >' . __('Buy Now', 'gdlr-lms') . '</a>';
					if(empty($lightbox_open)){ gdlr_lms_purchase_lightbox_form($course_options, 'buy'); }
					break;
				case 'book': 
					echo '<a data-rel="gdlr-lms-lightbox" data-lb-open="';
					echo empty($lightbox_open)? 'book-form': $lightbox_open;
					echo '" class="gdlr-lms-button blue" >' . __('Book Now', 'gdlr-lms') . '</a>';
					if(empty($lightbox_open)){ gdlr_lms_purchase_lightbox_form($course_options, 'book'); }
					break;
				case 'learn': 
					echo '<a class="gdlr-lms-button black" href="' . get_permalink() . '" >' . __('Learn More', 'gdlr-lms') . '</a>';
					break;
				case 'start': 
					echo '<a class="gdlr-lms-button cyan" href="' . add_query_arg(array('course_type'=>'content', 'course_page'=>1), get_permalink()) . '" >';
					_e('Start the course', 'gdlr-lms');
					echo '</a>';
					break;
				case 'proceed-payment':
					global $current_user;
					
					echo '<a class="gdlr-lms-button cyan" href="' . add_query_arg('type', 'book-courses', get_author_posts_url($current_user->ID)) . '" >';
					_e('Proceed Payment', 'gdlr-lms');
					echo '</a>';
					break;
				case 'booking-status':
					global $current_user;
					
					echo '<a class="gdlr-lms-button cyan" href="' . add_query_arg('type', 'free-onsite', get_author_posts_url($current_user->ID)) . '" >';
					_e('Booking Status', 'gdlr-lms');
					echo '</a>';
					break;					
				case 'quiz': 
					if( !empty($course_options['quiz']) && $course_options['quiz'] != 'none' ){
						global $wpdb, $current_user;
						$sql  = 'SELECT * FROM ' . $wpdb->prefix . 'gdlrquiz ';
						$sql .= 'WHERE quiz_id=' . $course_options['quiz'] . ' AND student_id=' . $current_user->ID . ' AND course_id=' . get_the_ID() . ' ';
						$sql .= 'AND (quiz_status=\'complete\' OR quiz_status=\'submitted\')';
						$old_quiz = $wpdb->get_row($sql);	
						
						if( !empty($old_quiz) ){
							$quiz_val = gdlr_lms_decode_preventslashes(get_post_meta($course_options['quiz'], 'gdlr-lms-quiz-settings', true));
							$quiz_options = empty($quiz_val)? array(): json_decode($quiz_val, true);						
							if( !empty($quiz_options['retake-quiz']) && $quiz_options['retake-quiz'] == 'enable' &&
								$old_quiz->retake_times < 9999 &&
								(empty($quiz_options['retake-times']) || $old_quiz->retake_times < intval($quiz_options['retake-times'])) ){
								echo '<a class="gdlr-lms-button cyan" href="' . add_query_arg(array('course_type'=>'quiz', 'course_page'=>1, 'retake'=>1), get_permalink()) . '" >';
								_e('Retake a quiz', 'gdlr-lms');
								echo '</a>';							
							}
						}else{
							echo '<a class="gdlr-lms-button cyan" href="' . add_query_arg(array('course_type'=>'quiz', 'course_page'=>1), get_permalink()) . '" >';
							_e('Take a quiz', 'gdlr-lms');
							echo '</a>';
						}
					}
					break;
				case 'finish-quiz': 
					echo '<a href="' . add_query_arg(array('course_type'=>'quiz', 'course_page'=> 'finish')) . '" ';
					echo 'data-loading="' . __('Summitting the answer','gdlr-lms') . '" ';
					echo 'class="gdlr-lms-button cyan finish-quiz-form-button" >';
					_e('Finish the quiz', 'gdlr-lms');
					echo '</a>';
					gdlr_lms_finish_quiz_form();
					break;					
			}
		}
		echo '</div>';
	}
	
	// print course thumbnail
	function gdlr_lms_print_course_thumbnail($size = 'full'){
		$image_id = get_post_thumbnail_id();
		if(empty($image_id)) return;
		
		$image =  wp_get_attachment_image_src($image_id, $size);
		$alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);	

		echo '<div class="gdlr-lms-course-thumbnail">';
		echo (!is_single())? '<a href="' . get_permalink() . '" >': '';
		echo '<img src="' . $image[0] . '" alt="' . $alt . '" width="' . $image[1] . '" height="' . $image[2] . '" />';
		echo (!is_single())? '</a>': '';
		echo '</div>';
	}
		
?>
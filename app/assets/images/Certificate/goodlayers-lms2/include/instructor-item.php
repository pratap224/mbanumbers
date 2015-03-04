<?php
	/*	
	*	Goodlayers Instructor File
	*/	

	function gdlr_lms_get_author_image($author_id, $size){
		$image_id = get_user_meta($author_id, 'author-image', true);
		if( !empty($image_id) ){
			$image_url = wp_get_attachment_image_src($image_id, $size);
			return '<img alt="" src="' . $image_url[0] . '" width="' . $image_url[1] . '" height="' . $image_url[2] . '" />';
		}
		return ;
	}
	
	function gdlr_lms_print_instructor_item( $settings, $page_builder = false ){
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

		// query instructor
		if( !empty($settings['instructor-type']) && $settings['instructor-type'] == 'single' ){
			$query = array($settings['user']);
			
			$settings['instructor-size'] = 1;
		}else{
			$paged = (get_query_var('paged'))? get_query_var('paged') : 1;
			
			$args = array();
			$args['role'] = (empty($settings['role']) || $settings['role'] == 'all')? '': $settings['role'];
			$args['orderby'] = (empty($settings['orderby']))? 'display_name': $settings['orderby'];
			$args['order'] = (empty($settings['order']))? 'asc': $settings['order'];
			$args['number'] = (empty($settings['num-fetch']))? '6': $settings['num-fetch'];
			$args['offset'] = (intval($paged) - 1) * intval($args['number']);
			$query = get_users($args);
			
			$settings['instructor-size'] = empty($settings['instructor-size'])? 3: $settings['instructor-size'];
		}
		
		echo '<div class="instructor-item-wrapper" ' . $item_id . $margin_style . ' >';
		if( $settings['instructor-style'] == 'grid' ){
			gdlr_lms_print_instructor_grid($query, $settings['thumbnail-size'], $settings['instructor-size'], $settings['num-excerpt']);
		}else if( $settings['instructor-style'] == 'grid-2' ){
			gdlr_lms_print_instructor_grid2($query, $settings['thumbnail-size'], $settings['instructor-size'], $settings['num-excerpt']);
		}

		if( !empty($settings['instructor-type']) && $settings['instructor-type'] == 'multiple' && 
			!empty($settings['pagination']) && $settings['pagination'] == 'enable'){
			
			echo gdlr_lms_get_pagination($query->max_num_pages, $paged);
		}			
		echo '</div>'; // instructor-item-wrapper
	}
	
	// instructor grid
	function gdlr_lms_print_instructor_grid($query, $thumbnail = 'full', $column = 3, $excerpt){
		$count = 0;
		echo '<div class="gdlr-lms-instructor-grid-wrapper">';
		foreach($query as $author){
			$author_id = empty($author->data->ID)? $author: $author->data->ID;
			$author_meta = get_user_meta($author_id);
		
			if($count % $column == 0){ echo '<div class="clear"></div>'; } $count++; 
			
			echo '<div class="gdlr-lms-instructor-grid gdlr-lms-col' . $column . '">';
			echo '<div class="gdlr-lms-item">';
			
			echo '<div class="gdlr-lms-instructor-content">';
			echo '<div class="gdlr-lms-instructor-thumbnail">' . gdlr_lms_get_author_image($author_id, $thumbnail) . '</div>';
			
			echo '<div class="gdlr-lms-instructor-title-wrapper">';
			echo '<h3 class="gdlr-lms-instructor-title">';
			echo $author_meta['first_name'][0] . ' ' . $author_meta['last_name'][0];
			echo '</h3>';
			if( !empty($author_meta['position']) ){
				echo '<div class="gdlr-lms-instructor-position">' . $author_meta['position'][0] . '</div>';
			}
			echo '</div>'; // instructor-title-wrapper
			
			if( !empty($author_meta['description']) ){
				echo '<div class="gdlr-lms-author-description">' . wp_trim_words($author_meta['description'][0], $excerpt) . '</div>';
			}
			
			echo '<a class="gdlr-lms-button cyan" href="' . get_author_posts_url($author_id) . '">' . __('View Profile', 'gdlr-lms') . '</a>';
			echo '</div>'; // instructor-content
			echo '<div class="clear"></div>';
			echo '</div>'; // lms-item
			echo '</div>'; // instructor-grid
		}
		wp_reset_postdata();
		echo '<div class="clear"></div>';
		echo '</div>'; // course-grid-wrapper	
	}	

	// instructor grid 2
	function gdlr_lms_print_instructor_grid2($query, $thumbnail = 'full', $column = 3, $excerpt){
		$count = 0;
		echo '<div class="gdlr-lms-instructor-grid2-wrapper">';
		foreach($query as $author){
			$author_id = empty($author->data->ID)? $author: $author->data->ID;
			$author_meta = get_user_meta($author_id);
		
			if($count % $column == 0){ echo '<div class="clear"></div>'; } $count++; 
			
			echo '<div class="gdlr-lms-instructor-grid2 gdlr-lms-col' . $column . '">';
			echo '<div class="gdlr-lms-item">';
			echo '<div class="gdlr-lms-instructor-thumbnail">' . gdlr_lms_get_author_image($author_id, $thumbnail) . '</div>';
			echo '<div class="gdlr-lms-instructor-content">';

			echo '<div class="gdlr-lms-instructor-title-wrapper">';
			echo '<h3 class="gdlr-lms-instructor-title">';
			echo $author_meta['first_name'][0] . ' ' . $author_meta['last_name'][0];
			echo '</h3>';
			if( !empty($author_meta['position']) ){
				echo '<div class="gdlr-lms-instructor-position">' . $author_meta['position'][0] . '</div>';
			}
			echo '</div>'; // instructor-title-wrapper
			
			if( !empty($author_meta['description']) ){
				echo '<div class="gdlr-lms-author-description">' . wp_trim_words($author_meta['description'][0], $excerpt) . '</div>';
			}
			
			echo '<a class="gdlr-lms-button cyan" href="' . get_author_posts_url($author_id) . '">' . __('View Profile', 'gdlr-lms') . '</a>';
			echo '</div>'; // instructor-content
			echo '<div class="clear"></div>';
			echo '</div>'; // lms-item
			echo '</div>'; // instructor-grid
		}
		wp_reset_postdata();
		echo '<div class="clear"></div>';
		echo '</div>'; // course-grid-wrapper	
	}		
	
?>
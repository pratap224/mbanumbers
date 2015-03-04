<h3 class="gdlr-lms-admin-head" ><?php _e('Scoring status', 'gdlr-lms'); ?></h3>
<table class="gdlr-lms-table">
<tr>
	<th><?php _e('Course Name', 'gdlr-lms'); ?></th>
	<th align="center" ><?php _e('Scoring status', 'gdlr-lms'); ?></th>
</tr>
<?php 
	$args = array('post_type' => 'course', 'suppress_filters' => false);
	$args['author'] = $current_user->ID;
	$args['posts_per_page'] = 9999;
	$args['orderby'] = 'post_date';
	$args['order'] = 'desc';		
	$query = new WP_Query($args);
	
	while( $query->have_posts() ){ $query->the_post();
		$course_val = gdlr_lms_decode_preventslashes(get_post_meta(get_the_ID(), 'gdlr-lms-course-settings', true));
		$course_options = empty($course_val)? array(): json_decode($course_val, true);	
		
		$temp_sql  = "SELECT COUNT(*) FROM " . $wpdb->prefix . "gdlrquiz ";
		$temp_sql .= "WHERE course_id = " . get_the_ID() . " ";
		$temp_sql .= "AND (quiz_status IS NULL OR quiz_status != 'complete') ";		
		$count = $wpdb->get_var($temp_sql);
		
		echo '<tr>';
		echo '<td><a href="' . add_query_arg(array('type'=>'scoring-status-student', 'course_id'=>get_the_ID(), 'quiz_id'=>$course_options['quiz'])) . '" >';
		echo get_the_title();
		echo '</a></td>';
		
		echo '<td>';
		echo ($count > 0)? __('Pending', 'gdlr-lms'): __('Complete', 'gdlr-lms');
		echo '</td>';
		echo '</tr>';		
	}
	wp_reset_postdata();
?>
</table>
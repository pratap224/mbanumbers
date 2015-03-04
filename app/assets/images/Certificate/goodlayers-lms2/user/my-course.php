<h3 class="gdlr-lms-admin-head" ><?php _e('My Courses', 'gdlr-lms'); ?></h3>
<table class="gdlr-lms-table">
<tr>
	<th><?php _e('Course Name', 'gdlr-lms'); ?></th>
	<th align="center" ><?php _e('Students', 'gdlr-lms'); ?></th>
	<th align="center" ><?php _e('Course Code', 'gdlr-lms'); ?></th>
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

		echo '<tr class="with-divider">';
		echo '<td><a href="' . add_query_arg(array('type'=>'my-course-student', 'course_id'=>get_the_ID())) . '" >' . get_the_title() . '</a>';
		gdlr_lms_print_course_info($course_options, array('date', 'type'));
		echo '</td>';
		
		$seat  = empty($course_options['booked-seat'])? 0: $course_options['booked-seat'];
		$seat .= empty($course_options['max-seat'])? '': '/' . $course_options['max-seat'];
		
		echo '<td>' . $seat . '</td>';
		echo '<td>' . $course_options['course-code'] . get_the_ID() . '</td>';
		echo '</tr>';		
	}
?>
</table>
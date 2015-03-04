<h3 class="gdlr-lms-admin-head" ><?php _e('My Courses', 'gdlr-lms'); ?></h3>
<table class="gdlr-lms-table">
<tr>
	<th><?php _e('Student', 'gdlr-lms'); ?></th>
	<th align="center" ><?php _e('Manual Check', 'gdlr-lms'); ?></th>
	<th align="center" ><?php _e('Score', 'gdlr-lms'); ?></th>
</tr>
<?php 
	foreach( $manual_check_results as $result ){ 
		$user_info = get_user_meta($result->student_id);
		
		$quiz_score = unserialize($result->quiz_score);
		$quiz_score = empty($quiz_score)? array(): $quiz_score;
		$score_summary = gdlr_lms_score_summary($quiz_score);	
	
		echo '<tr class="with-divider">';
		echo '<td><a href="' . add_query_arg(array('type'=>'scoring-status-part', 'course_id'=>$result->course_id, 'quiz_id'=>$result->quiz_id, 'student_id'=>$result->student_id)) . '" >';
		echo $user_info['first_name'][0] . ' ' . $user_info['last_name'][0];
		echo '</a>';
		echo '<div class="gdlr-lms-course-info"><span class="tail">' . get_the_title($result->course_id) . '</span></div>';
		echo '</td>';
		echo '<td>' . __('Pending', 'gdlr-lms') . '</td>';
		echo '<td>' . $score_summary['score'] . '/' . $score_summary['from'] . '</td>';
		echo '</tr>';		
	}
?>
</table>
<h3 class="gdlr-lms-admin-head" ><?php _e('Scoring status', 'gdlr-lms'); ?></h3>
<table class="gdlr-lms-table">
<tr>
	<th><?php _e('Student', 'gdlr-lms'); ?></th>
	<th align="center" ><?php _e('Manual Check', 'gdlr-lms'); ?></th>
	<th align="center" ><?php _e('Score', 'gdlr-lms'); ?></th>
</tr>
<?php 
	$temp_sql  = "SELECT student_id, quiz_score, quiz_status FROM " . $wpdb->prefix . "gdlrquiz ";
	$temp_sql .= "WHERE course_id = " . $_GET['course_id'] . " ";
	$temp_sql .= "AND quiz_id = " . $_GET['quiz_id'];

	$results = $wpdb->get_results($temp_sql);
	foreach($results as $result){
		$user_info = get_user_meta($result->student_id);

		$quiz_score = unserialize($result->quiz_score);
		$quiz_score = empty($quiz_score)? array(): $quiz_score;
		$score_summary = gdlr_lms_score_summary($quiz_score);
		
		echo '<tr>';
		echo '<td><a href="' . add_query_arg(array('type'=>'scoring-status-part', 'course_id'=>$_GET['course_id'], 'quiz_id'=>$_GET['quiz_id'], 'student_id'=>$result->student_id)) . '" >';
		echo $user_info['first_name'][0] . ' ' . $user_info['last_name'][0];
		echo '</a></td>';
		
		echo '<td>';
		echo ($result->quiz_status != 'complete')? __('Pending', 'gdlr-lms'): __('Complete', 'gdlr-lms');
		echo '</td>';
		
		echo '<td>';
		echo $score_summary['score'] . '/' . $score_summary['from'];
		echo '</td>';
		echo '</tr>';		
	}
?>
</table>
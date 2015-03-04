<h3 class="gdlr-lms-admin-head" ><?php _e('Scoring status', 'gdlr-lms'); ?></h3>
<table class="gdlr-lms-table">
<tr>
	<th><?php _e('Summary', 'gdlr-lms'); ?></th>
	<th align="center" ><?php _e('Scores', 'gdlr-lms'); ?></th>
</tr>
<?php 
	$quiz_val = gdlr_lms_decode_preventslashes(get_post_meta($_GET['quiz_id'], 'gdlr-lms-content-settings', true));
	$quiz_options = empty($quiz_val)? array(): json_decode($quiz_val, true);	

	$sql  = 'SELECT quiz_answer, quiz_score FROM ' . $wpdb->prefix . 'gdlrquiz ';
	$sql .= 'WHERE quiz_id=' . $_GET['quiz_id'] . ' AND student_id=' . $_GET['student_id'] . ' AND course_id=' . $_GET['course_id'];
	$current_row = $wpdb->get_row($sql);	
	$quiz_answer = unserialize($current_row->quiz_answer);
	
	$quiz_score = unserialize($current_row->quiz_score);
	$quiz_score = empty($quiz_score)? array(): $quiz_score;
	$score_summary = gdlr_lms_score_part_summary($quiz_score);

	$pnum = 0;
	foreach($quiz_options as $quiz_option){
		echo '<tr>';
		echo '<td>' . $quiz_option['section-name'] . '</td>';
		
		echo '<td>';
		echo empty($score_summary[$pnum])? __('Pending', 'gdlr-lms'): $score_summary[$pnum]['score'] . '/' . $score_summary[$pnum]['from'];
		echo '</td>';
		echo '</tr>';		
		
		$pnum++;
	}
	
	// summary
	$score_summary = gdlr_lms_score_summary($quiz_score);
	echo '<tr>';
	echo '<td>' . __('Overall', 'gdlr-lms') . '</td>';
	
	echo '<td>';
	echo $score_summary['score'] . '/' . $score_summary['from'];
	echo '</td>';
	echo '</tr>';
?>
</table>

<!-- scoring part -->
<?php
	$pnum = 0;
	foreach($quiz_options as $quiz_option){
		//display only large and small fill
		//if( $quiz_option['question-type'] == 'large' || $quiz_option['question-type'] == 'small' ){
			echo '<form class="gdlr-lms-form gdlr-scoring-quiz-wrapper" action="" method="post">';
			echo '<h3 class="gdlr-scoring-quiz-title">' . $quiz_option['section-name'] . '</h3>';
			echo '<div class="gdlr-scoring-quiz-content">';
			
			$qnum = 0;
			$quiz_option['question'] = json_decode($quiz_option['question'], true);
			foreach( $quiz_option['question'] as $question ){
				echo '<div class="gdlr-scoring-quiz-qustion-wrapper">';
				echo '<div class="gdlr-scoring-quiz-question">' . ($qnum+1) . '. ' . $question['question'] . '</div>';
				
				echo '<div class="gdlr-scoring-quiz-answer">';
				echo '<span class="gdlr-head">' . __('Answer :', 'gdlr-lms') . '</span>';
				if( !empty($quiz_answer[$pnum][$qnum]) ){
					if( $quiz_option['question-type'] == 'single' ){
						echo $quiz_answer[$pnum][$qnum] . '.) ' . $question['quiz-choice'][$quiz_answer[$pnum][$qnum]];
					}else if( $quiz_option['question-type'] == 'multiple' ){
						foreach( $quiz_answer[$pnum][$qnum] as $answer ){
							if( sizeof($quiz_answer[$pnum][$qnum]) > 1 ){ echo '<br>'; }
							echo $answer . '.) ' . $question['quiz-choice'][$answer];
						}	
					}else{
						echo '<span class="gdlr-tail">' . $quiz_answer[$pnum][$qnum] . '</span>';
					}
				}else{
					echo '-';
				}
				echo '<div class="clear"></div>';
				echo '</div>';
				
				echo '<div class="gdlr-scoring-score">';
				echo '<span class="gdlr-head" >' . __('Score :', 'gdlr-lms') . '</span>';
				if( !empty($quiz_score[$pnum][$qnum]['score']) ){
					echo '<input type="text" name="score[]" value="' . $quiz_score[$pnum][$qnum]['score'] . '" />';
				}else{
					echo '<input type="text" name="score[]" value="0" />';
				}
				echo '<input type="hidden" name="from[]" value="' . $question['score'] . '" />';
				echo '<span class="gdlr-tail" > / ' . $question['score'] . '</span>';
				echo '</div>';
				echo '</div>';
				
				$qnum++;
			}
			echo '<input type="hidden" name="action" value="scoring-status-part" />';
			echo '<input type="hidden" name="pnum" value="' . $pnum . '" />';
			echo '<input type="submit" value="' . __('Submit Score', 'gdlr-lms') . '" />';
			echo '</div>';
			echo '</form>';
		//}
		$pnum++;
	}


?>
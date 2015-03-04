<?php
	global $wpdb, $current_user;
	
	$sql  = 'SELECT id, retake_times ';
	$sql .= 'FROM ' . $wpdb->prefix . 'gdlrquiz ';
	$sql .= 'WHERE course_id=' . $_GET['course_id'] . ' AND quiz_id=' . $_GET['quiz_id'] . ' AND student_id=' . $current_user->ID . ' ';
	$result = $wpdb->get_row($sql);
	
	if( $result->retake_times < 9999 ){
		$update = $wpdb->update( $wpdb->prefix . 'gdlrquiz', 
			array('retake_times'=>9999), array('id'=>$result->id), 
			array('%d'), array('%d')
		);	
	}
	
	if( !empty($result) ){
	
		$lms_page = (empty($_GET['quiz_page']))? 1: intval($_GET['quiz_page']);
		$quiz_val = gdlr_lms_decode_preventslashes(get_post_meta($_GET['quiz_id'], 'gdlr-lms-content-settings', true));
		$quiz_options = empty($quiz_val)? array(): json_decode($quiz_val, true);	
	
		echo '<div class="gdlr-lms-course-content">';
		echo '<h3>' . __('Part', 'gdlr-lms') . $lms_page . ' ' . $quiz_options[$lms_page-1]['section-name'] . '</h3>';
		echo '<div class="gdlr-lms-quiz-content-wrapper">';
		
		if( in_array($quiz_options[$lms_page-1]['question-type'], array('large', 'small')) ){
			echo '<div class="gdlr-lms-no-answer-message" >' . __('No answer provided for writing part', 'gdlr-lms') . '</div>';
			echo '<div class="gdlr-lms-course-pagination">';
			if( $lms_page > 1 ){
				echo '<a href="' . add_query_arg(array('quiz_page'=> $lms_page-1)) . '" class="gdlr-lms-button blue">';
				echo __('Previous Part', 'gdlr-lms');
				echo '</a>';
			}
			if( $lms_page < sizeof($quiz_options) ){
				echo '<a href="' . add_query_arg(array('quiz_page'=> $lms_page+1)) . '" class="gdlr-lms-button blue">';
				echo __('Next Part', 'gdlr-lms');
				echo '</a>';
			}			
			echo '</div>';
		}else{
			$count = 0;
			$quiz_options[$lms_page-1]['question'] = json_decode($quiz_options[$lms_page-1]['question'], true);
			foreach($quiz_options[$lms_page-1]['question'] as $question){ $count++;
				echo '<div class="gdlr-lms-quiz-question-wrapper">';
				echo '<div class="gdlr-lms-quiz-question">' . $count . '. ' . $question['question'] . '</div>';
				echo '<div class="gdlr-lms-quiz-answer">';
				switch($quiz_options[$lms_page-1]['question-type']){
					case 'single':
						$choice_count = 0;
						foreach($question['quiz-choice'] as $quiz_choice){ $choice_count++;
							echo '<div class="gdlr-lms-quiz-choice">';
							echo '<input type="radio" value="' . $choice_count . '" name="question' . ($count-1) . '" ';
							if( $choice_count == $question['quiz-answer'] ){
								echo 'checked ';
							}else{
								echo 'disabled ';
							}
							echo '/>' . $quiz_choice;
							echo '</div>';
						}
						break;
					case 'multiple':
						$choice_count = 0;
						$answer = explode(',', $question['quiz-answer']);
						foreach($question['quiz-choice'] as $quiz_choice){ $choice_count++;
							echo '<div class="gdlr-lms-quiz-choice">'; 
							echo '<input type="checkbox" value="' . $choice_count . '" name="question' . ($count-1) . '[]" ';
							if( in_array($choice_count, $answer) ){
								echo 'checked ';
							}else{
								echo 'disabled ';
							}
							echo '/>' . $quiz_choice;
							echo '</div>';
						}
						break;
					case 'large':
					case 'small':
						echo '<textarea name="question' . ($count-1) . '">';
						if( !empty($quiz_answer[$lms_page-1][$count-1]) ){
							echo $quiz_answer[$lms_page-1][$count-1];
						}
						echo '</textarea>';
						break;
				}
				echo '<div class="gdlr-lms-question-score" >';
				echo '<span class="gdlr-head">'; 
				echo empty($question['score'])? 1: $question['score'];
				echo '</span>';
				echo '<span class="gdlr-tail">' . __('Point(s)', 'gdlr-lms') . '</span>'; 
				echo '</div>'; // question-score
				
				echo '</div>'; // quiz-answer
				echo '</div>'; // question-wrapper
			}
			echo '</div>'; // quiz-content-wrapper

			echo '<div class="gdlr-lms-course-pagination">';
			if( $lms_page > 1 ){
				echo '<a href="' . add_query_arg(array('quiz_page'=> $lms_page-1)) . '" class="gdlr-lms-button blue">';
				echo __('Previous Part', 'gdlr-lms');
				echo '</a>';
			}
			if( $lms_page < sizeof($quiz_options) ){
				echo '<a href="' . add_query_arg(array('quiz_page'=> $lms_page+1)) . '" class="gdlr-lms-button blue">';
				echo __('Next Part', 'gdlr-lms');
				echo '</a>';
			}
			echo '</div>'; // pagination
			echo '</div>'; // course-content
		}
	}
?>
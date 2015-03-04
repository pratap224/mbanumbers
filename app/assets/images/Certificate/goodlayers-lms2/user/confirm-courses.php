<h3 class="gdlr-lms-admin-head" ><?php _e('Confirmed Courses', 'gdlr-lms'); ?></h3>
<table class="gdlr-lms-table">
<tr>
	<th><?php _e('Course Name', 'gdlr-lms'); ?></th>
	<th><?php _e('Status', 'gdlr-lms'); ?></th>
	<th><?php _e('Code', 'gdlr-lms'); ?></th>
</tr>
<?php 
	$temp_sql  = "SELECT id, course_id, payment_status, payment_info FROM " . $wpdb->prefix . "gdlrpayment ";
	$temp_sql .= "WHERE student_id = " . $current_user->data->ID . " ";
	$temp_sql .= "AND payment_status = 'paid' AND ";
	$temp_sql .= "(attendance IS NULL OR attendance = cast('0000-00-00' as DATETIME) OR attendance > cast('" . date('Y-m-d') . "' as DATETIME))";

	$results = $wpdb->get_results($temp_sql);
	foreach($results as $result){
		$course_val = gdlr_lms_decode_preventslashes(get_post_meta($result->course_id, 'gdlr-lms-course-settings', true));
		$course_options = empty($course_val)? array(): json_decode($course_val, true);	
		$payment_info = unserialize($result->payment_info);
		
		echo '<tr class="with-divider">';
		echo '<td>';
		echo '<a href="' . get_permalink($result->course_id) . '" >' . get_the_title($result->course_id) . '</a>';
		$additional_html = '';
		if( $payment_info['amount'] > 1 ){
			$additional_html .= '<div class="gdlr-lms-info">';
			$additional_html .= '<span class="head">' . __('Amount', 'gdlr-lms') . '</span>';
			$additional_html .= '<span class="tail">' . $payment_info['amount'] . ' ' . __('Seats', 'gdlr-lms') . '</span>';		
			$additional_html .= '</div>';		
		}		
		gdlr_lms_print_course_info($course_options, array('date', 'price'), $additional_html);
		echo '</td>';
		
		echo '<td class="gdlr-' . $result->payment_status . '">' . $result->payment_status . '</td>';
		echo '<td>' . $payment_info['code'] . '</td>';
		echo '</tr>';
	}
?>
</table>

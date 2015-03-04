<?php
	$course_val = gdlr_lms_decode_preventslashes(get_post_meta($_GET['course_id'], 'gdlr-lms-course-settings', true));
	$course_options = empty($course_val)? array(): json_decode($course_val, true);
?>
<h3 class="gdlr-lms-admin-head" ><?php echo get_the_title($_GET['course_id']); ?></h3>
<table class="gdlr-lms-table">
<tr>
	<th><?php _e('Student', 'gdlr-lms'); ?></th>
	<?php if($course_options['online-course'] == 'disable'){ ?>
	<th align="center" ><?php _e('Seat', 'gdlr-lms'); ?></th>
	<?php } ?>
	<th align="center" ><?php _e('Code', 'gdlr-lms'); ?></th>
</tr>
<?php 
	$temp_sql  = "SELECT student_id, payment_info FROM " . $wpdb->prefix . "gdlrpayment ";
	$temp_sql .= "WHERE course_id = " . $_GET['course_id'] . " ";
	$temp_sql .= "AND payment_status = 'paid'";
	
	$results = $wpdb->get_results($temp_sql);
	foreach($results as $result){
		$user_info = get_user_meta($result->student_id);
		$payment_info = unserialize($result->payment_info);
		
		echo '<tr>';
		echo '<td>' . $user_info['first_name'][0] . ' ' . $user_info['last_name'][0] . '</td>';
		if($course_options['online-course'] == 'disable'){
			echo '<td>' . $payment_info['amount'] . '</td>';
		}
		echo '<td>' . $payment_info['code'] . '</td>';
		echo '</tr>';
	}	
?>
</table>
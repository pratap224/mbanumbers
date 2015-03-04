<?php
	/*	
	*	Goodlayers Transaction File
	*/
	
	function gdlr_lms_transaction_option(){
?>
<div class="wrap">
<h2><?php _e('Transaction List', 'gdlr-lms'); ?></h2>
<form class="gdlr-lms-transaction-form" method="GET" action="">
	<div class="gdlr-lms-transaction-form-row">
		<span class="gdlr-lms-head"><?php _e('Search transaction by :', 'gdlr-lms'); ?></span>
		<div class="gdlr-combobox-wrapper">
		<select name="selector" >
			<option value="name" <?php echo (!empty($_GET['selector']) && $_GET['selector']=='name')? 'selected': ''; ?> ><?php _e('Name', 'gdlr-lms'); ?></option>
			<option value="code" <?php echo (!empty($_GET['selector']) &&$_GET['selector']=='code')? 'selected': ''; ?> ><?php _e('Code', 'gdlr-lms'); ?></option>
		</select>
		</div>
		<div class="clear"></div>
	</div>
	<div class="gdlr-lms-transaction-form-row">
		<span class="gdlr-lms-head"><?php _e('Keywords :', 'gdlr-lms'); ?></span>
		<input type="text" name="keywords" value="<?php echo !empty($_GET['keywords'])? $_GET['keywords']: ''; ?>" />
		<input type="hidden" name="page" value="lms-transaction" />
		<input type="submit" value="<?php _e('Search!', 'gdlr-lms'); ?>" />
		<div class="clear"></div>
	</div>
</form>
<table class="gdlr-lms-table">
<tr>
	<th><?php _e('ID', 'gdlr-lms'); ?></th>
	<th><?php _e('Name', 'gdlr-lms'); ?></th>
	<th><?php _e('Course', 'gdlr-lms'); ?></th>
	<th><?php _e('Type', 'gdlr-lms'); ?></th>
	<th><?php _e('Price', 'gdlr-lms'); ?></th>
	<th><?php _e('Status', 'gdlr-lms'); ?></th>
	<th><?php _e('Code', 'gdlr-lms'); ?></th>
	<th><?php _e('Booked/Paid Date', 'gdlr-lms'); ?></th>
</tr>
<?php 
	global $wpdb;

	$temp_sql  = "SELECT id, course_id, student_id, payment_info, payment_status, payment_date, price ";
	$temp_sql .= "FROM " . $wpdb->prefix . "gdlrpayment ";
	$temp_sql .= "WHERE  price != 0 ";
	
	if( !empty($_GET['selector']) && !empty($_GET['keywords']) ){
		if( $_GET['selector'] == 'name' ){
			$user_array = array();
			$users = new WP_User_Query(array(
				'meta_query' => array(
					'relation' => 'OR',
					array('key'=> 'first_name', 'value'=> $_GET['keywords'], 'compare' => 'LIKE'),
					array('key'=> 'last_name', 'value'=> $_GET['keywords'], 'compare' => 'LIKE')
				)
			));
			$users_found = $users->get_results();
			foreach( $users_found as $user ){
				if( !in_array($user->ID, $user_array) ) $user_array[] = $user->ID;
			}
			$users = new WP_User_Query(array(
				'search'         => '*'.esc_attr($_GET['keywords']).'*',
				'search_columns' => array('user_login','user_nicename')
			));
			$users_found = $users->get_results();
			foreach( $users_found as $user ){
				if( !in_array($user->ID, $user_array) ) $user_array[] = $user->ID;
			}
			
			$temp_sql .= 'WHERE student_id IN (' . implode(",", $user_array) . ') ';
			
		}else if( $_GET['selector'] == 'code' ){
			$temp_sql .= 'WHERE payment_info LIKE \'%code%' . $_GET['keywords'] . '%\' ';
		}

	}
	$temp_sql  .= "ORDER BY id desc";

	$results = $wpdb->get_results($temp_sql);
	foreach($results as $result){
		$course_val = gdlr_lms_decode_preventslashes(get_post_meta($result->course_id, 'gdlr-lms-course-settings', true));
		$course_options = empty($course_val)? array(): json_decode($course_val, true);			

		$payment_info = unserialize($result->payment_info);
		$payment_info['code'] = empty($payment_info['code'])? '': $payment_info['code'];
		$student_info = get_userdata($result->student_id);

		echo '<tr>';
		echo '<td>' . $result->id . '</td>';
		echo '<td class="evidence-of-payment-name">';
		echo $student_info->first_name . ' ' . $student_info->last_name;
		echo '<div class="evidence-of-payment-name-hover" >';
		foreach($payment_info as $key => $value){
			echo '<div class="evidence-of-payment-info">';
			echo '<span class="head">' . $key . ' :</span>';
			if( $key == 'price' ){
				echo '<span class="tail">' . gdlr_lms_money_format($value) . '</span>';
			}else{
				echo '<span class="tail">' . $value . '</span>';
			}
			echo '</div>';
		}
		echo '</div>'; // evd-of-payment-name-hover
		echo '</td>'; // evd-of-payment-name
		
		echo '<td>' . $course_options['course-code'] . $result->course_id . '</td>';
		echo '<td>';
		echo ($course_options['online-course']=='enable')? __('Online', 'gdlr-lms'): __('Onsite', 'gdlr-lms');
		echo '</td>';
		echo '<td>' . gdlr_lms_money_format(number_format_i18n($result->price, 2)) . '</td>';
		echo '<td>' . $result->payment_status  . '</td>';
		
		echo '<td>' . $payment_info['code'] . '</td>';
		echo '<td>' . gdlr_lms_date_format($result->payment_date) . '</td>';
		echo '</tr>';
	} 
?>
</table>
</div>
<?php
	}
?>
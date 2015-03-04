<h3 class="gdlr-lms-admin-head with-sub" ><?php _e('Earning', 'gdlr-lms'); ?></h3>
<h4 class="gdlr-lms-admin-sub-head" ><?php 
	global $gdlr_lms_option, $current_user;

	$commission_table = get_option('gdlr-lms-commission', array());
	_e('Your commission rate is', 'gdlr-lms'); 
	if(empty($commission_table[$current_user->ID])){
		$commission_rate = empty($gdlr_lms_option['default-instructor-commission'])? 100: $gdlr_lms_option['default-instructor-commission'];
	}else{
		$commission_rate = $commission_table[$current_user->ID];
	}
	echo ' ' . $commission_rate . '%';
?></h4>
<?php
	$start_date = empty($_GET['start-date'])? date('Y-m-01'): $_GET['start-date']; 
	$end_date = empty($_GET['end-date'])? date('Y-m-t'): $_GET['end-date']; 
?>
<form class="gdlr-lms-date-filter-form" method="GET" action="">
	<span class="gdlr-lms-head"><?php _e('Filter :', 'gdlr-lms'); ?></span>
	<input type="text" name="start-date" class="gdlr-lms-date-picker" placeholder="<?php _e('Start Date', 'gdlr-lms'); ?>" value="<?php echo $start_date; ?>" />
	<i class="icon-calendar"></i>
	<i class="icon-long-arrow-right"></i>
	<input type="text" name="end-date" class="gdlr-lms-date-picker" placeholder="<?php _e('End Date', 'gdlr-lms'); ?>" value="<?php echo $end_date; ?>" />
	<i class="icon-calendar"></i>
	<input type="hidden" name="type" value="earning" />
	<input type="submit" value="<?php _e('Filter!', 'gdlr-lms'); ?>" />
</form>

<table class="gdlr-lms-table">
<tr>
	<th><?php _e('Course', 'gdlr-lms'); ?></th>
	<th><?php _e('Revenue', 'gdlr-lms'); ?></th>
	<th><?php _e('My Earning', 'gdlr-lms'); ?></th>
</tr>
<?php 
	$temp_sql  = "SELECT course_id, SUM(price) AS revenue FROM " . $wpdb->prefix . "gdlrpayment ";
	$temp_sql .= "WHERE price != 0 AND payment_status = 'paid' AND author_id=" . $current_user->ID . " ";
	$temp_sql .= "AND payment_date >= cast('" . $start_date . "' as DATETIME) ";
	$temp_sql .= "AND payment_date <= cast('" . $end_date . "' as DATETIME) ";
	$temp_sql .= "GROUP BY course_id";	
	
	$sum_price = 0;
	$results = $wpdb->get_results($temp_sql);
	foreach($results as $result){
		$sum_price += floatval($result->revenue);
		
		echo '<tr>';
		echo '<td>' . get_the_title($result->course_id) . '</td>';
		
		echo '<td>' . gdlr_lms_money_format(number_format_i18n($result->revenue, 2)) . '</td>';
		echo '<td>' . gdlr_lms_money_format(number_format_i18n(floatval($result->revenue) * floatval($commission_rate) / 100, 2)) . '</td>';
		echo '</tr>';
	}
	
	echo '<tr class="with-top-divider">';
	echo '<td>' . __('Total', 'gdlr-lms') . '</td>';
	echo '<td>' . gdlr_lms_money_format(number_format_i18n($sum_price, 2)) . '</td>';
	echo '<td>' . gdlr_lms_money_format(number_format_i18n($sum_price * floatval($commission_rate) / 100, 2)) . '</td>';
	echo '</tr>';
?>
</table>
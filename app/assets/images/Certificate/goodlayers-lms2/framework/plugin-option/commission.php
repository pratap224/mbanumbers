<?php
	/*	
	*	Goodlayers Statement File
	*/
	
	function gdlr_lms_commission_option(){
	global $wpdb, $gdlr_lms_option;
		$gdlr_lms_option['default-instructor-commission'] = empty($gdlr_lms_option['default-instructor-commission'])? 100: $gdlr_lms_option['default-instructor-commission'];	
	
		$gdlr_lms_commission = get_option('gdlr-lms-commission', array()); 
		if( !empty($_GET['author_id']) && !empty($_GET['commission_rate']) ){
			$gdlr_lms_commission[$_GET['author_id']] = $_GET['commission_rate'];
			update_option('gdlr-lms-commission', $gdlr_lms_commission);
		}	
?>
<div class="wrap">
<h2><?php _e('Instructor Commission', 'gdlr-lms'); ?></h2>

<!-- query form -->
<table class="gdlr-lms-table">
<tr>	
	<th class="gdlr-left-aligned"><?php _e('Instructor', 'gdlr-lms'); ?></th>
	<th><?php _e('Revenue', 'gdlr-lms'); ?></th>
	<th><?php _e('Commission (%)', 'gdlr-lms'); ?></th>
	<th><?php _e('Action', 'gdlr-lms'); ?></th>
</tr>
<?php 
	$instructors = array();
	$instructors_list = get_users(array('role'=>'instructor'));
	foreach($instructors_list as $instructor){
		$instructors[$instructor->ID] = $instructor->ID;
	} 

	$temp_sql  = "SELECT author_id, SUM(price) AS revenue FROM " . $wpdb->prefix . "gdlrpayment ";
	$temp_sql .= "WHERE price != 0 AND payment_status = 'paid' ";
	$temp_sql .= "GROUP BY author_id";		
	
	$results = $wpdb->get_results($temp_sql);
	foreach($results as $result){
		$commission_rate = empty($gdlr_lms_commission[$result->author_id])? $gdlr_lms_option['default-instructor-commission']: $gdlr_lms_commission[$result->author_id];
		
		echo '<tr>';
		echo '<td class="gdlr-left-aligned">' . get_user_meta($result->author_id, 'first_name', true) . ' ' . get_user_meta($result->author_id, 'last_name', true) . '</td>';
		echo '<td>' . gdlr_lms_money_format(number_format_i18n($result->revenue, 2)) . '</td>';
		echo '<td>' . $commission_rate . '%</td>';
		
		echo '<td>';
		echo '<a data-rel="gdlr-lms-lightbox" data-lb-open="commission-rate">' . __('Change % Rate', 'gdlr-lms') . '</a>';
		echo gdlr_lms_lightbox_commission_form($commission_rate, $result->author_id);
		echo '</td>';	
		echo '</tr>';
		
		unset($instructors[$result->author_id]);
	}
	foreach($instructors as $instructor_id){
		$commission_rate = empty($gdlr_lms_commission[$instructor_id])? $gdlr_lms_option['default-instructor-commission']: $gdlr_lms_commission[$instructor_id];
	
		echo '<tr>';
		echo '<td class="gdlr-left-aligned">' . get_user_meta($instructor_id, 'first_name', true) . ' ' . get_user_meta($instructor_id, 'last_name', true) . '</td>';
		echo '<td>' . gdlr_lms_money_format(number_format_i18n(0, 2)) . '</td>';

		echo '<td>' . $commission_rate . '%</td>';
		echo '<td>';
		echo '<a data-rel="gdlr-lms-lightbox" data-lb-open="commission-rate">' . __('Change % Rate', 'gdlr-lms') . '</a>';
		echo gdlr_lms_lightbox_commission_form($commission_rate, $instructor_id);
		echo '</td>';		
		echo '</tr>';	
	}
?>
</table>
</div>
<?php
	}
	
	// lightbox for commission changing
	function gdlr_lms_lightbox_commission_form($rate, $author_id){
?>
<div class="gdlr-lms-lightbox-container light commission-rate">	
	<h3 class="gdlr-lms-lightbox-title"><?php echo __('Commission Rate (%)', 'gdlr-lms'); ?></h3>
	<form class="gdlr-lms-form gdlr-lms-lightbox-form" method="get">
		<input type="text" name="commission_rate" value="<?php echo $rate; ?>" />
		<input type="hidden" name="page" value="lms-commission" />
		<input type="hidden" name="type" value="instructor" />
		<input type="hidden" name="author_id" value="<?php echo $author_id; ?>" />
		<input type="submit" class="gdlr-lms-button" value="<?php _e('Update Rate', 'gdlr-lms'); ?>" />
		<div class="clear"></div>
	</form>
</div>
<?php	
	}
	
?>
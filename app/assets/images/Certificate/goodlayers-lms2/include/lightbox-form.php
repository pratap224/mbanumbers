<?php
	/*	
	*	Goodlayers Lightbox Form File
	*/	
	
	function gdlr_lms_sign_in_lightbox_form(){
?>
<div class="gdlr-lms-lightbox-container login-form">
	<div class="gdlr-lms-lightbox-close"><i class="icon-remove"></i></div>

	<h3 class="gdlr-lms-lightbox-title"><?php _e('Please sign in first', 'gdlr-lms'); ?></h3>	
	<form class="gdlr-lms-form gdlr-lms-lightbox-form" method="post" action="<?php echo esc_url(site_url('wp-login.php', 'login_post')); ?>">
		<p class="gdlr-lms-half-left">
			<span><?php _e('Username', 'gdlr-lms'); ?></span>
			<input type="text" name="log" />
		</p>
		<p class="gdlr-lms-half-right">
			 <span><?php _e('Password', 'gdlr-lms'); ?></span>
			 <input type="password" name="pwd" />
		</p>
		<div class="clear"></div>
		<p>
			<input type="hidden" name="rememberme"  value="forever" />
			<input type="hidden" name="redirect_to" value="<?php echo add_query_arg($_GET) ?>" />
			<input type="submit" class="gdlr-lms-button" value="<?php _e('Sign In!', 'gdlr-lms'); ?>" />
		</p>
	</form>
	<h3 class="gdlr-lms-lightbox-title second-section"><?php _e('Not a member?', 'gdlr-lms'); ?></h3>
	<div class="gdlr-lms-lightbox-description"><?php _e('Please simply create an account before buying/booking any courses.', 'gdlr-lms'); ?></div>
	<a class="gdlr-lms-button blue" href="<?php echo add_query_arg('register', get_permalink(), home_url()); ?>"><?php _e('Create an account for free!', 'gdlr-lms'); ?></a>
</div>
<?php 
	}

	function gdlr_lms_quiz_timeout_form($page = 0){
?>
<div class="gdlr-lms-lightbox-container quiz-timeout-form">
	<h3 class="gdlr-lms-lightbox-title"><?php _e('Time out!', 'gdlr-lms'); ?></h3>
	<div class="gdlr-lms-lightbox-quiz-timeout-content">
		<?php if( !empty($page) ){ ?>
		<div class="quiz-timeout-content"><?php
			_e('This part is timeout! press the button below to skip to next part', 'gdlr-lms');
		?></div> 
		<a class="gdlr-lms-button blue submit-quiz-form" href="<?php echo add_query_arg(array('course_type'=>'quiz', 'course_page'=> $page)); ?>" ><?php
			_e('Continue the quiz', 'gdlr-lms');
		?></a>
		<?php }else{ ?>
		<div class="quiz-timeout-content"><?php
			_e('This part is timeout! press the button to submit the quiz', 'gdlr-lms');
		?></div> 
		<a class="gdlr-lms-button blue submit-quiz-timeout-form" ><?php
			_e('Submit the quiz', 'gdlr-lms');
		?></a>		
		<?php } ?>
	</div>
	
</div>
<?php	
	}
	
	function gdlr_lms_finish_quiz_form(){
?>
<div class="gdlr-lms-lightbox-container finish-quiz-form">
	<h3 class="gdlr-lms-lightbox-title"><?php _e('Quiz Complete!', 'gdlr-lms'); ?></h3>
	<div class="gdlr-lms-lightbox-finish-quiz-content">
		<div class="finish-quiz-content"><?php
			_e('You can check score in your profile page', 'gdlr-lms');
		?></div> 
		<a class="gdlr-lms-button cyan" href="<?php echo get_permalink(); ?>"><?php
			_e('Back to the course', 'gdlr-lms');
		?></a>
	</div>
</div>
<?php	
	}

	function gdlr_lms_rating_form($course_id){ 
?>
<div class="gdlr-lms-lightbox-container rating-form">
	<div class="gdlr-lms-lightbox-close"><i class="icon-remove"></i></div>
	
	<h3 class="gdlr-lms-lightbox-title"><?php echo __('Rate the course', 'gdlr-lms'); ?></h3>
	<div class="gdlr-lms-lightbox-sub-title"><?php echo get_the_title($course_id); ?></div> 
	
	<form class="gdlr-lms-form gdlr-lms-lightbox-form" method="post" action="<?php echo add_query_arg('type', 'attended-courses'); ?>">
		<div class="gdlr-rating-input">
			<span class="gdlr-rating-separator" data-value="0"></span>
			<i class="icon-star-empty" data-value="0.5"></i>
			<span class="gdlr-rating-separator" data-value="1"></span>
			<i class="icon-star-empty" data-value="1.5"></i>
			<span class="gdlr-rating-separator" data-value="2"></span>
			<i class="icon-star-empty" data-value="2.5"></i>
			<span class="gdlr-rating-separator" data-value="3"></span>
			<i class="icon-star-empty" data-value="3.5"></i>
			<span class="gdlr-rating-separator" data-value="4"></span>
			<i class="icon-star-empty" data-value="4.5"></i>
			<span class="gdlr-rating-separator" data-value="5"></span>
		</div>
		<input type="hidden" class="rating-input" name="rating" />
		<input type="hidden" name="course_id" value="<?php echo $course_id; ?>" />
		<input type="submit" class="gdlr-lms-button cyan" value="<?php echo esc_attr(__('Rate !', 'gdlr-lms')); ?>" />
	</form>
	
</div>
<?php		
	}
	
	function gdlr_lms_payment_option_form(){ 
?>
<div class="gdlr-lms-lightbox-container payment-option-form">
	<div class="gdlr-lms-lightbox-close"><i class="icon-remove"></i></div>
	
	<div class="gdlr-lms-payment-option-wrapper gdlr-lms-left">
		<div class="gdlr-lms-payment-option-inner">
			<h4 class="gdlr-lms-payment-option-head"><?php _e('Pay now via PayPal.', 'gdlr-lms'); ?></h4>
			<a class="gdlr-lms-button cyan" data-rel="gdlr-lms-lightbox3" data-lb-open="buy-form" ><?php _e('Pay Now', 'gdlr-lms'); ?></a>
			<div class="gdlr-lms-payment-option-description"><?php
				_e('* You\'re not required to submit evidence of payment after you pay via PayPal.','gdlr-lms');
			?></div>
		</div>
	</div>
	<div class="gdlr-lms-payment-option-or"><?php _e('OR', 'gdlr-lms'); ?></div>
	<div class="gdlr-lms-payment-option-wrapper gdlr-lms-right">
		<div class="gdlr-lms-payment-option-inner">
			<h4 class="gdlr-lms-payment-option-head"><?php _e('Submit evidence of payment.', 'gdlr-lms'); ?></h4>
			<a class="gdlr-lms-button blue" data-rel="gdlr-lms-lightbox3" data-lb-open="evidence-form" ><?php _e('Continue', 'gdlr-lms'); ?></a>
			<div class="gdlr-lms-payment-option-description"><?php
				_e('* Noted that you must pay via method we provided before sumitting evidence.','gdlr-lms');
			?></div>
		</div>
	</div>
</div>
<?php		
	}
	
	function gdlr_lms_evidence_lightbox_form($fix_val = array(), $close = 'close'){
?>
<div class="gdlr-lms-lightbox-container evidence-form">
	<?php
		if($close == 'close'){
			echo '<div class="gdlr-lms-lightbox-close"><i class="icon-remove"></i></div>';
		}else if($close != 'none'){
			echo '<div class="gdlr-lms-lightbox-back gdlr-lms-button cyan" data-rel="gdlr-lms-lightbox3" data-lb-open="' . $close . '"><i class="icon-arrow-left"></i></div>';
		}
	?>
	<h3 class="gdlr-lms-lightbox-title"><?php echo $fix_val['title']; ?></h3>
	<form class="gdlr-lms-form gdlr-lms-lightbox-form" method="post" enctype="multipart/form-data" action="<?php echo add_query_arg($_GET); ?>">
		<p>
			<span><?php _e('Additional Note', 'gdlr-lms'); ?></span>
			<textarea class="full-note" name="additional-note" ><?php echo $fix_val['additional_note'] ?></textarea>
		</p>
		<p>
			<span><?php _e('Select Attachment', 'gdlr-lms'); ?></span>
			<input type="file" name="attachment" />
		</p>		
		<p>
			<span><?php _e('Total Price', 'gdlr-lms'); ?></span>
			<input type="text" value="<?php echo gdlr_lms_money_format($fix_val['price']); ?>" disabled />
		</p>	
		<p>
			<input type="hidden" name="action" value="submit-evidence" />
			<input type="hidden" name="invoice" value="<?php echo $fix_val['id']; ?>">
			<input type="submit" class="gdlr-lms-button" value="<?php _e('Submit', 'gdlr-lms'); ?>" />
		</p>
	</form>
</div>
<?php
	}
	
	function gdlr_lms_purchase_lightbox_form($course_option, $type, $fix_val = array(), $close = 'close'){
		global $current_user, $lms_paypal, $lms_money_format;
		if( !empty($fix_val) ){
			$disabled = 'disabled';
			$fix_val['amount'] = intval($fix_val['amount']);
			$fix_val['form-class'] = 'gdlr-no-ajax';
			$fix_val['course-id'] = '';
			$fix_val['return'] = '';
		}else{
			$user_info = get_userdata($current_user->data->ID);
			$user_meta = get_user_meta($current_user->data->ID); 
			$disabled = '';
			$fix_val = array(
				'id' => '',
				'title' => get_the_title(),
				'first_name' => $user_meta['first_name'][0],
				'last_name' => $user_meta['last_name'][0],
				'email' => $user_info->data->user_email,
				'phone' => empty($user_meta['phone'])? '': $user_meta['phone'][0],
				'address' => empty($user_meta['address'])? '': $user_meta['address'][0],
				'additional_note' => '',
				'amount' => 1,
				'form-class' => '',
				'course-id'=> get_the_ID(),
				'return'=> get_permalink()
			);
		}
		
?>
<div class="gdlr-lms-lightbox-container <?php echo $type; ?>-form">
	<?php
		if($close == 'close'){
			echo '<div class="gdlr-lms-lightbox-close"><i class="icon-remove"></i></div>';
		}else if($close != 'none'){
			echo '<div class="gdlr-lms-lightbox-back gdlr-lms-button cyan" data-rel="gdlr-lms-lightbox3" data-lb-open="' . $close . '"><i class="icon-arrow-left"></i></div>';
		}
	?>

	<h3 class="gdlr-lms-lightbox-title"><?php echo $fix_val['title']; ?></h3>
	<form class="gdlr-lms-form gdlr-lms-lightbox-form <?php echo $fix_val['form-class']; ?>" method="post" <?php
		if( $type == 'buy' ) echo 'action="' . $lms_paypal['url'] . '"'
	?> data-ajax="<?php echo admin_url('admin-ajax.php'); ?>">
		<p class="gdlr-lms-half-left">
			<span><?php _e('Name', 'gdlr-lms'); ?></span>
			<input type="text" name="first_name" value="<?php echo $fix_val['first_name']; ?>" <?php echo $disabled; ?> />
		</p>
		<p class="gdlr-lms-half-right">
			 <span><?php _e('Lastname', 'gdlr-lms'); ?></span>
			 <input type="text" name="last_name" value="<?php echo $fix_val['last_name']; ?>" <?php echo $disabled; ?> />
		</p>
		<div class="clear"></div>
		<p class="gdlr-lms-half-left">
			<span><?php _e('Email', 'gdlr-lms'); ?></span>
			<input type="text" name="email" value="<?php echo $fix_val['email']; ?>" <?php echo $disabled; ?> />
		</p>
		<p class="gdlr-lms-half-right">
			 <span><?php _e('Phone', 'gdlr-lms'); ?></span>
			 <input type="text" name="phone" value="<?php echo $fix_val['phone']; ?>" <?php echo $disabled; ?> />
		</p>
		<div class="clear"></div>
		<p class="gdlr-lms-half-left">
			<span><?php _e('Address', 'gdlr-lms'); ?></span>
			<textarea name="address" <?php echo $disabled; ?>><?php echo $fix_val['address']; ?></textarea>
		</p>
		<p class="gdlr-lms-half-right">
			<span><?php _e('Additional Note', 'gdlr-lms'); ?></span>
			<textarea name="additional-note" <?php echo $disabled; ?>><?php echo $fix_val['additional_note'] ?></textarea>
		</p>	
		<div class="clear"></div>
		<p class="gdlr-lms-half-left">
			<span><?php _e('Amount', 'gdlr-lms'); ?></span>
			<?php $amount_disabled = ($disabled == 'disabled' || $course_option['online-course'] == 'enable')? 'disabled': ''; ?>
			<input type="text" name="quantity" value="<?php echo $fix_val['amount']; ?>" <?php echo $amount_disabled; ?>/>
		</p>
		<?php 
			$price = empty($course_option['discount-price'])? $course_option['price']: $course_option['discount-price']; 
			$price = floatval($price);
		?>
		<p class="gdlr-lms-half-right">
			 <span><?php _e('Total Price', 'gdlr-lms'); ?></span>
			 <input type="text" class="price-display" value="<?php echo gdlr_lms_money_format($price * $fix_val['amount']); ?>" disabled />
			 <input type="hidden" class="price" name="price" value="<?php echo ($price * $fix_val['amount']); ?>" />
			 <input type="hidden" class="price-one" name="amount" value="<?php echo $price; ?>" />
			 <input type="hidden" class="format" value="<?php echo $lms_money_format; ?>" />
		</p>
		<div class="clear"></div>		
		<p>
			<div class="gdlr-lms-notice">notice</div>
			<div class="gdlr-lms-loading">loading</div>
			<input type="hidden" name="rememberme"  value="forever" />
			<input type="hidden" name="course_id"  value="<?php echo $fix_val['course-id']; ?>" />
			<input type="hidden" name="course_code"  value="<?php echo $course_option['course-code']; ?>" />
			<input type="hidden" name="student_id"  value="<?php echo $current_user->data->ID; ?>" />
			<input type="hidden" name="action" value="gdlr_lms_form_purchase" />
			<input type="hidden" name="action_type" value="<?php echo $type; ?>" />
			<?php if($type == "buy"){ ?>
				<input type="hidden" name="cmd" value="_xclick">
				<input type="hidden" name="return" value="<?php echo $fix_val['return']; ?>">
				<input type="hidden" name="invoice" value="<?php echo $fix_val['id']; ?>">
				<input type="hidden" name="business" value="<?php echo $lms_paypal['recipient']; ?>">
				<input type="hidden" name="item_name" value="<?php echo esc_attr($fix_val['title']); ?>" />
				<input type="hidden" name="currency_code" value="<?php echo $lms_paypal['currency_code']; ?>" />
			
			<?php } ?>
			<?php wp_nonce_field( 'gdlr_lms_purchase_form', 'gdlr_lms_purchase_form' ); ?>
			<input type="submit" class="gdlr-lms-button" value="<?php 
				echo ($type == 'book')? __('Book Now!', 'gdlr-lms'): __('Pay Now!', 'gdlr-lms'); 
			?>" />
		</p>
	</form>	
</div>
<?php	
	}
	
	// action when book form is submitted
	add_action( 'wp_ajax_gdlr_lms_form_purchase', 'gdlr_lms_form_purchase' );
	add_action( 'wp_ajax_nopriv_gdlr_lms_form_purchase', 'gdlr_lms_form_purchase' );
	function gdlr_lms_form_purchase(){	
		$ret = array();
		
		if(wp_verify_nonce($_POST['gdlr_lms_purchase_form'], 'gdlr_lms_purchase_form')){ 
			
			global $wpdb;
			
			$sql  = 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'gdlrpayment ';
			$sql .= 'WHERE course_id=' . $_POST['course_id'] . ' AND student_id=' . $_POST['student_id'];
			$booked_course = $wpdb->get_var($sql);		

			if( $booked_course ){
				$ret['status'] = 'failed';
				$ret['message'] = __('You already booked this course, please proceed the payment via your profile page.');
					
			}else{
				$course_val = gdlr_lms_decode_preventslashes(get_post_meta($_POST['course_id'], 'gdlr-lms-course-settings', true));
				$course_options = empty($course_val)? array(): json_decode($course_val, true);					
				$course_price = !empty($course_options['discount-price'])? $course_options['discount-price']: $course_options['price'];			
				$_POST['quantity'] = empty($_POST['quantity'])? 1: $_POST['quantity'];
				$course_price = floatval($course_price) * intval($_POST['quantity']);
				
				if( abs($course_price - floatval($_POST['price'])) > 0.00001 ){
					$ret['status'] = 'failed';
					$ret['message'] = __('An error is occurred, please refresh the page to try this again.', 'gdlr-lms');				
				}else{
					if( !empty($course_options['booked-seat']) && $course_options['online-course'] == 'disable' &&
						intval($course_options['booked-seat']) + intval($_POST['quantity']) > intval($course_options['max-seat']) ){
						$ret['status'] = 'failed';
						$ret['message'] = __('This course is already full or the available seat is not enough, please try again later.', 'gdlr-lms');
					}else{
						$running_number = intval(get_post_meta($_POST['course_id'], 'student-booking-id', true));
						$running_number = empty($running_number)? 1: $running_number + 1;
						update_post_meta($_POST['course_id'], 'student-booking-id', $running_number);
						
						$code  = substr($_POST['first_name'], 0, 1) . substr($_POST['last_name'], 0, 1);
						$code .= $running_number . $_POST['course_code'] . $_POST['course_id'];
						
						$data = serialize(array(
							'first_name' => $_POST['first_name'],
							'last_name' => $_POST['last_name'],
							'email' => $_POST['email'],
							'phone' => $_POST['phone'],
							'address' => $_POST['address'],
							'additional_note' => $_POST['additional-note'],
							'amount' => $_POST['quantity'],
							'price' => $_POST['price'],
							'code' => $code
						));
						
						$payment_status = 'pending';
						if(empty($course_options['price']) && empty($course_options['discount-price'])){
							$payment_status = 'reserved';
						}
						$temp_post = get_post($_POST['course_id']);
						$result = $wpdb->insert( $wpdb->prefix . 'gdlrpayment', 
							array('course_id'=>$_POST['course_id'], 'student_id'=>$_POST['student_id'], 'author_id'=>$temp_post->post_author,
								'payment_date'=>date('Y-m-d'), 'payment_info'=>$data, 'payment_status'=>$payment_status, 'price'=>$_POST['price'],
								'attendance'=>$course_options['start-date']), 
							array('%d', '%d', '%d', '%s', '%s', '%s', '%s', '%s') 
						);

						if( $result > 0 ){
							$ret['id'] = $wpdb->insert_id;
							$ret['status'] = 'success';
							if( $_POST['action_type'] == 'book' ){
								$ret['message'] = __('Booking complete');
							}else{
								$ret['message'] = __('Booking complete, redirecting to paypal');
								$ret['redirect'] = true;
							}
							
							// increase seat value
							$course_options['booked-seat'] = intval($course_options['booked-seat']) + intval($_POST['quantity']);
							update_post_meta($_POST['course_id'], 'gdlr-lms-course-settings', json_encode($course_options));
						}else{
							$ret['status'] = 'failed';
							$ret['message'] = __('Transaction error, please contact the administrator');
						}
					}
				}
			}
		}else{
			$ret['status'] = 'failed';
			$ret['message'] = __('Session expired, please refresh the page and try this again', 'gdlr-lms');
		}
		
		die(json_encode($ret));
	}
	
	// action for cancel booking
	add_action( 'wp_ajax_gdlr_lms_cancel_booking', 'gdlr_lms_cancel_booking' );
	add_action( 'wp_ajax_nopriv_gdlr_lms_cancel_booking', 'gdlr_lms_cancel_booking' );
	function gdlr_lms_cancel_booking(){	
		global $wpdb;

		$sql  = 'SELECT * FROM ' . $wpdb->prefix . 'gdlrpayment ';
		$sql .= 'WHERE id=' . $_POST['id'] . ' AND ';
		$sql .= '(payment_status=\'pending\' OR payment_status=\'submitted\' OR payment_status=\'reserved\')';
		$booked_course = $wpdb->get_row($sql);	
		if( !empty($booked_course) ){
			$payment_info = unserialize($booked_course->payment_info);
			
			$course_val = gdlr_lms_decode_preventslashes(get_post_meta($booked_course->course_id, 'gdlr-lms-course-settings', true));
			$course_options = empty($course_val)? array(): json_decode($course_val, true);	
			$course_options['booked-seat'] = intval($course_options['booked-seat']) - intval($payment_info['amount']);
			update_post_meta($booked_course->course_id, 'gdlr-lms-course-settings', json_encode($course_options));
			
			$wpdb->delete( $wpdb->prefix . 'gdlrpayment', array('id'=>$_POST['id']), array('%d'));
		}
		die("");
	}
	
?>
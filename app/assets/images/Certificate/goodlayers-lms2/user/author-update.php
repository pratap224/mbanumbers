<?php
	global $current_user; $success = array(); $error = array(); get_currentuserinfo();
	if( $_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['action']) ){
	
		// pasword changing page
		if($_POST['action'] == 'change-password'){
			if( empty($_POST['old-pass']) || empty($_POST['new-pass']) || empty($_POST['repeat-pass']) ){
				$error[] = __('Please enter all required fields.', 'gdlr-lms');
			}else if( $_POST['new-pass'] != $_POST['repeat-pass'] ){
				$error[] = __('New password and password confirmation do not match.', 'gdlr-lms');
			}else if( !wp_check_password($_POST['old-pass'], $current_user->data->user_pass, $current_user->data->ID) ){
				$error[] = __('The password you typed is incorrect.', 'gdlr-lms');
			}else{
				wp_update_user(array( 
					'ID' => $current_user->ID, 
					'user_pass' => esc_attr($_POST['new-pass']) 
				));
				
				$success[] = __('Password is changed', 'gdlr-lms');
			}
			
		// edit profile page
		}else if($_POST['action'] == 'edit-profile') {
			if( empty($_POST['email']) || empty($_POST['first-name']) || empty($_POST['last-name']) || 
				empty($_POST['gender']) || empty($_POST['birth-date']) || empty($_POST['address']) ){
				$error[] = __('Please enter all required fields.', 'gdlr-lms');
			}
			
			if( $current_user->user_email != $_POST['email'] && email_exists($_POST['email']) ){
				$error[] = __('Email already exists, Please try again with new email address.', 'gdlr-lms');
			}
			
			if( empty($error) ){
				wp_update_user(array(
					'ID' => $current_user->ID, 
					'user_email' => esc_attr($_POST['email'])
				));
				
				if( !empty($_POST['first-name']) ){
					update_user_meta($current_user->ID, 'first_name', esc_attr($_POST['first-name']));
				}
				if( !empty($_POST['last-name']) ){
					update_user_meta($current_user->ID, 'last_name', esc_attr($_POST['last-name']));
				}
				if( !empty($_POST['gender']) ){
					update_user_meta($current_user->ID, 'gender', esc_attr($_POST['gender']));
				}
				if( !empty($_POST['birth-date']) ){
					update_user_meta($current_user->ID, 'birth-date', esc_attr($_POST['birth-date']));
				}
				if( !empty($_POST['phone']) ){
					update_user_meta($current_user->ID, 'phone', esc_attr($_POST['phone']));
				}
				if( !empty($_POST['address']) ){
					update_user_meta($current_user->ID, 'address', $_POST['address']);
				}
				
				// instructor / admin section
				if( !empty($_POST['social-network']) ){
					update_user_meta($current_user->ID, 'social-network', $_POST['social-network']);
				}
				if( !empty($_POST['author-biography']) ){
					update_user_meta($current_user->ID, 'author-biography', $_POST['author-biography']);
				}
				if( !empty($_POST['location']) ){
					update_user_meta($current_user->ID, 'location', esc_attr($_POST['location']));
				}
				if( !empty($_POST['position']) ){
					update_user_meta($current_user->ID, 'position', esc_attr($_POST['position']));
				}
				if( !empty($_POST['current-work']) ){
					update_user_meta($current_user->ID, 'current-work', esc_attr($_POST['current-work']));
				}
				if( !empty($_POST['past-work']) ){
					update_user_meta($current_user->ID, 'past-work', esc_attr($_POST['past-work']));
				}
				if( !empty($_POST['specialist']) ){
					update_user_meta($current_user->ID, 'specialist', esc_attr($_POST['specialist']));
				}
				if( !empty($_POST['experience']) ){
					update_user_meta($current_user->ID, 'experience', esc_attr($_POST['experience']));
				}
				
				// image uploaded
				if( !empty($_FILES['attachment']['size']) ){
					if(!function_exists( 'media_handle_upload' )){
						require_once( ABSPATH . 'wp-admin/includes/image.php' );
						require_once( ABSPATH . 'wp-admin/includes/file.php' );
						require_once( ABSPATH . 'wp-admin/includes/media.php' );
					}
					$profile_image_id = media_handle_upload('attachment', 0);
					
					if( !empty($profile_image_id) ){
						update_user_meta($current_user->ID, 'author-image', $profile_image_id);
					}
					
					$new_url = add_query_arg('type', 'profile');
					wp_redirect($new_url, 303);
				}
				
				$success[] = __('Profile is updated', 'gdlr-lms');
			}
			
		// evidence submission page
		}else if($_POST['action'] == 'submit-evidence'){
			
			if( empty($_POST['invoice']) ){
				$error[] = __('Submission filed, please try again.', 'gdlr-lms');
			}else{
			
				if(!function_exists( 'wp_handle_upload' )) require_once(ABSPATH . 'wp-admin/includes/file.php');
				
				$uploadedfile = $_FILES['attachment'];
				$movefile = wp_handle_upload($uploadedfile,  array('test_form' => false));
				if($movefile){
					global $wpdb;
					
					$current_row = $wpdb->get_row('SELECT payment_info FROM ' . $wpdb->prefix . 'gdlrpayment WHERE id=' . $_POST['invoice']);
					$payment_info = unserialize($current_row->payment_info);
					$payment_info['additional_note'] = $_POST['additional-note'];
					
					$wpdb->update( $wpdb->prefix . 'gdlrpayment', 
						array('attachment'=>serialize($movefile), 'payment_status'=>'submitted', 
							  'payment_date'=>date('Y-m-d'), 'payment_info'=>serialize($payment_info)), 
						array('id'=>$_POST['invoice']), 
						array('%s', '%s', '%s'), 
						array('%d')
					);
					
					$success[] = __('Evidence Submitted', 'gdlr-lms');
				}else{
					$error[] = __('Submission filed, please try again.', 'gdlr-lms');
				}
			}
			
		// scoring status page
		}else if($_POST['action'] == 'scoring-status-part'){
			$quiz_val = gdlr_lms_decode_preventslashes(get_post_meta($_GET['quiz_id'], 'gdlr-lms-content-settings', true));
			$quiz_options = empty($quiz_val)? array(): json_decode($quiz_val, true);	

			if( !empty($_POST) ){
				$sql  = 'SELECT id, quiz_score FROM ' . $wpdb->prefix . 'gdlrquiz ';
				$sql .= 'WHERE quiz_id=' . $_GET['quiz_id'] . ' AND student_id=' . $_GET['student_id'] . ' AND course_id=' . $_GET['course_id'];
				$current_row = $wpdb->get_row($sql);
				
				$quiz_score = unserialize($current_row->quiz_score);
				$quiz_score = empty($quiz_score)? array(): $quiz_score;
				
				$quiz_score[$_POST['pnum']] = array();
				foreach($_POST['score'] as $key => $value){
					$quiz_score[$_POST['pnum']][$key] = array(
						'score' => $value,
						'from' => $_POST['from'][$key]
					);
				}
				$quiz_status = (sizeof($quiz_score) == sizeof($quiz_options))? 'complete': 'pending';
				
				if( $quiz_status == 'complete' ){
					$course_val = gdlr_lms_decode_preventslashes(get_post_meta($_GET['course_id'], 'gdlr-lms-course-settings', true));
					$course_settings = empty($course_val)? array(): json_decode($course_val, true);		
					
					if(!empty($course_settings['enable-badge']) && $course_settings['enable-badge'] == 'enable'){
						gdlr_lms_add_badge($_GET['course_id'], gdlr_lms_score_summary($quiz_score), $course_settings['badge-percent'],
							$course_settings['badge-title'], $course_settings['badge-file'], $_GET['student_id']);
					}
					
					if(!empty($course_settings['enable-certificate']) && $course_settings['enable-certificate'] == 'enable'){
						gdlr_lms_add_certificate($_GET['course_id'], $course_settings['certificate-template'], 
							gdlr_lms_score_summary($quiz_score), $course_settings['certificate-percent'], $_GET['student_id']);
					}
					
				}
				
				$wpdb->update( $wpdb->prefix . 'gdlrquiz', 
						array('quiz_score'=>serialize($quiz_score), 'quiz_status'=>$quiz_status), 
						array('id'=>$current_row->id), 
						array('%s', '%s'), 
						array('%d')
				);
			}		
		}
	}
?>
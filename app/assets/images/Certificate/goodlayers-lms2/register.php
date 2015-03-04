<?php 
	$error = array();
	if( !empty($_POST['action']) && $_POST['action'] == 'create-new-user' ){
		if( empty($_POST['username']) || empty($_POST['password']) || empty($_POST['re-password']) ||
			empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['gender']) ||
			empty($_POST['birth_date']) || empty($_POST['email']) || empty($_POST['address']) ){
			
			$error[] = __('Please enter all required fields.', 'gdlr-lms');
		}
		
		if( $_POST['password'] != $_POST['re-password'] ){
			$error[] = __('Password and password confirmation do not match.', 'gdlr-lms');
		}
		
		if( username_exists($_POST['username']) ){
			$_POST['username'] = '';
			$error[] = __('Username already exists, please try again with another name.', 'gdlr-lms');
		}
		
		if( email_exists($_POST['email']) ){
			$_POST['email'] = '';
			$error[] = __('Email already exists, Please try again with new email address.', 'gdlr-lms');
		}
		
		if( empty($error) ){
			$user_id = wp_insert_user(array(
				'user_login' => $_POST['username'], 
				'user_pass' => $_POST['password'], 
				'user_email' => $_POST['email'],
				'role' => 'student'
			));
			
			if( !empty($_POST['first_name']) ){
				update_user_meta($user_id, 'first_name', esc_attr($_POST['first_name']));
			}
			if( !empty($_POST['last_name']) ){
				update_user_meta($user_id, 'last_name', esc_attr($_POST['last_name']));
			}
			if( !empty($_POST['gender']) ){
				update_user_meta($user_id, 'gender', esc_attr($_POST['gender']));
			}
			if( !empty($_POST['birth_date']) ){
				update_user_meta($user_id, 'birth-date', esc_attr($_POST['birth_date']));
			}
			if( !empty($_POST['phone']) ){
				update_user_meta($user_id, 'phone', esc_attr($_POST['phone']));
			}
			if( !empty($_POST['address']) ){
				update_user_meta($user_id, 'address', $_POST['address']);
			}	
			
			$redirect_url = empty($_GET['register'])? home_url: $_GET['register'];
			$redirect = add_query_arg('login', $redirect_url, home_url()); 
			wp_redirect($redirect);
			exit;
		}
	}
	get_header(); 
?>
<div class="gdlr-lms-content">
	<div class="gdlr-lms-container gdlr-lms-container">
		<div class="gdlr-lms-item">
			<?php
				if( !empty($error) ){
					echo '<div class="gdlr-lms-error">' . implode("<br />", $error) . '</div>'; 
				}		
			?>
			<form class="gdlr-lms-form" method="post" action="">
				<p class="gdlr-lms-half-left">
					<label><?php _e('Username *', 'gdlr-lms'); ?></label>
					<input type="text" name="username" value="<?php echo isset($_POST['username'])? $_POST['username']: ''; ?>" />
				</p>
				<div class="clear"></div>
				<p class="gdlr-lms-half-left">
					<label><?php _e('Password *', 'gdlr-lms'); ?></label>
					<input type="password" name="password" />
				</p>
				<p class="gdlr-lms-half-right">
					 <label><?php _e('Re Password *', 'gdlr-lms'); ?></label>
					 <input type="password" name="re-password" />
				</p>
				<div class="clear"></div>
				<p class="gdlr-lms-half-left">
					<label><?php _e('First Name *', 'gdlr-lms'); ?></label>
					<input type="text" name="first_name" value="<?php echo isset($_POST['first_name'])? $_POST['first_name']: ''; ?>" />
				</p>
				<p class="gdlr-lms-half-right">
					 <label><?php _e('Last Name *', 'gdlr-lms'); ?></label>
					 <input type="text" name="last_name" value="<?php echo isset($_POST['last_name'])? $_POST['last_name']: ''; ?>" />
				</p>
				<div class="clear"></div>		
				<p class="gdlr-lms-half-left">
					<label><?php _e('Gender *', 'gdlr-lms'); ?></label>
					<span class="gdlr-lms-combobox">
						<select name="gender" id="gender" >
							<option value="m" <?php if(isset($_POST['gender']) && $_POST['gender'] == 'm') echo 'selected'; ?> ><?php _e('Male', 'gdlr-lms'); ?></option>
							<option value="f" <?php if(isset($_POST['gender']) && $_POST['gender'] == 'f') echo 'selected'; ?> ><?php _e('Female', 'gdlr-lms'); ?></option>
						</select>
					</span>					
				</p>
				<p class="gdlr-lms-half-right">
					 <label><?php _e('Birth Date *', 'gdlr-lms'); ?></label>
					 <input type="text" name="birth_date" value="<?php echo isset($_POST['birth_date'])? $_POST['birth_date']: ''; ?>" />
				</p>
				<div class="clear"></div>		
				<p class="gdlr-lms-half-left">
					<label><?php _e('Email *', 'gdlr-lms'); ?></label>
					<input type="text" name="email" id="email" value="<?php echo isset($_POST['email'])? $_POST['email']: ''; ?>" />
				</p>	
				<p class="gdlr-lms-half-right">
					<label><?php _e('Phone', 'gdlr-lms'); ?></label>
					<input type="text" name="phone" id="phone" value="<?php echo isset($_POST['phone'])? $_POST['phone']: ''; ?>" />
				</p>
				<div class="clear"></div>
				<p class="gdlr-lms-half-left">
					<label><?php _e('Address *', 'gdlr-lms'); ?></label>
					<textarea name="address" id="address" ><?php echo isset($_POST['address'])? esc_textarea($_POST['address']): ''; ?></textarea>
				</p>
				<div class="clear"></div>				
				<p>
					<input type="hidden" name="action" value="create-new-user" />
					<input type="submit" class="gdlr-lms-button" value="<?php _e('Create an account', 'gdlr-lms'); ?>" />
				</p>
			</form>
		</div>
	</div>
</div>
<?php get_footer(); ?>
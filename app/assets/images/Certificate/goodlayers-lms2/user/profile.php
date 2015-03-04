<?php 
	$user_info = get_userdata($current_user->data->ID);
	$user_meta = get_user_meta($current_user->data->ID); 
?>
<h3 class="gdlr-lms-admin-head" ><?php _e('Edit Profile', 'gdlr-lms'); ?></h3>
<form class="gdlr-lms-form" method="post" enctype="multipart/form-data" action="<?php echo add_query_arg($_GET); ?>" >
	<?php
		if( $current_user->roles[0] != 'student' ){
			echo '<input class="gdlr-admin-author-image" id="gdlr-admin-author-image" type="file" name="attachment" />';
		}
	?>

	<p class="gdlr-lms-half-left">
		<label for="first-name"><?php _e('First Name *', 'gdlr-lms'); ?></label>
		<input type="text" name="first-name" id="first-name" value="<?php if(!empty($user_meta['first_name'])) echo $user_meta['first_name'][0];  ?>" />
	</p>
	<p class="gdlr-lms-half-right">
		<label for="last-name"><?php _e('Last name *', 'gdlr-lms'); ?></label>
		<input type="text" name="last-name" id="last-name" value="<?php if(!empty($user_meta['last_name'])) echo $user_meta['last_name'][0]; ?>" />
	</p>
	<div class="clear"></div>
	<p class="gdlr-lms-half-left">
		<label for="gender"><?php _e('Gender *', 'gdlr-lms'); ?></label>
		<span class="gdlr-lms-combobox">
			<select name="gender" id="gender" >
				<option value="m" <?php if(!empty($user_meta['gender']) && $user_meta['gender'][0] == 'm') echo 'selected'; ?> ><?php _e('Male', 'gdlr-lms'); ?></option>
				<option value="f" <?php if(!empty($user_meta['gender']) && $user_meta['gender'][0] == 'f') echo 'selected'; ?> ><?php _e('Female', 'gdlr-lms'); ?></option>
			</select>
		</span>
	</p>	
	<p class="gdlr-lms-half-right">
		<label for="birth-date"><?php _e('Birth Date *', 'gdlr-lms'); ?></label>
		<input type="text" name="birth-date" id="birth-date" value="<?php if(!empty($user_meta['birth-date'])) echo $user_meta['birth-date'][0]; ?>" />
	</p>
	<div class="clear"></div>
	<p class="gdlr-lms-half-left">
		<label for="email"><?php _e('Email *', 'gdlr-lms'); ?></label>
		<input type="text" name="email" id="email" value="<?php echo $user_info->data->user_email; ?>" />
	</p>	
	<p class="gdlr-lms-half-right">
		<label for="phone"><?php _e('Phone', 'gdlr-lms'); ?></label>
		<input type="text" name="phone" id="phone" value="<?php if(!empty($user_meta['phone'])) echo $user_meta['phone'][0]; ?>" />
	</p>
	<div class="clear"></div>
	<p class="gdlr-lms-half-left">
		<label for="address"><?php _e('Address *', 'gdlr-lms'); ?></label>
		<textarea name="address" id="address" ><?php if(!empty($user_meta['address'])) echo esc_textarea($user_meta['address'][0]); ?></textarea>
	</p>
	<?php if( $current_user->roles[0] == 'administrator' || $current_user->roles[0] == 'instructor' ){ ?>
		<p class="gdlr-lms-half-right">
			<label for="author-biography"><?php _e('Full Biography', 'gdlr-lms'); ?></label>
			<textarea name="author-biography" id="author-biography" ><?php if(!empty($user_meta['author-biography'])) echo esc_textarea($user_meta['author-biography'][0]); ?></textarea>
		</p>	
	<?php } ?>
	<div class="clear"></div>
	<!-- for teacher/admin user -->
	<?php if( $current_user->roles[0] == 'administrator' || $current_user->roles[0] == 'instructor' ){ ?>
		<p class="gdlr-lms-half-left">
			<label for="location"><?php _e('Location', 'gdlr-lms'); ?></label>
			<input type="text" name="location" id="location" value="<?php if(!empty($user_meta['location'])) echo $user_meta['location'][0]; ?>" />
		</p>	
		<p class="gdlr-lms-half-right">
			<label for="position"><?php _e('Position', 'gdlr-lms'); ?></label>
			<input type="text" name="position" id="position" value="<?php if(!empty($user_meta['position'])) echo $user_meta['position'][0]; ?>" />
		</p>	
		<div class="clear"></div>
		<p class="gdlr-lms-half-left">
			<label for="current-work"><?php _e('Current Work', 'gdlr-lms'); ?></label>
			<input type="text" name="current-work" id="current-work" value="<?php if(!empty($user_meta['current-work'])) echo $user_meta['current-work'][0]; ?>" />
		</p>	
		<p class="gdlr-lms-half-right">
			<label for="past-work"><?php _e('Past Work', 'gdlr-lms'); ?></label>
			<input type="text" name="past-work" id="past-work" value="<?php if(!empty($user_meta['past-work'])) echo $user_meta['past-work'][0]; ?>" />
		</p>	
		<div class="clear"></div>		
		<p class="gdlr-lms-half-left">
			<label for="specialist"><?php _e('Specialist In', 'gdlr-lms'); ?></label>
			<input type="text" name="specialist" id="specialist" value="<?php if(!empty($user_meta['specialist'])) echo $user_meta['specialist'][0]; ?>" />
		</p>	
		<p class="gdlr-lms-half-right">
			<label for="experience"><?php _e('Experience', 'gdlr-lms'); ?></label>
			<input type="text" name="experience" id="experience" value="<?php if(!empty($user_meta['experience'])) echo $user_meta['experience'][0]; ?>" />
		</p>	
		<div class="clear"></div>		
		<p class="gdlr-lms-half-left">
			<label for="social-network"><?php _e('Social Network', 'gdlr-lms'); ?></label>
			<textarea name="social-network" id="social-network" ><?php if(!empty($user_meta['social-network'])) echo esc_textarea($user_meta['social-network'][0]); ?></textarea>
		</p>		
		<div class="clear"></div>		
	<?php } ?>
	<p>
		<input type="hidden" name="action" value="edit-profile" />
		<input type="submit" class="gdlr-lms-button cyan" value="<?php _e('Update', 'gdlr-lms'); ?>" />
	</p>		
</form>	
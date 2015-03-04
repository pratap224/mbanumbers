<h3 class="gdlr-lms-admin-head" ><?php _e('Change Password', 'gdlr-lms'); ?></h3>
<form class="gdlr-lms-form" method="post" action="<?php echo add_query_arg($_GET); ?>">
	<p class="gdlr-lms-half-left">
		<label for="old-pass"><?php _e('Old Password *', 'gdlr-lms'); ?></label>
		<input type="password" name="old-pass" id="old-pass" />
	</p>
	<div class="clear"></div>
	<p class="gdlr-lms-half-left">
		<label for="new-pass"><?php _e('New Password *', 'gdlr-lms'); ?> </label>
		<input type="password" name="new-pass" id="new-pass" />
	</p>
	<p class="gdlr-lms-half-right">
		<label for="repeat-pass"><?php _e('Confirm Password *', 'gdlr-lms'); ?></label>
		<input type="password" name="repeat-pass" id="repeat-pass" />
	</p>
	<div class="clear"></div>
	<p>
		<input type="hidden" name="action" value="change-password" />
		<input type="submit" class="gdlr-lms-button cyan" value="<?php _e('Update', 'gdlr-lms'); ?>" />
	</p>	
</form>	
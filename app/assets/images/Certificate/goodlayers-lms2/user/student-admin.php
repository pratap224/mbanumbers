<div class="gdlr-lms-admin-head">
	<div class="gdlr-lms-admin-head-thumbnail">
		<?php echo get_avatar($current_user->data->ID, 70); ?>
	</div>
	<div class="gdlr-lms-admin-head-content">
		<span class="gdlr-lms-welcome"><?php _e('Welcome', 'gdlr-lms'); ?></span>
		<span class="gdlr-lms-name"><?php echo $current_user->data->display_name; ?></span>
	</div>
	<div class="clear"></div>
</div>
<ul class="gdlr-lms-admin-list">
	<li><a href="<?php echo add_query_arg('type', 'badge-certificate'); ?>" ><?php _e('Profile, Badges and Certifications', 'gdlr-lms'); ?></a></li>
	<li><a href="<?php echo add_query_arg('type', 'profile'); ?>" ><?php _e('Edit Profile', 'gdlr-lms'); ?></a></li>
	<li><a href="<?php echo add_query_arg('type', 'password'); ?>" ><?php _e('Edit Password', 'gdlr-lms'); ?></a></li>
	<li><a href="<?php echo add_query_arg('type', 'quiz-scores'); ?>" ><?php _e('View Quiz Scores', 'gdlr-lms'); ?></a></li>
	<li><a href="<?php echo add_query_arg('type', 'attended-courses'); ?>" ><?php _e('Attended Courses', 'gdlr-lms'); ?></a></li>
	<li><a href="<?php echo add_query_arg('type', 'book-courses'); ?>" ><?php _e('Booked Courses', 'gdlr-lms'); ?></a></li>
	<li><a href="<?php echo add_query_arg('type', 'confirm-courses'); ?>" ><?php _e('Confirmed Courses', 'gdlr-lms'); ?></a></li>
	<li><a href="<?php echo add_query_arg('type', 'free-onsite'); ?>" ><?php _e('Free Onsite Courses', 'gdlr-lms'); ?></a></li>
</ul>
<div class="gdlr-lms-logout">
	<a href="<?php echo wp_logout_url(get_home_url()); ?>"><?php _e('Logout', 'gdlr-lms'); ?></a>
</div>
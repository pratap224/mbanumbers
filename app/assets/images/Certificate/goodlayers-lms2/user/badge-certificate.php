<?php 
	$user_info = get_userdata($current_user->data->ID);
	$user_meta = get_user_meta($current_user->data->ID); 
?>
<div class="gdlr-lms-profile-certificate gdlr-lms-col2" >
<h3 class="gdlr-lms-admin-head" ><?php _e('Certificates', 'gdlr-lms'); ?></h3>
<?php 
	if( !empty($user_meta['gdlr-lms-certificate'][0]) ){
		$certificates = unserialize($user_meta['gdlr-lms-certificate'][0]);
		foreach($certificates as $course_id => $certificate){
			echo '<div class="certificate-list-wrapper">';
			echo '<i class="icon-file-text"></i>';
			echo '<a data-rel="gdlr-lms-lightbox" data-lb-open="certificate-form" class="gdlr-lms-certificate-link" >';
			echo get_the_title($course_id);
			echo '</a>';
			gdlr_lms_certificate_form($course_id, $certificate);
			echo '</div>';
		}
	}
?>
</div>
<div class="gdlr-lms-profile-badge gdlr-lms-col2">
<h3 class="gdlr-lms-admin-head" ><?php _e('Badges', 'gdlr-lms'); ?></h3>
<?php 
	if( !empty($user_meta['gdlr-lms-badge'][0]) ){
		$badges = unserialize($user_meta['gdlr-lms-badge'][0]);
		foreach($badges as $course_id => $badge){
			echo '<div class="gdlr-badge-image">';
			echo '<img src="' . $badge['image'] . '" alt="" />';
			echo '<div class="badge-title">' . $badge['title'] . '</div>';
			echo '</div>';
		}
	}
?>
<div class="clear"></div>
</div>
<div class="clear"></div>
<h3 class="gdlr-lms-admin-head" ><?php _e('Profile', 'gdlr-lms'); ?></h3>
<div class="gdlr-lms-profile-info-wrapper">
	<div class="gdlr-lms-profile-info">
		<span class="gdlr-lms-head"><?php echo __('Name', 'gdlr-lms'); ?></span>
		<span class="gdlr-lms-tail"><?php if(!empty($user_meta['first_name'])) echo $user_meta['first_name'][0]; ?></span>
	</div>
	<div class="gdlr-lms-profile-info">
		<span class="gdlr-lms-head"><?php echo __('Last Name', 'gdlr-lms'); ?></span>
		<span class="gdlr-lms-tail"><?php if(!empty($user_meta['last_name'])) echo $user_meta['last_name'][0]; ?></span>
	</div>
	<div class="gdlr-lms-profile-info">
		<span class="gdlr-lms-head"><?php echo __('Gender', 'gdlr-lms'); ?></span>
		<span class="gdlr-lms-tail"><?php if(!empty($user_meta['gender'])) echo ($user_meta['gender'][0] == 'm')? __('Male', 'gdlr-lms'): __('Female', 'gdlr-lms'); ?></span>
	</div>
	<div class="gdlr-lms-profile-info">
		<span class="gdlr-lms-head"><?php echo __('Birth Date', 'gdlr-lms'); ?></span>
		<span class="gdlr-lms-tail"><?php if(!empty($user_meta['birth-date'])) echo $user_meta['birth-date'][0]; ?></span>
	</div>
	<div class="gdlr-lms-profile-info">
		<span class="gdlr-lms-head"><?php echo __('Email', 'gdlr-lms'); ?></span>
		<span class="gdlr-lms-tail"><?php echo $user_info->data->user_email; ?></span>
	</div>
	<div class="gdlr-lms-profile-info">
		<span class="gdlr-lms-head"><?php echo __('Phone', 'gdlr-lms'); ?></span>
		<span class="gdlr-lms-tail"><?php if(!empty($user_meta['phone'])) echo $user_meta['phone'][0]; ?></span>
	</div>	
</div>
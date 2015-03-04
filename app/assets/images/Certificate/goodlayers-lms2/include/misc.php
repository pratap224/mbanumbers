<?php
	/*	
	*	Goodlayers Misc File
	*/
	
	function gdlr_lms_header_signin(){
		if( is_user_logged_in() ){
			global $current_user;

			echo '<div class="gdlr-lms-header-signin">';
			echo '<a href="' . get_author_posts_url($current_user->ID) . '" >' . $current_user->display_name . '</a>';
			echo '<span class="gdlr-separator">|</span>';
			echo '<a href="' . wp_logout_url(home_url()) . '" >' . __('Logout','gdlr-lms') . '</a>';
			echo '</div>';
		}else{
			echo '<div class="gdlr-lms-header-signin">';
			echo '<i class="icon-lock"></i>';
			echo '<a data-rel="gdlr-lms-lightbox" data-lb-open="login-form" >' . __('Sign In', 'gdlr-lms') . '</a>';
			gdlr_lms_sign_in_lightbox_form();
			echo '<span class="gdlr-separator">|</span>';
			echo '<a href="' . add_query_arg('register', get_permalink(), home_url()) . '">' . __('Sign Up', 'gdlr-lms') . '</a>';
			echo '</div>';		
		}
	}
	
?>
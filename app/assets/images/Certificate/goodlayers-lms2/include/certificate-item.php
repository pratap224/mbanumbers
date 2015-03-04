<?php
	/*	
	*	Goodlayers Certificate File
	*/		
	
	// add badge to user meta
	function gdlr_lms_add_badge($course_id, $score, $percent, $title, $image, $user_id=0){
		if( empty($user_id) ){
			global $current_user;
			$user_id = $current_user->ID;
		}

		$user_badge = get_user_meta($user_id, 'gdlr-lms-badge', true);
		if(empty($user_badge)){
			$user_badge = array();
		}
		if(floatval($score['score']) * 100 / floatval($score['from']) >= floatval($percent)){
			$user_badge[$course_id] = array(
				'title' => $title,
				'image' => $image,
				'date' => date('Y-m-d'),
				'score' => $score['score'],
				'from' => $score['from']
			);	
			
			update_user_meta($user_id, 'gdlr-lms-badge', $user_badge);	
		}
	}
	
	
	// add certificate to user meta
	function gdlr_lms_add_certificate($course_id, $template, $score=-1, $percent=-1, $user_id=0){
		if( empty($user_id) ){
			global $current_user;
			$user_id = $current_user->ID;
		}
		
		$user_certificate = get_user_meta($user_id, 'gdlr-lms-certificate', true);
		if(empty($user_certificate)){
			$user_certificate = array();
		}

		if( $score == -1 || 
			floatval($score['score']) * 100 / floatval($score['from']) >= floatval($percent)){
		
			$user_certificate[$course_id] = array(
				'template'=>$template, 
				'date'=>date('Y-m-d')
			);
			
			if( $score != -1 ){
				$user_certificate[get_the_ID()]['score'] = $score['score'];
				$user_certificate[get_the_ID()]['from'] = $score['from'];
			}
			
			update_user_meta($user_id, 'gdlr-lms-certificate', $user_certificate);	
		}
	}
	
	// certificate lightbox form
	function gdlr_lms_certificate_form($course_id, $settings){
		global $gdlr_lms_cer_settings, $post;
		
		$certificate_val = gdlr_lms_decode_preventslashes(get_post_meta($settings['template'], 'gdlr-lms-certificate-settings', true));
		$certificate_options = empty($certificate_val)? array(): json_decode($certificate_val, true);		

		$gdlr_lms_cer_settings = $settings;
		$gdlr_lms_cer_settings['course_id'] = $course_id;	
?>
<div class="gdlr-lms-lightbox-container certificate-form">
	<?php if(!empty($certificate_options['custom-css'])){ echo '<style type="text/css">' . $certificate_options['custom-css'] . '</style>'; } ?>
	<?php if(empty($certificate_options['enable-printer']) || ($certificate_options['enable-printer'] == 'enable')){ ?>
	<div class="gdlr-lms-lightbox-printer"><i class="icon-print"></i></div>
	<?php } ?>
	<div class="gdlr-lms-lightbox-close"><i class="icon-remove"></i></div>

	<div class="certificate-form-printable gdlr-printable">
	<?php
		$post = get_post($settings['template']);
		setup_postdata($post);
		
		the_content();
		
		wp_reset_postdata();
	?>
	</div>	
</div>
<?php	
	}	
	
	// certificate wrapper
	add_shortcode('gdlr_cer_wrapper', 'gdlr_cer_wrapper_shortcode');
	function gdlr_cer_wrapper_shortcode( $atts, $content = null ){
		extract( shortcode_atts(array('class'=>'', 'background'=>'', 'border'=>'yes'), $atts) );
		
		$ret = '';
		$style = '';
		if( !empty($background) ){
			$style = ' style="background: url(\'' . $background . '\') center center no-repeat;" ';
		}
		
		if( $border == 'yes' ){
			$ret .= '<div class="certificate-form-outer-wrapper">';
			$ret .= '<div class="certificate-form-wrapper">';
		}
		$ret .= '<div class="certificate-wrapper ' . $class . '" ' . $style . ' >' . do_shortcode($content) . '</div>';
		if( $border == 'yes' ){
			$ret .= '</div>';
			$ret .= '</div>';
		}
		return $ret;
	}	
	
	// certificate caption
	add_shortcode('gdlr_cer_caption', 'gdlr_cer_caption_shortcode');
	function gdlr_cer_caption_shortcode( $atts, $content = null ){
		extract( shortcode_atts(array('class'=>'', 'font_size'=>''), $atts) );
		
		$style = '';
		if( !empty($font_size) ){
			$style = ' style="font-size: ' . $font_size . '" ';
		}
		return '<div class="certificate-caption ' . $class . '" ' . $style . ' >' . do_shortcode($content) . '</div>';
	}
	
	// certificate caption
	add_shortcode('gdlr_cer_student_name', 'gdlr_cer_student_name_shortcode');
	function gdlr_cer_student_name_shortcode( $atts, $content = null ){
		extract( shortcode_atts(array('class'=>'', 'font_size'=>''), $atts) );
		
		global $current_user;
		
		$style = '';
		if( !empty($font_size) ){
			$style = ' style="font-size: ' . $font_size . '" ';
		}
		return '<div class="certificate-name ' . $class . '" ' . $style . ' >' . get_user_meta($current_user->ID, 'first_name', true) . ' ' . get_user_meta($current_user->ID, 'last_name', true) . '</div>';
	}	
	
	// certificate caption
	add_shortcode('gdlr_cer_course_name', 'gdlr_cer_course_name_shortcode');
	function gdlr_cer_course_name_shortcode( $atts, $content = null ){
		extract( shortcode_atts(array('class'=>'', 'font_size'=>''), $atts) );
		
		global $gdlr_lms_cer_settings;
		
		$style = '';
		if( !empty($font_size) ){
			$style = ' style="font-size: ' . $font_size . '" ';
		}
		return '<div class="certificate-course ' . $class . '" ' . $style . ' >' . get_the_title($gdlr_lms_cer_settings['course_id']) . '</div>';
	}
	
	// certificate caption
	add_shortcode('gdlr_cer_mark', 'gdlr_cer_mark_shortcode');
	function gdlr_cer_mark_shortcode( $atts, $content = null ){
		extract( shortcode_atts(array('class'=>'', 'font_size'=>''), $atts) );
		global $gdlr_lms_cer_settings;
		
		$style = '';
		if( !empty($font_size) ){
			$style = ' style="font-size: ' . $font_size . '" ';
		}
		
		$score = '';
		if(!empty($gdlr_lms_cer_settings['score']) && !empty($gdlr_lms_cer_settings['from'])){
			$score = $gdlr_lms_cer_settings['score'] . '/' . $gdlr_lms_cer_settings['from'];
		}
		return '<div class="certificate-mark ' . $class . '" ' . $style . ' >' . $content . ' ' . $score . '</div>';
	}	
	
	// certificate date
	add_shortcode('gdlr_cer_date', 'gdlr_cer_date_shortcode');
	function gdlr_cer_date_shortcode( $atts, $content = null ){
		extract( shortcode_atts(array('class'=>'', 'font_size'=>'', 'format'=>'j/n/Y'), $atts) );
		
		global $gdlr_lms_cer_settings;
		
		$style = '';
		if( !empty($font_size) ){
			$style = ' style="font-size: ' . $font_size . '" ';
		}
		
		$date_time = strtotime($gdlr_lms_cer_settings['date']);
		
		$ret  = '<div class="certificate-date-wrapper ' . $class . '" ' . $style . ' >';
		$ret .= '<div class="certificate-date">' . date_i18n($format, $date_time) . '</div>';
		$ret .= '<div class="certificate-date-text">' . __('Date', 'gdlr-lms') . '</div>';
		$ret .= '</div>';
		return $ret;
	}
	
	// certificate signature
	add_shortcode('gdlr_cer_signature', 'gdlr_cer_signature_shortcode');
	function gdlr_cer_signature_shortcode( $atts, $content = null ){
		extract( shortcode_atts(array('class'=>'', 'font_size'=>'', 'image'=>''), $atts) );
		
		global $gdlr_lms_cer_settings;
		
		$style = '';
		if( !empty($font_size) ){
			$style = ' style="font-size: ' . $font_size . '" ';
		}
		
		$date_time = strtotime($gdlr_lms_cer_settings['date']);
		
		$ret  = '<div class="certificate-signature-wrapper ' . $class . '" ' . $style . ' >';
		$ret .= '<div class="certificate-signature"><img src="' . $image . '" alt="" /></div>';
		$ret .= '<div class="certificate-signature-text">' . $content . '</div>';
		$ret .= '</div>';
		return $ret;
	}	
	
	

?>
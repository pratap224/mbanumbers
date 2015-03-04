<?php

	// social shortcode
	add_shortcode('gdlr_lms_social', 'gdlr_lms_social_shortcode');
	function gdlr_lms_social_shortcode( $atts ){
		extract( shortcode_atts(array('type' => 'facebook', 'url' => ''), $atts) );	

		$icon_url = plugins_url('social-icon-color/' . $type . '.png', dirname(__FILE__));
		return '<a class="lms-social-shortcode" target="_blank" href="' . $url . '"><img src="' . $icon_url . '" alt="' . $type . '"/></a>';
	}	

?>
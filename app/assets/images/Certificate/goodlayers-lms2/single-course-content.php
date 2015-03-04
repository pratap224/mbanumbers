<?php get_header(); ?>
<div class="gdlr-lms-content">
	<div class="gdlr-lms-container gdlr-lms-container">
	<?php 
		while( have_posts() ){ the_post();
			global $gdlr_time_left;
			$lms_page = (empty($_GET['course_page']))? 1: intval($_GET['course_page']);
			
			$course_val = gdlr_lms_decode_preventslashes(get_post_meta(get_the_ID(), 'gdlr-lms-course-settings', true));
			$course_settings = empty($course_val)? array(): json_decode($course_val, true);
			
			$course_val = gdlr_lms_decode_preventslashes(get_post_meta(get_the_ID(), 'gdlr-lms-content-settings', true));
			$course_options = empty($course_val)? array(): json_decode($course_val, true);		
			
			// assign certificate
			if( ($lms_page == sizeof($course_options)) && $course_settings['quiz'] == 'none' &&
				(!empty($course_settings['enable-certificate']) && $course_settings['enable-certificate'] == 'enable')){
				
				gdlr_lms_add_certificate(get_the_ID(), $course_settings['certificate-template']);
			}
			
			echo '<div class="gdlr-lms-course-single gdlr-lms-content-type">';
			echo '<div class="gdlr-lms-course-info-wrapper">';
			echo '<div class="gdlr-lms-course-info-title">' . __('Course Process', 'gdlr-lms') . '</div>';
			echo '<div class="gdlr-lms-course-info">';
			for( $i=1; $i<=sizeof($course_options); $i++ ){
				$part_class  = ($i == sizeof($course_options))? 'gdlr-last ': '';
				if($i < $lms_page){ $part_class .= 'gdlr-pass '; }
				else if($i == $lms_page){ $part_class .= 'gdlr-current '; }
				else{ $part_class .= 'gdlr-next '; }
				
				echo '<div class="gdlr-lms-course-part ' . $part_class . '">';
				echo '<div class="gdlr-lms-course-part-icon">';
				echo '<div class="gdlr-lms-course-part-bullet"></div>';
				echo '<div class="gdlr-lms-course-part-line"></div>';
				echo '</div>'; // part-icon
				
				echo '<div class="gdlr-lms-course-part-content">';
				echo '<span class="part">' . __('Part', 'gdlr-lms') . ' ' . $i . '</span>';
				echo '<span class="title">' . $course_options[$i-1]['section-name'] . '</span>';
				echo '</div>'; // part-content
				echo '</div>'; // course-part
			}
			echo '</div>'; // course-info
			gdlr_lms_print_course_button($course_settings, array('quiz'));
			
			echo '<div class="gdlr-lms-course-pdf">';
			for( $i=1; $i<=$lms_page; $i++ ){
				if( !empty($course_options[$i-1]['pdf-download-link']) ){
					echo '<div class="gdlr-lms-part-pdf">';
					echo '<a class="gdlr-lms-pdf-download" target="_blank" href="' . $course_options[$i-1]['pdf-download-link'] . '">';
					echo '<i class="icon-file-text"></i>';
					echo '</a>';
					
					echo '<div class="gdlr-lms-part-pdf-info">';
					echo '<div class="gdlr-lms-part-title">' . __('Part', 'gdlr-lms') . ' ' . $i . '</div>';
					echo '<div class="gdlr-lms-part-caption">' . $course_options[$i-1]['section-name'] . '</div>';
					echo '</div>';
					echo '</div>';
				}
			}
			echo '</div>'; // course-pdf			
			echo '</div>'; // course-info-wrapper
			
			echo '<div class="gdlr-lms-course-content">';
			if( empty($gdlr_time_left) ){
				echo gdlr_lms_content_filter($course_options[$lms_page-1]['course-content']);
			}else{
				$day_left = intval($gdlr_time_left / 86400);
				$gdlr_time_left = $gdlr_time_left % 86400;
				$gdlr_day_left  = empty($day_left)? '': $day_left . ' ' . __('days') . ' '; 
				
				$hours_left = intval($gdlr_time_left / 3600);
				$gdlr_time_left = $gdlr_time_left % 3600;
				$gdlr_day_left .= empty($hours_left)? '': $hours_left . ' ' . __('hours') . ' '; 
				
				$minute_left = intval($gdlr_time_left / 60);
				$gdlr_time_left = $gdlr_time_left % 60;
				$gdlr_day_left .= empty($minute_left)? '': $minute_left . ' ' . __('minutes') . ' '; 				
				$gdlr_day_left .= empty($gdlr_time_left)? '': $gdlr_time_left . ' ' . __('seconds') . ' '; 	
				
				echo '<div class="gdlr-lms-course-content-time-left">';
				echo '<i class="icon-time" ></i>';
				echo sprintf(__('There\'re %s left before you can access to next part.'), $gdlr_day_left);
				echo '</div>';
			}
			
			echo '<div class="gdlr-lms-course-pagination">';
			if( $lms_page > 1 ){
				echo '<a href="' . add_query_arg(array('course_type'=>'content', 'course_page'=> $lms_page-1)) . '" class="gdlr-lms-button blue">';
				echo __('Previous Part', 'gdlr-lms');
				echo '</a>';
			}
			if( $lms_page < sizeof($course_options) && empty($gdlr_time_left) ){
				echo '<a href="' . add_query_arg(array('course_type'=>'content', 'course_page'=> $lms_page+1)) . '" class="gdlr-lms-button blue">';
				echo __('Next Part', 'gdlr-lms');
				echo '</a>';
			}
			echo '</div>'; // pagination
			echo '</div>'; // course-content
			
			echo '<div class="clear"></div>';
			echo '</div>'; // course-single		
		}
	?>
	</div><!-- gdlr-lms-container -->
</div><!-- gdlr-lms-content -->
<?php get_footer(); ?>
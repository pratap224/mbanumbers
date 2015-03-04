<?php get_header(); ?>
<div class="gdlr-lms-content">
	<div class="gdlr-lms-container gdlr-lms-container">
		<div class="gdlr-lms-item" >
		<?php
			if( $gdlr_lms_option['archive-course-style'] == 'grid' ){
				gdlr_lms_print_course_grid($wp_query, 
					$gdlr_lms_option['archive-course-thumbnail-size'], 
					$gdlr_lms_option['archive-course-size']);
			}else if( $gdlr_lms_option['archive-course-style'] == 'grid-2' ){
				gdlr_lms_print_course_grid2($wp_query, 
					$gdlr_lms_option['archive-course-thumbnail-size'], 
					$gdlr_lms_option['archive-course-size']);
			}else if( $gdlr_lms_option['archive-course-style'] == 'medium' ){
				gdlr_lms_print_course_medium($wp_query, $gdlr_lms_option['archive-course-thumbnail-size']);
			}else if( $gdlr_lms_option['archive-course-style'] == 'full' ){
				gdlr_lms_print_course_full($wp_query, $gdlr_lms_option['archive-course-thumbnail-size']);
			}
			
			$paged = (get_query_var('paged'))? get_query_var('paged') : 1;
			echo gdlr_lms_get_pagination($wp_query->max_num_pages, $paged);	
		?>
		</div>
	</div><!-- gdlr-lms-container -->
</div><!-- gdlr-lms-content -->
<?php get_footer(); ?>
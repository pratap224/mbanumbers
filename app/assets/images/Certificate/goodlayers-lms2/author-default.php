<?php get_header(); ?>
<div class="gdlr-lms-content">
	<div class="gdlr-lms-container gdlr-lms-container">
		<div class="gdlr-lms-item">
			<?php	
				$author_id = get_query_var('author');
				$author_data = get_userdata($author_id);
				$author_meta = get_user_meta($author_id);
			
				// author info 
				echo '<div class="gdlr-lms-author-info-wrapper" >';
				echo '<div class="gdlr-lms-author-thumbnail">';
				echo gdlr_lms_get_author_image($author_id, $gdlr_lms_option['instructor-thumbnail-size']);
				echo '</div>'; // author-thumbnail
				
				echo '<div class="gdlr-lms-author-title-wrapper">';
				echo '<div class="gdlr-lms-author-name">' . $author_meta['first_name'][0] . ' ' . $author_meta['last_name'][0] . '</div>';
				if( !empty($author_meta['position'][0]) ){
					echo '<div class="gdlr-lms-author-position">' . $author_meta['position'][0] . '</div>';
				}
				echo '</div>'; // author-title-wrapper
				
				echo '<div class="gdlr-lms-author-info">';
				if( !empty($author_meta['phone']) ){
					echo '<div class="author-info phone"><i class="icon-phone"></i>' . $author_meta['phone'][0] . '</div>';
				}
				echo '<div class="author-info mail"><i class="icon-envelope-alt"></i><a href="mailto:' . $author_data->user_email . '" >' . $author_data->user_email . '</a></div>';
				if( !empty($author_data->user_url) ){
					echo '<div class="author-info url"><i class="icon-link"></i><a href="' . $author_data->user_url . '" target="_blank" >' . $author_data->user_url . '</a></div>';
				}
				echo '</div>'; // author-info
				
				if( !empty($author_meta['social-network'][0]) ){
					echo '<div class="gdlr-lms-author-social">' . do_shortcode($author_meta['social-network'][0]) . '</div>';
				}
				
				echo '<a class="gdlr-lms-button cyan" href="' . add_query_arg('post_type','course'); 
				echo '" >' . __('View courses by','gdlr-lms') . ' ' . $author_meta['first_name'][0] . '</a>';
				echo '</div>'; // author-info-wrapper
				
				// extra info
				echo '<div class="gdlr-lms-author-content-wrapper">';
				echo '<div class="gdlr-lms-author-extra-info-wrapper">';
				$extra_infos = array(
					'location'=> __('Location', 'gdlr-lms'), 
					'current-work'=> __('Current Work', 'gdlr-lms'), 
					'past-work'=> __('Past Work', 'gdlr-lms'), 
					'specialist'=> __('Specialist In', 'gdlr-lms'), 
					'experience'=> __('Experience', 'gdlr-lms')
				);
				
				foreach( $extra_infos as $key => $value ){
					if( !empty($author_meta[$key][0]) ){
						echo '<div class="gdlr-lms-extra-info ' . $key . '" >';
						echo '<span class="gdlr-head">' . $value . '</span>';
						echo '<span class="gdlr-tail">' . $author_meta[$key][0] . '</span>';
						echo '</div>';
					}
				}
				echo '</div>'; // author-extra-info
				
				echo '<div class="gdlr-lms-author-content-wrapper">';
				echo '<h3 class="gdlr-lms-author-content-title">' . __('Biography', 'gdlr-lms') . '</h3>';
				if( !empty($author_meta['author-biography'][0]) ){
					echo do_shortcode($author_meta['author-biography'][0]);
				}else{
					echo do_shortcode($author_meta['description'][0]);
				}
				echo '</div>'; // author-content
				echo '</div>'; // author-content-wrapper
			?>
			<div class="clear"></div>
		</div><!-- gdlr-lms-item -->
	</div><!-- gdlr-lms-container -->
</div><!-- gdlr-lms-content -->
<?php get_footer(); ?>
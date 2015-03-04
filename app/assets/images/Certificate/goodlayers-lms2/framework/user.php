<?php
	/*	
	*	Goodlayers User File
	*/	

	// create new role upon plugin activation
	function gdlr_lms_add_user_role(){
		add_role('instructor', __('Instructor', 'gdlr-lms'), 
			array('instructor'=>true, 'read'=>true, 'edit_users'=>true, 'edit_dashboard'=>true, 'upload_files'=>true,
				  'edit_course'=>true, 'edit_courses'=>true, 'edit_published_courses'=>true, 'publish_courses'=>true, 'delete_course'=>true, 'delete_courses'=>true, 'delete_published_courses'=>true,
				  'edit_quiz'=>true, 'edit_quizzes'=>true, 'edit_published_quizzes'=>true,'publish_quizzes'=>true, 'delete_quiz'=>true, 'delete_quizzes'=>true, 'delete_published_quizzes'=>true,
				  'course_taxes'=>true )
		);
		add_role('student', __('Student', 'gdlr-lms'));
		
		$administrator = get_role('administrator');
		
		$administrator->add_cap('course_taxes');
		$administrator->add_cap('course_taxes_edit');
		$administrator->add_cap('edit_course');
		$administrator->add_cap('read_course');
		$administrator->add_cap('delete_course');
		$administrator->add_cap('edit_courses');
		$administrator->add_cap('edit_others_courses');
		$administrator->add_cap('publish_courses');
		$administrator->add_cap('read_private_courses');
        $administrator->add_cap('delete_courses');
        $administrator->add_cap('delete_private_courses');
        $administrator->add_cap('delete_published_courses');
        $administrator->add_cap('delete_others_courses');
        $administrator->add_cap('edit_private_courses');
        $administrator->add_cap('edit_published_courses');	

		$administrator->add_cap('edit_quiz');
		$administrator->add_cap('read_quiz');
		$administrator->add_cap('delete_quiz');
		$administrator->add_cap('edit_quizzes');
		$administrator->add_cap('edit_others_quizzes');
		$administrator->add_cap('publish_quizzes');
		$administrator->add_cap('read_private_quizzes');
        $administrator->add_cap('delete_quizzes');
        $administrator->add_cap('delete_private_quizzes');
        $administrator->add_cap('delete_published_quizzes');
        $administrator->add_cap('delete_others_quizzes');
        $administrator->add_cap('edit_private_quizzes');
        $administrator->add_cap('edit_published_quizzes');		
		
		// 1.01 capability fix
		$instructor = get_role('instructor');
		$instructor->add_cap('edit_published_courses');
		$instructor->add_cap('edit_published_quizzes');
	}
	
	// hide admin bar for student
	add_filter('show_admin_bar', 'gdlr_lms_hide_admin_bar', 99, 1);
	function gdlr_lms_hide_admin_bar( $return ){ 
		global $current_user; 
		if( !empty($current_user) && !empty($current_user->roles) ){
			if( $current_user->roles[0] == 'student' ){ 
				return false; 
			}else if( $current_user->roles[0] == 'instructor' ){ 
				return true; 
			}else if ( get_option('woocommerce_lock_down_admin')=='yes' && ! ( current_user_can('edit_posts') || current_user_can('manage_woocommerce') ) ) {
				return false;
			}
		}
		
		return $return;
	}
	
	// add custom user fields
	add_action( 'show_user_profile', 'gdlr_lms_add_user_fields' );
	add_action( 'edit_user_profile', 'gdlr_lms_add_user_fields' );
	function gdlr_lms_add_user_fields($user){ ?>
<h3><?php _e('Extra information', 'gdlr-lms'); ?></h3>

<table class="form-table">
	<script type="text/javascript">
		(function($){
			$(document).ready(function(){
				$('.gdlr-lms-upload-image').click(function(){
					var upload_button = $(this);

					var custom_uploader = wp.media({
						title: upload_button.attr('data-title'),
						button: { text: upload_button.attr('data-title') },
						multiple: false
					}).on('select', function() {
						var attachment = custom_uploader.state().get('selection').first().toJSON();

						upload_button.siblings('img').attr('src', attachment.url);
						upload_button.siblings('.gdlr-lms-display').val(attachment.url);
						upload_button.siblings('.gdlr-lms-image').val(attachment.id);
					}).open();			
				});
			});
		})(jQuery);
	</script>
	<tr>
		<th><label for="author-image"><?php _e('Author Image', 'gdlr-lms'); ?></label></th>
		<td>
			<?php 
				$image_id = get_the_author_meta('author-image', $user->ID);
				$image_url = wp_get_attachment_image_src($image_id);
			?>
			<img src="<?php echo $image_url[0]; ?>" alt="" style="max-width: 150px;" /><br />
			<input type="text" class="gdlr-lms-display regular-text" value="<?php echo $image_url[0]; ?>" />
			<input type="hidden" class="gdlr-lms-image" name="author-image" id="author-image" value="<?php echo $image_id; ?>" />
			<input type="button" class="gdlr-lms-upload-image" value="<?php _e('Upload', 'gdlr-lms'); ?>" data-title="<?php _e('Upload', 'gdlr-lms'); ?>" />
		</td>
	</tr>
	<tr>
		<th><label for="author-biography"><?php _e('Author Biography ( in single instructor page )', 'gdlr-lms'); ?></label></th>
		<td>
			<textarea type="text" name="author-biography" id="author-biography" rows="5" cols="30" ><?php echo esc_textarea(get_the_author_meta('author-biography', $user->ID)); ?></textarea>
		</td>
	</tr>		
	<tr>
		<th><label for="gender"><?php _e('Gender', 'gdlr-lms'); ?></label></th>
		<td><?php $value = get_the_author_meta('gender', $user->ID); ?>
			<select name="gender" id="gender">
			<option value="m" <?php echo ($value == 'm')? 'selected': ''; ?> ><?php _e('Male', 'gdlr-lms') ?></option>
			<option value="f" <?php echo ($value == 'f')? 'selected': ''; ?> ><?php _e('Female', 'gdlr-lms') ?></option>
			</select>
		</td>
	</tr>
	<tr>
		<th><label for="birth-date"><?php _e('Birth Date', 'gdlr-lms'); ?></label></th>
		<td>
			<input type="text" name="birth-date" id="birth-date" value="<?php echo get_the_author_meta('birth-date', $user->ID); ?>" class="regular-text" /><br />
			<span class="description">YYYY/MM/DD</span>
		</td>
	</tr>
	<tr>
		<th><label for="phone"><?php _e('Phone', 'gdlr-lms'); ?></label></th>
		<td>
			<input type="text" name="phone" id="phone" value="<?php echo get_the_author_meta('phone', $user->ID); ?>" class="regular-text" /><br />
		</td>
	</tr>
	<tr>
		<th><label for="address"><?php _e('Address', 'gdlr-lms'); ?></label></th>
		<td>
			<textarea type="text" name="address" id="address" rows="5" cols="30" ><?php echo esc_textarea(get_the_author_meta('address', $user->ID)); ?></textarea>
		</td>
	</tr>	
	<tr>
		<th><label for="location"><?php _e('Location', 'gdlr-lms'); ?></label></th>
		<td>
			<input type="text" name="location" id="location" value="<?php echo get_the_author_meta('location', $user->ID); ?>" class="regular-text" /><br />
		</td>
	</tr>	
	<tr>
		<th><label for="position"><?php _e('Position', 'gdlr-lms'); ?></label></th>
		<td>
			<input type="text" name="position" id="position" value="<?php echo get_the_author_meta('position', $user->ID); ?>" class="regular-text" /><br />
		</td>
	</tr>		
	<tr>
		<th><label for="current-work"><?php _e('Current Work', 'gdlr-lms'); ?></label></th>
		<td>
			<input type="text" name="current-work" id="current-work" value="<?php echo get_the_author_meta('current-work', $user->ID); ?>" class="regular-text" /><br />
		</td>
	</tr>	
	<tr>
		<th><label for="past-work"><?php _e('Past Work', 'gdlr-lms'); ?></label></th>
		<td>
			<input type="text" name="past-work" id="past-work" value="<?php echo get_the_author_meta('past-work', $user->ID); ?>" class="regular-text" /><br />
		</td>
	</tr>	
	<tr>
		<th><label for="specialist"><?php _e('Specialist in', 'gdlr-lms'); ?></label></th>
		<td>
			<input type="text" name="specialist" id="specialist" value="<?php echo get_the_author_meta('specialist', $user->ID); ?>" class="regular-text" /><br />
		</td>
	</tr>	
	<tr>
		<th><label for="experience"><?php _e('Experience', 'gdlr-lms'); ?></label></th>
		<td>
			<input type="text" name="experience" id="experience" value="<?php echo get_the_author_meta('experience', $user->ID); ?>" class="regular-text" /><br />
		</td>
	</tr>		
	<tr>
		<th><label for="social-network"><?php _e('Social Network', 'gdlr-lms'); ?></label></th>
		<td>
			<textarea type="text" name="social-network" id="social-network" rows="5" cols="30" ><?php echo esc_textarea(get_the_author_meta('social-network', $user->ID)); ?></textarea>
		</td>
	</tr>		
</table>	
	<?php } 
	add_action( 'personal_options_update', 'gdlr_lms_save_user_fields' );
	add_action( 'edit_user_profile_update', 'gdlr_lms_save_user_fields' );
	function gdlr_lms_save_user_fields( $user_id ) {
		if ( !current_user_can('edit_user', $user_id) ) return false;

		update_user_meta($user_id, 'author-image', esc_attr($_POST['author-image']));
		update_user_meta($user_id, 'author-biography', $_POST['author-biography']);
		update_user_meta($user_id, 'gender', esc_attr($_POST['gender']));
		update_user_meta($user_id, 'birth-date', esc_attr($_POST['birth-date']));
		update_user_meta($user_id, 'phone', esc_attr($_POST['phone']));
		update_user_meta($user_id, 'address', $_POST['address']);
		update_user_meta($user_id, 'location', esc_attr($_POST['location']));
		update_user_meta($user_id, 'position', esc_attr($_POST['position'])); 
		update_user_meta($user_id, 'current-work', esc_attr($_POST['current-work']));
		update_user_meta($user_id, 'past-work', esc_attr($_POST['past-work']));
		update_user_meta($user_id, 'specialist', esc_attr($_POST['specialist']));
		update_user_meta($user_id, 'experience', esc_attr($_POST['experience']));
		update_user_meta($user_id, 'social-network', $_POST['social-network']);		
	}

	// redirect the template to plugins if user is logging in
	add_action('init', 'gdlr_lms_author_redirect');
	function gdlr_lms_author_redirect(){
		add_filter('author_template', 'gdlr_lms_register_author_template');
		add_filter('search_template', 'gdlr_lms_register_course_archive_template');
		add_filter('archive_template', 'gdlr_lms_register_course_archive_template');
		add_action('pre_get_posts','gdlr_lms_course_search_query');
	}
	function gdlr_lms_register_author_template($template){
		global $wp_query;
		
		if(empty($_GET['post_type'])){
			$author = $wp_query->get_queried_object();
			if( is_user_logged_in() && (get_current_user_id() == $author->data->ID) ){ 
				$template = dirname(dirname( __FILE__ )) . '/author.php';
			}else{
				$template = dirname(dirname( __FILE__ )) . '/author-default.php';
			}
		}

		return $template;	
	}	
	function gdlr_lms_register_course_archive_template($template){
		if( !empty($_GET['post_type']) && ($_GET['post_type'] == 'course' || is_tax('course_category') || is_tax('course_tax')) ){
			
			$template = dirname(dirname( __FILE__ )) . '/course-archive.php';
		}
		return $template;
	}
	function gdlr_lms_course_search_query($query){
		if( is_search() && !empty($_GET['course_type']) ){
			$online_course = ($_GET['course_type'] == 'online')? 'enable': 'disable';
			
			$meta_query = array(array(
				'key'   => 'gdlr-lms-course-settings',
				'value' => '"online-course":"' . $online_course . '"',
				'compare' => 'LIKE'
			));
			$query->set('meta_query', $meta_query);
		}
	}
	
	// add instructor to user list
	add_filter('wp_dropdown_users', 'gdlr_lms_add_instructor_to_user_list');
	function gdlr_lms_add_instructor_to_user_list($html){
		if( get_post_type() == 'course' || get_post_type() == 'quiz' ){
			global $post;

			$user_list = '';
			$instructors = get_users(array('role'=>'instructor'));
			foreach( $instructors as $instructor ){
				if( $post->post_author == $instructor->ID ) continue;
			
				$display = !empty($instructor->display_name) ? $instructor->display_name : '('. $instructor->user_login . ')';
				$user_list .= "\t<option value='" . $instructor->ID . "'>" . esc_html( $display ) . "</option>\n";
			}

			$n = strrpos($html, '</select>');
			return substr($html, 0, $n) . $user_list . substr($html, $n);
		}
		
		return $html;
	}
	
	// delete user action
	add_action( 'delete_user', 'gdlr_lms_remove_user_from_database' );
	function gdlr_lms_remove_user_from_database( $user_id ){
		global $wpdb;
		
		$wpdb->delete( $wpdb->prefix . 'gdlrpayment', array('student_id'=> $user_id), array('%d') );
		$wpdb->delete( $wpdb->prefix . 'gdlrquiz', array('student_id'=> $user_id), array('%d') );	
	}
	
	//add_action ('init' , 'prevent_profile_access');
	//function prevent_profile_access(){
	//if (current_user_can('manage_options')) return '';
	//if (strpos ($_SERVER ['REQUEST_URI'] , 'wp-admin/profile.php' )){
	//wp_redirect ("http://sampledomain.com/specific_page/");
	//}
	//}
?>
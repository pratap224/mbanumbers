<?php
/**
 * Plugin Name: Goodlayers Course Category
 * Plugin URI: http://goodlayers.com/
 * Description: A widget that list all course categories
 * Version: 1.0
 * Author: Goodlayers
 * Author URI: http://www.goodlayers.com
 *
 */

add_action( 'widgets_init', 'gdlr_course_category_widget' );
if( !function_exists('gdlr_course_category_widget') ){
	function gdlr_course_category_widget() {
		register_widget( 'Goodlayers_Course_Category' );
	}
}

if( !class_exists('Goodlayers_Course_Category') ){
	class Goodlayers_Course_Category extends WP_Widget{

		// Initialize the widget
		function __construct() {
			parent::WP_Widget(
				'gdlr-course-category-widget', 
				__('Goodlayers Course Category Widget','gdlr_translate'), 
				array('description' => __('A widget that list course categories', 'gdlr_translate')));  
		}

		// Output of the widget
		function widget( $args, $instance ) {
			global $theme_option;	
				
			$title = apply_filters( 'widget_title', $instance['title'] );
			
			// Opening of widget
			echo $args['before_widget'];
			
			// Open of title tag
			if( !empty($title) ){ 
				echo $args['before_title'] . $title . $args['after_title']; 
			}
				
			// Widget Content
			$category_list = gdlr_get_term_list('course_category'); 
			
			echo '<div class="gdlr-course-category-widget widget_categories">';
			echo '<ul>';			
			foreach($category_list as $cat_slug => $cat_name){
				if($cat_slug == '') continue;

				echo '<li><a href="' . get_term_link($cat_slug, 'course_category') .  '" >';
				echo $cat_name;
				echo '</a></li>';
			}
			echo '</ul>';
			echo '</div>';
				
			// Closing of widget
			echo $args['after_widget'];	
		}

		// Widget Form
		function form( $instance ) {
			$title = isset($instance['title'])? $instance['title']: '';
			
			?>

			<!-- Text Input -->
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title :', 'gdlr_translate'); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>		

		<?php
		}
		
		// Update the widget
		function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = (empty($new_instance['title']))? '': strip_tags($new_instance['title']);

			return $instance;
		}	
	}
}
?>
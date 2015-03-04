<?php
	/*	
	*	Goodlayers Admin Panel
	*	---------------------------------------------------------------------
	*	This file create the class that help you create the controls admin  
	*	option for custom theme
	*	---------------------------------------------------------------------
	*/	
	
	class gdlr_lms_admin_option{
		
		public $setting;
		public $option;		
		public $value;
		
		function __construct($option = array(), $value = array()){
			$this->setting = array('save_option' => 'gdlr_lms_admin_option');
			$this->option = $option;
			$this->value = $value;
		}
		
		function set_option($option = array(), $value = array()){
			$this->option = $option;
			$this->value = $value;
		}		
			
		// saving admin option
		function gdlr_lms_save_admin_panel(){
			if( !check_ajax_referer('gdlr-lms-create-nonce', 'security', false) ){
				die(json_encode(array(
					'status'=>'failed', 
					'message'=> '<span class="head">' . __('Invalid Nonce', 'gdlr-lms') . '</span> ' .
						__('Please refresh the page and try this again.' ,'gdlr-lms')
				)));
			}
			
			if( isset($_POST['option']) ){		
				parse_str(gdlr_stripslashes($_POST['option']), $option ); 
				$option = gdlr_stripslashes($option);
				
				$old_option = get_option($this->setting['save_option']);
				  
				if($old_option == $option || update_option($this->setting['save_option'], $option)){
					$ret = array(
						'status'=> 'success', 
						'message'=> '<span class="head">' . __('Save Options Complete' ,'gdlr-lms') . '</span> '
					);		
				}else{
					$ret = array(
						'status'=> 'failed', 
						'message'=> '<span class="head">' . __('Save Options Failed', 'gdlr-lms') . '</span> ' .
						__('Please refresh the page and try this again.' ,'gdlr-lms')
					);					
				}
			}else{
				$ret = array(
					'status'=>'failed', 
					'message'=> '<span class="head">' . __('Cannot Retrieve Options', 'gdlr-lms') . '</span> ' .
						__('Please refresh the page and try this again.' ,'gdlr-lms')
				);	
			}

			do_action('gdlr_save_lms_admin_option', $this->option);
			die(json_encode($ret));
		}
		
		// creating the content of the admin option
		function create_admin_option(){
			echo '<div class="gdlr-admin-panel-wrapper">';

			echo '<form action="#" method="POST" id="gdlr-admin-form" data-action="gdlr_lms_save_admin_panel" ';
			echo 'data-ajax="' . admin_url('admin-ajax.php') . '" ';
			echo 'data-security="' . wp_create_nonce('gdlr-lms-create-nonce') . '" >';
			
			// print navigation section
			$this->print_admin_nav();
			
			// print content section
			$this->print_admin_content();
			
			echo '<div class="clear"></div>';
			echo '</form>';	

			echo '</div>'; // gdlr-admin-panel-wrapper
		}	

		function print_admin_nav(){
			
			// admin navigation
			echo '<div class="gdlr-admin-nav-wrapper" id="gdlr-admin-nav" >';
			echo '<div class="gdlr-admin-head">';
			echo '<img src="' . plugins_url('images/admin-panel/admin-logo.png', __FILE__) . '" alt="admin logo" />';
			echo '<div class="gdlr-admin-head-gimmick"></div>';
			echo '</div>';
			
			$is_first = 'active';
			
			echo '<ul class="admin-menu" >';
			foreach( $this->option as $menu_slug => $menu_settings ){
				echo '<li class="' . $menu_slug . '-wrapper admin-menu-list">';
				
				echo '<div class="menu-title">';
				echo '<img src="' . $menu_settings['icon'] . '" alt="' . $menu_settings['title'] . '" />';
				echo '<span>' . $menu_settings['title'] . '</span>';
				echo '<div class="menu-title-gimmick"></div>';
				echo '</div>';
				
				echo '<ul class="admin-sub-menu">';
				foreach( $menu_settings['options'] as $sub_menu_slug => $sub_menu_settings ){
					if( !empty($sub_menu_settings) ){
						echo '<li class="' . $sub_menu_slug . '-wrapper ' . $is_first . ' admin-sub-menu-list" data-id="' . $sub_menu_slug . '" >';
						echo '<div class="sub-menu-title">';
						echo $sub_menu_settings['title'];
						echo '</div>';
						echo '</li>';
						
						$is_first = '';
					}
				}
				echo '</ul>';
				
				echo '</li>';
			}
			echo '</ul>';
			
			echo '</div>'; // gdlr-admin-nav-wrapper				
		}
		
		function print_admin_content(){
		
			$option_generator = new gdlr_lms_admin_option_html();

			// admin content
			echo '<div class="gdlr-admin-content-wrapper" id="gdlr-admin-content">';
			
			echo '<div class="gdlr-admin-head">';
			echo '<div class="gdlr-save-button">';
			echo '<img class="now-loading" src="' . plugins_url('images/admin-panel/loading.gif', __FILE__) . '" alt="loading" />';				
			echo '<input value="' . __('Save Changes', 'gdlr-lms') . '" type="submit" class="gdl-button" />';
			echo '</div>'; 
			
			echo '<div class="gdlr-admin-head-gimmick"></div>';
			
			echo '<div class="clear"></div>';
			echo '</div>'; // gdlr-admin-head
			
			echo '<div class="gdlr-content-group">';
			foreach( $this->option as $menu_slug => $menu_settings ){
				foreach( $menu_settings['options'] as $sub_menu_slug => $sub_menu_settings ){
					if( !empty($sub_menu_settings) ){
						echo '<div class="gdlr-content-section" id="' . $sub_menu_slug . '" >';
						foreach( $sub_menu_settings['options'] as $option_slug => $option_settings ){
							$option_settings['slug'] = $option_slug;
							$option_settings['name'] = $option_slug;
							if( isset($this->value[$option_slug]) ){
								$option_settings['value'] = $this->value[$option_slug];
							}
							
							$option_generator->generate_admin_option($option_settings);
						}
						echo '</div>'; // gdlr-content-section
					}
				}
			}								
			echo '</div>'; // gdlr-content-group

			echo '<div class="gdlr-admin-footer">';
			echo '<div class="gdlr-save-button">';
			echo '<img class="now-loading" src="' . plugins_url('images/admin-panel/loading.gif', __FILE__) . '" alt="loading" />';
			echo '<input value="' . __('Save Changes', 'gdlr-lms') . '" type="submit" class="gdl-button" />';
			echo '</div>';
			
			echo '<div class="clear"></div>';
			echo '</div>'; // gdlr-admin-footer
			
			echo '</div>'; // gdlr-admin-content-wrapper
		
		}
		
	}

?>
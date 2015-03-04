<?php
	/*	
	*	Goodlayers Meta Template File
	*/	
	
	// decide to print different option
	function gdlr_lms_print_meta_box($settings){
		$settings['wrapper-class'] = empty($settings['wrapper-class'])? '': $settings['wrapper-class'];
		echo '<div class="gdlr-lms-meta-option ' . $settings['wrapper-class'] . '">';
		if( !empty($settings['title']) ){
			echo '<span class="gdlr-lms-meta-title"> ' . $settings['title'] . ' : </span>';
		}
		switch ($settings['type']){
			case 'description': gdlr_lms_print_description($settings); break;
			case 'button': gdlr_lms_print_button($settings); break;
			case 'text': gdlr_lms_print_text_input($settings); break;
			case 'textarea': gdlr_lms_print_textarea($settings); break;
			case 'upload': gdlr_lms_print_upload_box($settings); break;
			case 'combobox': gdlr_lms_print_combobox($settings); break;
			case 'checkbox': gdlr_lms_print_checkbox($settings); break;
			case 'datepicker': gdlr_lms_print_datepicker($settings); break;
			case 'wysiwyg': gdlr_lms_print_wysiwyg($settings); break;
			case 'question': gdlr_lms_print_question($settings); break;
		}
		if( !empty($settings['description']) ){
			echo '<span class="gdlr-lms-meta-description"> ' . $settings['description'] . '</span>';
		}
		echo '</div>';
	}

	// print description
	function gdlr_lms_print_description($settings){
		$settings['class'] = empty($settings['class'])? '': $settings['class'];
		
		echo '<div class="gdlr-lms-description">';
		echo $settings['default'];
		echo '</div>';
	}
	
	// print button
	function gdlr_lms_print_button($settings){
		$settings['class'] = empty($settings['class'])? '': $settings['class'];
		
		echo '<input id="' . $settings['slug'] . '" type="button" class="gdlr-lms-button" value="' . $settings['default'] . '" />';
	}		
	
	// print text input
	function gdlr_lms_print_text_input($settings){
		$settings['class'] = empty($settings['class'])? '': $settings['class'];
	
		echo '<input type="text" class="gdl-text-input ' . $settings['class'] . '" data-slug="' . $settings['slug'] . '" ';
		if( isset($settings['value']) ){
			echo 'value="' . esc_attr($settings['value']) . '" ';
		}else if( !empty($settings['default']) ){
			echo 'value="' . esc_attr($settings['default']) . '" ';
		}
		echo '/>';	
	}	
	
	// print text input
	function gdlr_lms_print_textarea($settings){
		$settings['class'] = empty($settings['class'])? '': $settings['class'];
	
		echo '<textarea type="text" class="gdl-text-input ' . $settings['class'] . '" data-slug="' . $settings['slug'] . '" >';
		if( isset($settings['value']) ){
			echo esc_textarea($settings['value']);
		}else if( !empty($settings['default']) ){
			echo esc_textarea($settings['default']);
		}
		echo '</textarea>';	
	}		
	
	// print upload box
	function gdlr_lms_print_upload_box($settings){
		$settings['class'] = empty($settings['class'])? '': $settings['class'];
	
		echo '<input type="text" class="gdl-text-input ' . $settings['class'] . '" data-slug="' . $settings['slug'] . '" ';
		if( isset($settings['value']) ){
			echo 'value="' . esc_attr($settings['value']) . '" ';
		}else if( !empty($settings['default']) ){
			echo 'value="' . esc_attr($settings['default']) . '" ';
		}
		echo '/>';	
		echo '<input type="button" class="gdlr-lms-upload-button" value="' . __('Upload', 'gdlr-lms') . '" />';
	}
	
	// print combobox
	function gdlr_lms_print_combobox($settings = array()){
		$value = '';
		if( !empty($settings['value']) ){
			$value = $settings['value'];
		}else if( !empty($settings['default']) ){
			$value = $settings['default'];
		}
		
		echo '<div class="gdlr-combobox-wrapper">';
		echo '<select data-slug="' . $settings['slug'] . '" >';
		foreach($settings['options'] as $slug => $title ){
			echo '<option value="' . $slug . '" ';
			echo ($value == $slug)? 'selected ': '';
			echo '>' . $title . '</option>';
		
		}
		echo '</select>';
		echo '</div>'; // gdlr-combobox-wrapper
	}	
	
	// print the checkbox ( enable / disable )
	function gdlr_lms_print_checkbox($settings = array()){
		$value = 'enable';
		if( !empty($settings['value']) ){
			$value = $settings['value'];
		}else if( !empty($settings['default']) ){
			$value = $settings['default'];
		}
		
		echo '<label for="' . $settings['slug'] . '-id" class="checkbox-wrapper">';
		echo '<span class="checkbox-appearance ' . $value . '" >enable/disable</span>';
		
		echo '<input type="checkbox" data-slug="' . $settings['slug'] . '" id="' . $settings['slug'] . '-id" ';
		echo ($value == 'enable')? 'checked': '';
		echo ' value="enable" />';			
		echo '</label>';		
	}		

	// print the datepicker
	function gdlr_lms_print_datepicker($settings = array()){
		echo '<input type="text" class="gdl-text-input medium gdlr-date-picker" data-slug="' . $settings['slug'] . '" ';
		if( isset($settings['value']) ){
			echo 'value="' . esc_attr($settings['value']) . '" ';
		}else if( !empty($settings['default']) ){
			echo 'value="' . esc_attr($settings['default']) . '" ';
		}
		echo '/>';
	}	
	
	// print wysiwyg editor
	function gdlr_lms_print_wysiwyg($settings){
		$value = '';
		if( !empty($settings['value']) ){
			$value = $settings['value'];
		}else if( !empty($settings['default']) ){
			$value = $settings['default'];
		}	
	
		wp_editor($value, $settings['slug'], array('tinymce'=>array('height' => 250)));
	}
	
	// print quiz question
	function gdlr_lms_print_question($settings){
		echo '<div class="quiz-tab-add-new">';
		echo '<span class="head">+</span>';
		echo '<span class="tail">' . __('Add Question', 'gdlr-lms') . '</span>';
		echo '</div>'; // course-tab-add-new
		
		gdlr_lms_quiz_template();
		echo '<textarea class="gdlr-trigger hidden" data-slug="' . $settings['slug'] . '" >' . esc_textarea($settings['value']) . '</textarea>';
		echo '<div class="quiz-question-holder"></div>';
	}
	function gdlr_lms_quiz_template(){	
		echo '<div class="quiz-question-item">';
		echo '<div class="quiz-question-head">';
		echo '<span class="head">' . __('Question :', 'gdlr-lms') . '</span> ';
		echo '<div class="quiz-open-content"></div>';
		echo '<div class="quiz-title"><textarea data-quiz="question" ></textarea></div>';
		echo '</div>'; // quiz-question-head
		
		echo '<div class="quiz-question-body">';
		echo '<div class="quiz-add-choice" >';
		echo '<span class="head">+</span>';
		echo '<span class="tail">' . __('Add Choice', 'gdlr-lms') . '</span>';		
		echo '</div>'; // quiz-add-choice
		
		echo '<ol class="quiz-choice" data-quiz-slug="quiz-choice"></ol>';
		
		echo '<div class="quiz-answer">';
		echo '<span class="head">' . __('Correct answer(s) :', 'gdlr-lms') . '</span> ';
		echo '<input type="text" data-quiz="quiz-answer" />';
		echo '<span class="tail">' . __('Use comma (,) for multiple answers', 'gdlr-lms') . '</span> ';
		echo '<div class="clear"></div>';
		echo '<span class="head">' . __('Score for this question :', 'gdlr-lms') . '</span> ';
		echo '<input type="text" data-quiz="score" />';		
		echo '</div>';
		echo '</div>'; // quiz-question-body
		echo '</div>'; // quiz-question-item
	}
?>
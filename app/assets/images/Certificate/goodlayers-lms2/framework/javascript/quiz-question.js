(function($){
	
	function update_question_box(holder, output){
		var options = [];
		
		holder.children().each(function(){
			var option = new Object();
		
			$(this).find('[data-quiz]').each(function(){
				if( $(this).parent().is('li') ){ 
					if( !option[$(this).attr('data-quiz')] ){
						option[$(this).attr('data-quiz')] = [$(this).val()];
					}else{
						option[$(this).attr('data-quiz')].push($(this).val());
					}
				}else{
					option[$(this).attr('data-quiz')] = $(this).val();
				}
			});
			options.push(option);
		});
		
		output.val(JSON.stringify(options));
	}
	
	function set_question_box(holder, template, options){
		holder.empty(); if( !options ) return;
		
		for(var i = 0; i < options.length; i++){
			var clone = template.clone();
			$.each(options[i], function(key, value){
				if( $.isArray(value) ){
					for(var i = 0; i < value.length; i++){
						clone.find('[data-quiz-slug="' + key + '"]').append(
							$('<li></li>').append($('<input type="text" data-quiz="quiz-choice" />').val(value[i]))
										  .append('<div class="quiz-choice-remove">Delete</div></li>')
						);
					}
				}else{
					clone.find('[data-quiz="' + key + '"]').val(value);
				}
			});
			holder.append(clone);
		}
	}

	$.fn.gdlr_lms_question_box = function(){
		var holder = $(this);
		var output = $(this).siblings('textarea');
		
		// event when textarea is updated
		output.change(function(){
			set_question_box(holder, holder.siblings('.quiz-question-item'), $.parseJSON(output.val()));
		});
		output.trigger('change');
		
		// event when added question is clicked
		$(this).siblings('.quiz-tab-add-new').click(function(){
			var clone = holder.siblings('.quiz-question-item').clone().hide();
			clone.appendTo(holder).slideDown();
			update_question_box(holder, output);
		});

		// updating data when any field is updating
		$(this).on('change', '[data-quiz]', function(){
			update_question_box(holder, output);
		});
		
		// bind expand question event
		$(this).on('click', '.quiz-open-content', function(){
			if( $(this).hasClass('active') ){
				$(this).removeClass('active');
				$(this).parent('.quiz-question-head').siblings('.quiz-question-body').slideUp();
			}else{
				$(this).addClass('active');
				$(this).parent('.quiz-question-head').siblings('.quiz-question-body').slideDown();
			}
		});
		
		// bind the add choice event
		$(this).on('click', '.quiz-add-choice', function(){
			var new_choice = $('<li><input type="text" data-quiz="quiz-choice" /><div class="quiz-choice-remove">Delete</div></li>').hide();
			new_choice.appendTo($(this).siblings('.quiz-choice')).slideDown(200);
			update_question_box(holder, output);
		});
		
		// event when choice is removed		
		$(this).on('click', '.quiz-choice-remove', function(){
			$(this).parent('li').slideUp(function(){ 
				$(this).remove(); 
				update_question_box(holder, output); 
			});
		});
	}

})(jQuery);
class TopicsController < ApplicationController
	def new
		
	end
	def create
	  @topic = Topic.new(params[:topic])
	  if @topic.save
	    @topic = Topic.new(:name => params[:topic][:name], :last_poster_id => current_user.id, :last_post_at => Time.now, :forum_id => params[:topic][:forum_id])
	    
	    if @post.save
	      flash[:notice] = "Successfully created topic."
	      redirect_to "/forums/#{@topic.forum_id}"
	    else
	      redirect :action => 'new'
	    end
	  else
	    render :action => 'new'
	  end
	end
end

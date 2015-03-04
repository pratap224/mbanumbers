class ForumsController < ApplicationController
layout 'homepage'
  before_filter :change_style
  before_filter :authenticate_user

  def index
    
  	@forum=Refforum.all
    @title = "Forum"
  end
  def topics
   
    @title = Refforum.find(params[:id]).name
    @topics = Refforum.find(params[:id]).topics
  
  end
  def topic_new
    @topic = Topic.new(params.permit(:refforum_id, :name))
    @topic.member_id = session[:user_id]
    if @topic.save
      flash[:success] = 'Topic uploaded'
      redirect_to forum_topic_path(params[:refforum_id])
    end
  end
  def posts

    @posts = Topic.find(params[:topic]).posts
  end
  def post_new
    @post = Post.new(params.permit(:topic_id, :content))
    @post.member_id = session[:user_id]
    if @post.save
      flash[:success] = 'Post created'
      redirect_to forum_posts_path(params['topic_id'])
    end
  end
  
  def ads
  	
  end
  
  def postcreate
    post=Post.new(req_postparams)
    if post.save
      redirect_to forum_post_path(post.topic_id )
    end
  end
  def create
    topic=Topic.new(req_params)
    if topic.save
      flash[:success] = 'Topic created'
      redirect_to forum_post_path(topic.id)
    end

  end
  private
  def req_params
    params.permit(:name)
  end
  def req_postparams
    params.permit(:content,:topic_id)
  end
  def change_style
    @forum = 'forum'
  end
end

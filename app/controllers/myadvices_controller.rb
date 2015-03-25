class MyadvicesController < ApplicationController
 layout 'homepage'
before_action :authenticate_user, :except => [:myadvice, :blogdata]

	def myadvice
    @blogpost = Refblog.order(created_at: :desc).paginate(:page => params[:page], :per_page => 4)
    @title = "my advice"
  end
  def blogdata
    @title = "blogdata"
      @blog_data=Refblog.find_by_id(params[:id])
      @myadvicecomments = Myadvice.where('post_id=?', params[:id])
       
  end

  def new
	@comment= Myadvice.new
  end

  def create
	@comment = Myadvice.new(params.permit(:title, :comment))
    @comment.member_id = session[:user_id]
    @comment.post_id = Refblog.find_by_id(params[:id]).id
   if @comment.save
    flash[:success] = 'Comment added'
    redirect_to myadvices_blog_path(params[:id])
   else
    render :text => 'something went wrong'
   end
  end
end

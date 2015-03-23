class AnnouncesController < ApplicationController

	layout 'homepage'
 # before_action :authenticate_user

	def index
    @blogpost = Refineryannounce.order(created_at: :desc).paginate(:page => params[:page], :per_page => 4)
  
    @title = "Site Announcements"

  end
  # def announcedate
  #     @blog_data=Refineryannounce.find_by_id(params[:id])
  #     @myadvicecomments = Announce.where('post_id=?', params[:id])
       
  # end
  def single
    @announce_data=Refineryannounce.find_by_id(params[:id])
  end
end

class HomepageController < ApplicationController
  
  def index
  	@anouncements = Refannouncement.all
    @blogpost =  Refblog.last
    @testimonials = Reftestimonial.all
    @posts = Refforum.last(3)
    @social = Refinery::Page.where(:slug => 'home_social_groups').first
    
  end
  def create
  
  end
  def blog
      
  end
end

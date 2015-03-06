class HomepageController < ApplicationController
  
  def index
  	@anouncements = Refannouncement.all
    @blogpost =  Refblog.last(3)
    @testimonials = Reftestimonial.all
    @posts = Refforum.last(2)
    @social = Refinery::Page.where(:slug => 'home_social_groups').first
    
  end
  def create
  
  end
  def blog
      
  end
end

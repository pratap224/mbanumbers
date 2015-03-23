class HomepageController < ApplicationController
  
  def index
  	@anouncements = Refineryannounce.last(2)
    @blogpost =  Refblog.last(2)
    @testimonials = Reftestimonial.all
    @posts = Refforum.last(6)
    @social = Refinery::Page.where(:slug => 'home_social_groups').first
    @users = Member.all
    @schools = Application.all
    @newcast = Refnewcast.all
    @allstates = State.all
     

    
    
    # @breakings = RefineryBreaking.all
  end
  def create
  
  end
  def blog
      
  end
end

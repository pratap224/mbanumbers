class CollegesController < ApplicationController
	layout 'member'
  def index
  	@state=Ucollege.where("state_id=?",params[:stateid])

  end
  def searchusers
    
    @member=Member.where("username LIKE ? ", "%#{params[:username]}%")
    # binding.pry
  end
end

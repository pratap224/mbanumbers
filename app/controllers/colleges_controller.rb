class CollegesController < ApplicationController
	layout 'member'
  def index
  	@state=Ucollege.where("state_id=?",params[:stateid])

  end
end

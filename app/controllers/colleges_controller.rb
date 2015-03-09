class CollegesController < ApplicationController
	layout 'member'
  def index
  	@state=School.where("state_id=?",params[:stateid])

  end
end

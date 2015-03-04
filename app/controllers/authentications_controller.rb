class AuthenticationsController < ApplicationController
  
  def index
  	
  end
  
  def create
    member = Member.from_omniauth(auth_hash)
    member.username = member.name.gsub(' ','_'+rand(1..600).to_s)
    exis = User.find_by_email(member.email)
    if member.email.nil?
      member.email = rand(1..1000000).to_s + '@mail.com'
    end
    if exis.nil?
	    member.save
	    session[:user_id] = member.id
	    redirect_to profile_index_path, notice: 'Signed In!'
	else
		session[:user_id] = exis.id
		redirect_to profile_index_path, notice: 'Signed In!'
	end
  end

  def destroy
   session[:user_id] = nil
   redirect_to root_url, notice: "Signed out!"	
  end

  private
    def auth_hash
      request.env['omniauth.auth']
    end
end

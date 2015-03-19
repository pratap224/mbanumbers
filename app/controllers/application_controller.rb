class ApplicationController < ActionController::Base
  # Prevent CSRF attacks by raising an exception.
  # For APIs, you may want to use :null_session instead.
  protect_from_forgery with: :exception

  
  private
  	def current_user
  		@current_user ||= Member.find(session[:user_id]) if session[:user_id]
  	end
  	def authenticated
  		redirect_to root_url unless current_user.nil?
  	end
    def authenticate_user
      redirect_to profile_login_path, notice: 'User needs to be authenticated' unless session[:user_id]
    end
    def check_session
      redirect_to profile_index_path, :notice => 'user already logged in' unless session[:user_id].nil?
    end
  	helper_method :current_user
    def not_found
      raise ActionController::RoutingError.new('Not Found')
    end
end

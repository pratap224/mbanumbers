class SubscribesController < ApplicationController
layout 'homepage'

	def subscribe
        
        token = SecureRandom.urlsafe_base64
        @subs = Subscriber.new(:token => token, email: params["email"],activation: true)
        
        if @subs.save
        	
			UserMailer.contacts(@subs).deliver!
			
		end
	end
	def confirm
		@sub = Subscriber.find_by_token(params[:token])
		unless @sub.nil?
			@sub.activation = true
			@sub.save
		end
	end
	def contactus
		@title = "Contact us" 
    end

    def submitcontact
    	
    		UserMailer.support_email(params).deliver!

		UserMailer.contact_email(params).deliver!
		flash[:success] = "Thank you for contacting us"
		redirect_to root_url , :alert => "Mail send sucessfully"
    end
end

class SubscribesController < ApplicationController
layout 'homepage'

	def subscribe
        
        token = SecureRandom.urlsafe_base64
        @subs = Subscriber.new(:token => token, email: params["email"],activation: true)
        
        if @subs.save
        	
			UserMailer.contacts(@subs).deliver!
			flash[:success] = "Thank you for Subscribing us"
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

    		@user = Contact.new(req_params)
    			if @user.save
    		UserMailer.support_email(params).deliver!
    			
		UserMailer.contact_email(params).deliver!
	
		flash[:success] = "Thank you for contacting us"
		
		redirect_to root_url , :alert => "Mail send sucessfully"
	else 
		redirect_to subscribes_contactus_path, :flash => {:model_errors => @user.errors.messages}
		

	end
    end

private
def req_params
  	params.permit( :name, :email, :subject, :message)
  end
end

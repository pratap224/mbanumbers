class UserMailer < ApplicationMailer
  
  def contacts(user)
	  @user = user
	  mail( :to => @user.email, :subject => 'MBA Numbers  :: Requesting Helpline Acknowledgement')
	end

	def contact_email(user)
    @user = user
    mail( :to => @user["email"], :subject => 'MBA Numbers  :: Requesting Helpline Acknowledgement')
  end
	def support_email(user)
   @user = user
   mail( :from => @user["email"], :to => "admin@mbanumbers.com", :subject => "Mail From #{@user['name']}" )
  end

  def sendemail(user)
   @user = user
   mail(:to =>@user['email'], subject: 'Your Registration is Complete')
  end

  def sent(user)
    @user = user
    mail( :to => @user[:name], :subject => "You got mail from MBA Numbers User")
  end

  def forgot_email(user)
    @user = user
    mail( :to => @user.email, :subject => 'MBA Numbers :: ForgotPassword')
  end
   def friend(user)
   @user = user
   mail(:to =>@user.friend, subject: 'Your friend has recommended you to join MBAnumbers.com')

  end
  # def friend(shift)
  #     @shift = shift
  #     @user = shift.friend
  #     @recipients = User.where(:replacement_emails => true)
      
  #     emails = @recipients.collect(&:email).join(",")
  #     mail(:to => @user.friend, :subject => "refer friend")
  # end
  # def friend(user)
  #    @recipients = User.where(:replacement_emails => true)
  #    @recipients.each do |recipient|
  #      request_replacement(recipient, user).deliver
  #    end


  #  def request_replacement(recipient, user)
  #    @user = user.friend
  #     @recipients = User.where(:replacement_emails => true)
  #    mail(:to =>@user.friend, subject: 'refer friend')
  #  end

end

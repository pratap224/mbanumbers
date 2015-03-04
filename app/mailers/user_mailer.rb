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
   mail( :from => @user["email"], :to => "infombanumbers@gmail.com", :subject => "Mail From #{@user['name']}" )
  end

  def sendemail(user)
   @user = user
   mail(:to =>@user['email'], subject: 'Your Registration Is Completed')
  end

  def sent(user)
    @user = user
    mail( :to => @user[:name], :subject => "test mail")
  end

  def forgot_email(user)
    @user = user
    mail( :to => @user.email, :subject => 'MBA Numbers :: ForgotPassword')
  end
  
end

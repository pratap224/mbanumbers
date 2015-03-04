class MailboxesController < ApplicationController
 before_action :authenticate_user
 layout 'homepage'
  def mailbox
    @tittle = 'Mailbox'
    @outbox = Outbox.where('member_id=?',session[:user_id])
    @inboxreciver = Outbox.where('name=? AND receiver_at=?',Member.find(session[:user_id]).email,TRUE)
  end

  def outbox
    # Client.where("orders_count = ? AND locked = ?", params[:orders], false)
    @senderoutbox = Outbox.where('member_id=? AND sender_at=?',session[:user_id],TRUE)
    @senderinbox = Outbox.where('member_id=? AND sender_at=?',session[:user_id],FALSE)
    
    @inbox = Outbox.where('name=? AND sender_at=?',Member.find(session[:user_id]).email,TRUE)
  end

  def newest
    @outbox = Outbox.where('member_id=?',session[:user_id])
    @inbox = Outbox.where('name=?',Member.find(session[:user_id]).email)
  end
  
  def show
   @reply = Reply.where('outbox_id=?', params[:id])
   @inbox = Outbox.find(params[:id])
  end

  def new
    @reply = Reply.new
  end

  def save
    @reply = Reply.new(reply_params)
    if @reply.save
      redirect_to(:action => 'mailbox')
    else
    render :action => 'show' 
    end

  end



  def compose
     UserMailer.sent(params).deliver!
     @outbox = Outbox.new(:name => params[:name], :subject => params[:subject], 
      :message => params[:message], :member_id => session[:user_id], :from => params[:from],:sender_at => params[:sender_at],:receiver_at => params[:receiver_at])
     @outbox.from = current_user.email
      if @outbox.save
        redirect_to  :action => 'mailbox' , :alert => "Message send sucessfully"
      end
  end
  def destroy
    @outbox = Outbox.find(params[:id]).update(:receiver_at => 'FALSE')

    if @outbox
      redirect_to :action => 'mailbox'
    end

  end
  def outboxdel
 
    @outboxdel= Outbox.find_by_id(params[:id]).update(:sender_at => 'FALSE')
    if @outboxdel
      redirect_to mailboxes_outbox_path
    end

  end



  def reply_params
      params.permit(:outbox_id, :message)
      
   end
end

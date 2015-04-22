class ProfileController < ApplicationController
layout 'homepage'
before_action :authenticate_user, :except => [:name,:profileupdates,:topusers,:login, :create, :forgotpassword, :createforgotpassword,:updatepassword,:createupdatepwd]
before_action :check_session, :only => [:login, :create]


  def index
    @title = 'Profile'
    @stuff = Stuff.find_by_member_id(session[:user_id]) || Stuff.new
    @app_data = Application.where('user_id=?',session[:user_id])
    @q = Member.ransack(params[:q])
     # binding.pry
     # @users = Member.find_by_username(['username'])
    @user = @q.result(distinct: true)
    @user=Member.new()
    @school_name=School.all
    @state = Ustate.all

    @comments = Comment.where('target_id=?',session[:user_id])
    @allmember=Bookmark.where('currentuserid=?',session[:user_id])
  end
  

  def stuffupdate
    @stuff = Stuff.find_by_member_id(session[:user_id])
    if @stuff.nil?
      @stuff = Stuff.new(stuff_params)
      @stuff.member_id = session[:user_id]
      if @stuff.save
        flash[:success] = "Details updated successfully"
        redirect_to profile_index_path
      else
        flash[:notice] = "Something went wrong"
        redirect_to root_url
      end
    else
      if @stuff.update_attributes(stuff_params)
        flash[:success] = "Details updated successfully"
        redirect_to profile_index_path
      end
    end
  end

  def staticbulk
    @title="Members By Name"
    @all_mebers=Member.all
  end
  def staticprofile


    # @a=params[:q]
    
    # if !@a.nil?
    #  @user = Member.find_by_username(@a['username'])
    # else
      @user = Member.find_by_username(params[:username])
    # end
    # @user = Member.find_by_username(params[:username])
    unless @user.nil?
      @stuff = Stuff.find_by_member_id(@user.id)
      @lists = Application.where('user_id=?',@user.id)
      @buseridcount=Bookmark.where("bookmarkuserid = ?", @user.id).count
      @comments = Comment.where('target_id=?',@user.id)
    else
       flash[:error]="Username Not Found"
      redirect_to profile_index_path
    end
  end
  def bookmark
    @buseridcount=Bookmark.where("bookmarkuserid = ?", params[:bookmarkuserid]).count
    if @buseridcount < 1
      @data= Bookmark.new(req_params)
        if @data.save
          render :json => true
        end 
    else
      render :json => false
    end
  end
  def remove
    @buserdel=Bookmark.destroy_all(bookmarkuserid: params[:id])
    if @buserdel
      redirect_to static_profile_path(Member.find(params[:id]).username)
    end
  end

  
  def login
  	@title = 'Sign in'
    #redirect_to root_url unless member[:user_id].nil?
  end
  
  def create
    status = Member.authenticate(params[:email], params[:password])
    if status
      session[:user_id] = status
      flash[:success] = 'Welcome to MBA Numbers'
      redirect_to profile_index_path
    else
      flash[:notice] = "Please check your credentials"
      redirect_to profile_login_path
    end
  end

  def mailbox
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
      :message => params[:message], :member_id => session[:user_id], :from => params[:from]) 
     @outbox.from = current_user.email
      if @outbox.save
        redirect_to  :action => 'mailbox' , :alert => "Message send sucessfully"
      end
  end
  def destroy
    @outbox = Outbox.find(params[:id])

    @outbox.destroy
    redirect_to :action => 'mailbox'

  end

  def edit
    @user=Member.new()
    
  end
  def update
    
    update=current_user.update(:gpa => params[:member][:gpa], :gmat_score => params[:member][:gmat_score], :hometown => params[:member][:hometown], :status => params[:member][:status],:exp => params[:member][:exp])
    if update
      flash[:success]="Profile has been changed sucessfully"
      redirect_to profile_index_path
    end
    
  end


  def settings
    @title="Profile Settings"
    @user=Member.new()
    @school_name=School.all
    @state = Ustate.all
    
    
  end
  
  def profilecreate 
     
      unless params[:undergraduate_school].empty?
        schoolname = params[:undergraduate_school]
      else
        schoolname = params[:school]
      end

    update=current_user.update(:username => params[:member][:username],:email => params[:member][:email],:zipcode => params[:member][:zipcode],:gpa => params[:member][:gpa], :gmat_score => params[:member][:gmat_score], :hometown => params[:member][:hometown], :undergraduate_school => schoolname, :year => params[:date][:year], :state => params[:state], :question => params[:member][:question])
    if update
      current_user.update(:image => params[:member][:image]) unless params[:member][:image].nil?
      flash[:success]="Profile has been changed sucessfully"
      redirect_to profile_index_path
    end
  end

  def chnagepwd
    @title= "change your password"
  end
  
  def changepwdcreate
    if current_user.password == params['oldpassword']
      if params[:newpassword]== params[:conformpassword]
          # membertab=current_user.password=params[:newpassword]
          member=Member.find(session[:user_id])
          member.password=params[:newpassword]
          if member.save
            flash[:success]= "Your Password Changed Sucessfully"
            redirect_to profile_index_path
          end
      else
        flash[:error]="New Password And ConformPassword Doesnot Match"
      end
    else
      flash[:error]="Oldpassword wrong please enter correct"
      redirect_to profile_chnagepwd_path
    end
  end

  def forgotpassword
    @title="forgot your password"
  end

  def createforgotpassword
    @user=Member.find_by_email(params['email'])
    
    unless @user.nil?
      @mail=UserMailer.forgot_email(@user).deliver!
      flash[:success]="Please reset password go through your mail"
      redirect_to profile_login_path
    else
      flash[:error]="This email is not existed"
      redirect_to profile_forgotpassword_path
    end
  end

  def updatepassword
  end

  def createupdatepwd
    if params[:newpassword] == params[:conformpassword]
      # membertab=current_user.password=params[:newpassword]
      member=Member.find_by_token(params[:token])
      member.password=params[:newpassword]
      if member.save
        flash[:success]= "Your Password Changed Sucessfully"
        redirect_to profile_login_path
      end
    else
      flash[:error]="New Password And ConformPassword Doesnot Match"
    end
  end

   def commentcreate
    # binding.pry
    @comment = Comment.new(params.permit(:title, :comment))
    @comment.user_id = session[:user_id]
    @comment.target_id = Member.find_by_username(params[:username]).id

    if @comment.save
      flash[:success] = 'Comment added'
      redirect_to static_profile_path(params[:username])
    else
      render :text => 'something went wrong'
    end

  end
  def topusers
    @title="Top Users"
    @all_mebers=Member.order('created_at DESC').paginate(:page => params[:page], :per_page => 20)
    
    # Client.all(:order => "created_at DESC")
    # Client.all(:order => "created_at DESC")
  end

  def bookmarklist
    @title = "Bookmark List"
    @allmember=Bookmark.where('currentuserid=?',session[:user_id])
  end

  def removebookmarklist
    @buserdel=Bookmark.destroy_all(bookmarkuserid: params[:id])
    if @buserdel
      redirect_to profile_bookmarklist_path
    end
  end

  def profileupdates
    @title = "Profile Updates"
    @updates = Application.all
    @all_mebers=Member.order('created_at DESC').paginate(:page => params[:page], :per_page => 20)
    
    # binding.pry
  end

  def like
    @a=params[:cuserid]

    @user= Like.new(:cuser_id => params[:cuserid],:puser_id => params[:buserid],:count => "1")
    if @user.save
      render json: true
    end
  end

  def dislike
      
     
     @a=Like.delete_all(puser_id: params[:buserid])
     
     if @a == 1
        render json: true
     end



  end
  def name
    @title="By Name"
    @all_mebers=Member.order('created_at DESC').paginate(:page => params[:page], :per_page => 20)
  end
  def commitschool
    @commitschool=Member.find(params[:cuurentuserid]).update(:commitschool => params[:schoolname])
    
    if @commitschool
      render json: true
    end

  end

  

  private
    def stuff_params
      params.require(:stuff).permit(:ugschool,:gpa, :gmat, :hometown)
    end

    def reply_params
      params.permit(:outbox_id, :message)
    end
    def req_params
      params.permit(:currentuserid,:bookmarkuserid)
    end
end

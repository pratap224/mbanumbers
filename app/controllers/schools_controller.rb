class SchoolsController < ApplicationController
	layout 'schools'
  before_action :authenticate_user, :only => [:profile, :create, :destroy, :update, :edit]
  before_action :check_auth, :only => [:edit, :update, :destroy]
  def index
  	@title="schools"
  	# @schools= School.paginate(:page => params[:page], :per_page => 10)
    @q = School.ransack(params[:q]) 
    @schools = @q.result(distinct: true).paginate(:page => params[:page], :per_page => 20).order('business_school ASC')
 
  end

  def profile
  	@title="Add Application"
    @school_name=School.all
    @app_data=Application.all
    
  	
  end
  def ranking
    @title="Browse MBA schools by Ranking"
    @schools = School.order('forbes').paginate(:page => params[:page], :per_page => 20)
    # binding.pry
  end
  def state
    @title = "Schools List By State"
    @states= State.order('name').paginate(:page => params[:page], :per_page => 20)
   end

    def statelist
    @title = "Schools State Wise List"
    end


  def edit
   @title="Edit Application"
    @app_data = Application.find(params[:id])
    @school_name = School.all 
  end
  def schoolappinfo
    @school=Application.find_by_school(params[:schoolname])
    @title=params[:schoolname]
  end


  def update
    @schools = Application.find(params[:id])
    if @schools.update(req_params) 
      redirect_to profile_index_path
    else
      render :action => 'edit'
    end
  end

  def destroy
    @app_data = Application.find(params[:id])
    binding.pry
    if @app_data.school==current_user.commitschool
      current_user
    end
    @app_data.destroy
    redirect_to profile_index_path
  end


  def name
  	@title="Schools List By Name"
    @schools= School.order('business_school').paginate(:page => params[:page], :per_page => 15)
  end

  def create
    binding.pry
    school_app=Application.new(req_params)
    school_app.user_id = session[:user_id]
    if school_app.save
      flash[:success] = "Application added"
      redirect_to profile_index_path
    end
  end

  private
  def req_params
    params.permit(:school, :university, :status,:application_type,:program,:interviewdate,:choice,:seat,:received,:complete,:descion,:scholarship,:interview)
  end
  def check_auth
    if Application.find(params[:id]).user_id != session[:user_id]
      render :text => "You are not authorized"
    end
  end

end

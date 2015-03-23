Refinery::Core::Engine.routes.draw do

  # Frontend routes
  namespace :announces do
    resources :announces, :path => '', :only => [:index, :show]
  end

  # Admin routes
  namespace :announces, :path => '' do
    namespace :admin, :path => Refinery::Core.backend_route do
      resources :announces, :except => :show do
        collection do
          post :update_positions
        end
      end
    end
  end

end

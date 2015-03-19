Refinery::Core::Engine.routes.draw do

  # Frontend routes
  namespace :breakings do
    resources :breakings, :path => '', :only => [:index, :show]
  end

  # Admin routes
  namespace :breakings, :path => '' do
    namespace :admin, :path => Refinery::Core.backend_route do
      resources :breakings, :except => :show do
        collection do
          post :update_positions
        end
      end
    end
  end

end

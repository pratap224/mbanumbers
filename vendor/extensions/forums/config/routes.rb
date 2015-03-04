Refinery::Core::Engine.routes.draw do

  # Frontend routes
  namespace :forums do
    resources :forums, :path => '', :only => [:index, :show]
  end

  # Admin routes
  namespace :forums, :path => '' do
    namespace :admin, :path => Refinery::Core.backend_route do
      resources :forums, :except => :show do
        collection do
          post :update_positions
        end
      end
    end
  end

end

Refinery::Core::Engine.routes.draw do

  # Frontend routes
  namespace :newcasts do
    resources :newcasts, :path => '', :only => [:index, :show]
  end

  # Admin routes
  namespace :newcasts, :path => '' do
    namespace :admin, :path => Refinery::Core.backend_route do
      resources :newcasts, :except => :show do
        collection do
          post :update_positions
        end
      end
    end
  end

end

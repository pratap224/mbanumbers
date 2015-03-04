Refinery::Core::Engine.routes.draw do

  # Frontend routes
  namespace :blogposts do
    resources :blogposts, :path => '', :only => [:index, :show]
  end

  # Admin routes
  namespace :blogposts, :path => '' do
    namespace :admin, :path => Refinery::Core.backend_route do
      resources :blogposts, :except => :show do
        collection do
          post :update_positions
        end
      end
    end
  end

end

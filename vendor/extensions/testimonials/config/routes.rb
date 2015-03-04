Refinery::Core::Engine.routes.draw do

  # Frontend routes
  namespace :testimonials do
    resources :testimonials, :path => '', :only => [:index, :show]
  end

  # Admin routes
  namespace :testimonials, :path => '' do
    namespace :admin, :path => Refinery::Core.backend_route do
      resources :testimonials, :except => :show do
        collection do
          post :update_positions
        end
      end
    end
  end

end

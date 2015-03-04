module Refinery
  module Blogposts
    module Admin
      class BlogpostsController < ::Refinery::AdminController

        crudify :'refinery/blogposts/blogpost'
        private
        def blogpost_params
        	params.require(:blogpost).permit( :title, :photo_id, :description)
        end
      end
    end
  end
end

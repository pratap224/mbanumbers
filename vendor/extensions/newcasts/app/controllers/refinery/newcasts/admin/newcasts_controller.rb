module Refinery
  module Newcasts
    module Admin
      class NewcastsController < ::Refinery::AdminController

        crudify :'refinery/newcasts/newcast'

        private

        # Only allow a trusted parameter "white list" through.
        def newcast_params
          params.require(:newcast).permit(:title, :description, :url)
        end
      end
    end
  end
end

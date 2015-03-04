module Refinery
  module Forums
    module Admin
      class ForumsController < ::Refinery::AdminController

        crudify :'refinery/forums/forum',
                :title_attribute => 'name'

        private

        # Only allow a trusted parameter "white list" through.
        def forum_params
          params.require(:forum).permit(:name, :description)
        end
      end
    end
  end
end

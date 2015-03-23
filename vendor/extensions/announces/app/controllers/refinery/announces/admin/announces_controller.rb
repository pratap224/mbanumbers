module Refinery
  module Announces
    module Admin
      class AnnouncesController < ::Refinery::AdminController

        crudify :'refinery/announces/announce'

        private

        # Only allow a trusted parameter "white list" through.
        def announce_params
          params.require(:announce).permit(:title, :description)
        end
      end
    end
  end
end

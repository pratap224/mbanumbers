module Refinery
  module Breakings
    module Admin
      class BreakingsController < ::Refinery::AdminController

        crudify :'refinery/breakings/breaking'

        private

        # Only allow a trusted parameter "white list" through.
        def breaking_params
          params.require(:breaking).permit(:title, :description)
        end
      end
    end
  end
end

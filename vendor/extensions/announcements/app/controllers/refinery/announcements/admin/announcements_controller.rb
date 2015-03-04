module Refinery
  module Announcements
    module Admin
      class AnnouncementsController < ::Refinery::AdminController

        crudify :'refinery/announcements/announcement'
        private
        def announcement_params
        	params.require(:announcement).permit( :title, :photo_id)
        end
      end
    end
  end
end

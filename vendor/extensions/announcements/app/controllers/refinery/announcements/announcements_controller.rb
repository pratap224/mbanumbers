module Refinery
  module Announcements
    class AnnouncementsController < ::ApplicationController

      before_action :find_all_announcements
      before_action :find_page

      def index
        # you can use meta fields from your model instead (e.g. browser_title)
        # by swapping @page for @announcement in the line below:
        present(@page)
      end

      def show
        @announcement = Announcement.find(params[:id])

        # you can use meta fields from your model instead (e.g. browser_title)
        # by swapping @page for @announcement in the line below:
        present(@page)
      end

    protected

      def find_all_announcements
        @announcements = Announcement.order('position ASC')
      end

      def find_page
        @page = ::Refinery::Page.where(:link_url => "/announcements").first
      end

    end
  end
end

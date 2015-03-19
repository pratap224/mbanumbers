module Refinery
  module Newcasts
    class NewcastsController < ::ApplicationController

      before_action :find_all_newcasts
      before_action :find_page

      def index
        # you can use meta fields from your model instead (e.g. browser_title)
        # by swapping @page for @newcast in the line below:
        present(@page)
      end

      def show
        @newcast = Newcast.find(params[:id])

        # you can use meta fields from your model instead (e.g. browser_title)
        # by swapping @page for @newcast in the line below:
        present(@page)
      end

    protected

      def find_all_newcasts
        @newcasts = Newcast.order('position ASC')
      end

      def find_page
        @page = ::Refinery::Page.where(:link_url => "/newcasts").first
      end

    end
  end
end

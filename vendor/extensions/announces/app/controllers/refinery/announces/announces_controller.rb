module Refinery
  module Announces
    class AnnouncesController < ::ApplicationController

      before_action :find_all_announces
      before_action :find_page

      def index
        # you can use meta fields from your model instead (e.g. browser_title)
        # by swapping @page for @announce in the line below:
        present(@page)
      end

      def show
        @announce = Announce.find(params[:id])

        # you can use meta fields from your model instead (e.g. browser_title)
        # by swapping @page for @announce in the line below:
        present(@page)
      end

    protected

      def find_all_announces
        @announces = Announce.order('position ASC')
      end

      def find_page
        @page = ::Refinery::Page.where(:link_url => "/announces").first
      end

    end
  end
end

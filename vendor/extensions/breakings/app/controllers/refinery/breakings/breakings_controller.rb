module Refinery
  module Breakings
    class BreakingsController < ::ApplicationController

      before_action :find_all_breakings
      before_action :find_page

      def index
        # you can use meta fields from your model instead (e.g. browser_title)
        # by swapping @page for @breaking in the line below:
        present(@page)
      end

      def show
        @breaking = Breaking.find(params[:id])

        # you can use meta fields from your model instead (e.g. browser_title)
        # by swapping @page for @breaking in the line below:
        present(@page)
      end

    protected

      def find_all_breakings
        @breakings = Breaking.order('position ASC')
      end

      def find_page
        @page = ::Refinery::Page.where(:link_url => "/breakings").first
      end

    end
  end
end

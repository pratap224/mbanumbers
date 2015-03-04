module Refinery
  module Forums
    class ForumsController < ::ApplicationController

      before_action :find_all_forums
      before_action :find_page

      def index
        # you can use meta fields from your model instead (e.g. browser_title)
        # by swapping @page for @forum in the line below:
        present(@page)
      end

      def show
        @forum = Forum.find(params[:id])

        # you can use meta fields from your model instead (e.g. browser_title)
        # by swapping @page for @forum in the line below:
        present(@page)
      end

    protected

      def find_all_forums
        @forums = Forum.order('position ASC')
      end

      def find_page
        @page = ::Refinery::Page.where(:link_url => "/forums").first
      end

    end
  end
end

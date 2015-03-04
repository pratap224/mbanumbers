module Refinery
  module Blogposts
    class BlogpostsController < ::ApplicationController

      before_action :find_all_blogposts
      before_action :find_page

      def index
        # you can use meta fields from your model instead (e.g. browser_title)
        # by swapping @page for @blogpost in the line below:
        present(@page)
      end

      def show
        @blogpost = Blogpost.find(params[:id])

        # you can use meta fields from your model instead (e.g. browser_title)
        # by swapping @page for @blogpost in the line below:
        present(@page)
      end

    protected

      def find_all_blogposts
        @blogposts = Blogpost.order('position ASC')
      end

      def find_page
        @page = ::Refinery::Page.where(:link_url => "/blogposts").first
      end

    end
  end
end

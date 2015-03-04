module Refinery
  module Blogposts
    class Engine < Rails::Engine
      extend Refinery::Engine
      isolate_namespace Refinery::Blogposts

      engine_name :refinery_blogposts

      before_inclusion do
        Refinery::Plugin.register do |plugin|
          plugin.name = "blogposts"
          plugin.url = proc { Refinery::Core::Engine.routes.url_helpers.blogposts_admin_blogposts_path }
          plugin.pathname = root
          
        end
      end

      config.after_initialize do
        Refinery.register_extension(Refinery::Blogposts)
      end
    end
  end
end

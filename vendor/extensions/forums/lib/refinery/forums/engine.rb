module Refinery
  module Forums
    class Engine < Rails::Engine
      extend Refinery::Engine
      isolate_namespace Refinery::Forums

      engine_name :refinery_forums

      before_inclusion do
        Refinery::Plugin.register do |plugin|
          plugin.name = "forums"
          plugin.url = proc { Refinery::Core::Engine.routes.url_helpers.forums_admin_forums_path }
          plugin.pathname = root
          
        end
      end

      config.after_initialize do
        Refinery.register_extension(Refinery::Forums)
      end
    end
  end
end

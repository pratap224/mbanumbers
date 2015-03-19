module Refinery
  module Newcasts
    class Engine < Rails::Engine
      extend Refinery::Engine
      isolate_namespace Refinery::Newcasts

      engine_name :refinery_newcasts

      before_inclusion do
        Refinery::Plugin.register do |plugin|
          plugin.name = "newcasts"
          plugin.url = proc { Refinery::Core::Engine.routes.url_helpers.newcasts_admin_newcasts_path }
          plugin.pathname = root
          
        end
      end

      config.after_initialize do
        Refinery.register_extension(Refinery::Newcasts)
      end
    end
  end
end

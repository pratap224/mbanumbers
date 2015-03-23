module Refinery
  module Announces
    class Engine < Rails::Engine
      extend Refinery::Engine
      isolate_namespace Refinery::Announces

      engine_name :refinery_announces

      before_inclusion do
        Refinery::Plugin.register do |plugin|
          plugin.name = "announces"
          plugin.url = proc { Refinery::Core::Engine.routes.url_helpers.announces_admin_announces_path }
          plugin.pathname = root
          
        end
      end

      config.after_initialize do
        Refinery.register_extension(Refinery::Announces)
      end
    end
  end
end

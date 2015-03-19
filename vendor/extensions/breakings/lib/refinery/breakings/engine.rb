module Refinery
  module Breakings
    class Engine < Rails::Engine
      extend Refinery::Engine
      isolate_namespace Refinery::Breakings

      engine_name :refinery_breakings

      before_inclusion do
        Refinery::Plugin.register do |plugin|
          plugin.name = "breakings"
          plugin.url = proc { Refinery::Core::Engine.routes.url_helpers.breakings_admin_breakings_path }
          plugin.pathname = root
          
        end
      end

      config.after_initialize do
        Refinery.register_extension(Refinery::Breakings)
      end
    end
  end
end

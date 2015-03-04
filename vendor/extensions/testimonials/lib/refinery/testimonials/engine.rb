module Refinery
  module Testimonials
    class Engine < Rails::Engine
      extend Refinery::Engine
      isolate_namespace Refinery::Testimonials

      engine_name :refinery_testimonials

      before_inclusion do
        Refinery::Plugin.register do |plugin|
          plugin.name = "testimonials"
          plugin.url = proc { Refinery::Core::Engine.routes.url_helpers.testimonials_admin_testimonials_path }
          plugin.pathname = root
          
        end
      end

      config.after_initialize do
        Refinery.register_extension(Refinery::Testimonials)
      end
    end
  end
end

# This migration comes from refinery_breakings (originally 1)
class CreateBreakingsBreakings < ActiveRecord::Migration

  def up
    create_table :refinery_breakings do |t|
      t.string :title
      t.text :description
      t.integer :position

      t.timestamps
    end

  end

  def down
    if defined?(::Refinery::UserPlugin)
      ::Refinery::UserPlugin.destroy_all({:name => "refinerycms-breakings"})
    end

    if defined?(::Refinery::Page)
      ::Refinery::Page.delete_all({:link_url => "/breakings/breakings"})
    end

    drop_table :refinery_breakings

  end

end

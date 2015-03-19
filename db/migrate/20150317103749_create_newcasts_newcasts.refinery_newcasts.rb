# This migration comes from refinery_newcasts (originally 1)
class CreateNewcastsNewcasts < ActiveRecord::Migration

  def up
    create_table :refinery_newcasts do |t|
      t.string :title
      t.text :description
      t.string :url
      t.integer :position

      t.timestamps
    end

  end

  def down
    if defined?(::Refinery::UserPlugin)
      ::Refinery::UserPlugin.destroy_all({:name => "refinerycms-newcasts"})
    end

    if defined?(::Refinery::Page)
      ::Refinery::Page.delete_all({:link_url => "/newcasts/newcasts"})
    end

    drop_table :refinery_newcasts

  end

end

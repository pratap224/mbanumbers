class CreateForumsForums < ActiveRecord::Migration

  def up
    create_table :refinery_forums do |t|
      t.string :name
      t.text :description
      t.integer :position

      t.timestamps
    end

  end

  def down
    if defined?(::Refinery::UserPlugin)
      ::Refinery::UserPlugin.destroy_all({:name => "refinerycms-forums"})
    end

    if defined?(::Refinery::Page)
      ::Refinery::Page.delete_all({:link_url => "/forums/forums"})
    end

    drop_table :refinery_forums

  end

end

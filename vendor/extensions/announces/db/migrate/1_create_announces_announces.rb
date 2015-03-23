class CreateAnnouncesAnnounces < ActiveRecord::Migration

  def up
    create_table :refinery_announces do |t|
      t.string :title
      t.text :description
      t.integer :position

      t.timestamps
    end

  end

  def down
    if defined?(::Refinery::UserPlugin)
      ::Refinery::UserPlugin.destroy_all({:name => "refinerycms-announces"})
    end

    if defined?(::Refinery::Page)
      ::Refinery::Page.delete_all({:link_url => "/announces/announces"})
    end

    drop_table :refinery_announces

  end

end

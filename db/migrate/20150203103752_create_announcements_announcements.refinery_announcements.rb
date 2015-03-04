# This migration comes from refinery_announcements (originally 1)
class CreateAnnouncementsAnnouncements < ActiveRecord::Migration

  def up
    create_table :refinery_announcements do |t|
      t.string :title
      t.integer :photo_id
      t.integer :position

      t.timestamps
    end

  end

  def down
    if defined?(::Refinery::UserPlugin)
      ::Refinery::UserPlugin.destroy_all({:name => "refinerycms-announcements"})
    end

    if defined?(::Refinery::Page)
      ::Refinery::Page.delete_all({:link_url => "/announcements/announcements"})
    end

    drop_table :refinery_announcements

  end

end

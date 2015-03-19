# This migration comes from refinery_news (originally 1)
class CreateNewsNews < ActiveRecord::Migration

  def up
    create_table :refinery_news do |t|
      t.string :title
      t.text :description
      t.integer :position

      t.timestamps
    end

  end

  def down
    if defined?(::Refinery::UserPlugin)
      ::Refinery::UserPlugin.destroy_all({:name => "refinerycms-news"})
    end

    if defined?(::Refinery::Page)
      ::Refinery::Page.delete_all({:link_url => "/news/news"})
    end

    drop_table :refinery_news

  end

end

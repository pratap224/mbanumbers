class CreateBlogpostsBlogposts < ActiveRecord::Migration

  def up
    create_table :refinery_blogposts do |t|
      t.string :title
      t.integer :photo_id
      t.text :description
      t.integer :position

      t.timestamps
    end

  end

  def down
    if defined?(::Refinery::UserPlugin)
      ::Refinery::UserPlugin.destroy_all({:name => "refinerycms-blogposts"})
    end

    if defined?(::Refinery::Page)
      ::Refinery::Page.delete_all({:link_url => "/blogposts/blogposts"})
    end

    drop_table :refinery_blogposts

  end

end

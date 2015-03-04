class CreateBookmarks < ActiveRecord::Migration
  def change
    create_table :bookmarks do |t|
      t.integer :currentuserid
      t.integer :bookmarkuserid

      t.timestamps
    end
  end
end

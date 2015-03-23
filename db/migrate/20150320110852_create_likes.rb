class CreateLikes < ActiveRecord::Migration
  def change
    create_table :likes do |t|
      t.integer :cuser_id
      t.integer :puser_id
      t.integer :count

      t.timestamps
    end
  end
end

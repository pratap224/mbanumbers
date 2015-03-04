class CreateStuffs < ActiveRecord::Migration
  def change
    create_table :stuffs do |t|
      t.integer :user_id
      t.string :ugschool
      t.float :gpa
      t.float :gmat
      t.string :hometown

      t.timestamps
    end
  end
end

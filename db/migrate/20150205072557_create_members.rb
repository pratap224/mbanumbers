class CreateMembers < ActiveRecord::Migration
  def change
    create_table :members do |t|
      t.string :name
      t.string :email
      t.integer :zipcode
      t.datetime :year
      t.string :password
      t.boolean :active
      t.timestamps
    end
  end
end

class CreateMyadvices < ActiveRecord::Migration
  def change
    create_table :myadvices do |t|
      t.string :title
      t.string :comment
      t.integer :post_id
      t.integer :member_id

      t.timestamps
    end
  end
end

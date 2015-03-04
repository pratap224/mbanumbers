class AddImageUidToMembers < ActiveRecord::Migration
  def change
    add_column :members, :image_uid, :string
    add_column :members, :image_name, :string
   	
  end
end

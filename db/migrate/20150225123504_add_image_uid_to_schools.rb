class AddImageUidToSchools < ActiveRecord::Migration
  def change
    add_column :schools, :image_uid, :string
    add_column :schools, :image_name, :string
    add_column :schools, :state_id, :integer
  end
end

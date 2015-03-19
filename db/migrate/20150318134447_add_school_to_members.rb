class AddSchoolToMembers < ActiveRecord::Migration
  def change
    add_column :members, :school, :string
  end
end

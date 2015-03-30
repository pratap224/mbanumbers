class AddExperienceToMembers < ActiveRecord::Migration
  def change
    add_column :members, :experience, :integer
  end
end

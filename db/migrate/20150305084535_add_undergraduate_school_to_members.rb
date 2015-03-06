class AddUndergraduateSchoolToMembers < ActiveRecord::Migration
  def change
    add_column :members, :undergraduate_school, :string
    add_column :members, :gpa, :integer
    add_column :members, :gmat_score, :integer
    add_column :members, :hometown, :string
  end
end

class AddCommitToMembers < ActiveRecord::Migration
  def change
    add_column :members, :commitschool, :string
  end
end

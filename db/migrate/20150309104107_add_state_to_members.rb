class AddStateToMembers < ActiveRecord::Migration
  def change
    add_column :members, :state, :string
  end
end

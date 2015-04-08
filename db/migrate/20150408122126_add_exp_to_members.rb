class AddExpToMembers < ActiveRecord::Migration
  def change
    add_column :members, :exp, :string
  end
end

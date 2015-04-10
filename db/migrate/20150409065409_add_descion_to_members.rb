class AddDescionToMembers < ActiveRecord::Migration
  def change
    add_column :members, :descion, :string
  end
end

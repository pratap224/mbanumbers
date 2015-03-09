class AddFriendToMembers < ActiveRecord::Migration
  def change
    add_column :members, :friend, :string
  end
end

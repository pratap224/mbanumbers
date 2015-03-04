class RenameColumnUserIdToMemberId < ActiveRecord::Migration
  def change
  	rename_column :topics, :user_id, :member_id
  	rename_column :posts, :user_id, :member_id
  end
end

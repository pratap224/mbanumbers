class ChangeColumnusertomember < ActiveRecord::Migration
  def change
  	rename_column :stuffs, :user_id, :member_id
  end
end

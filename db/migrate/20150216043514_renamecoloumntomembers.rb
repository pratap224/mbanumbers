class Renamecoloumntomembers < ActiveRecord::Migration
  def change
  	rename_column :members, :password, :password_hash
  end
end

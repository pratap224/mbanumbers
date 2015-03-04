class ChangeColumnname < ActiveRecord::Migration
  def change
  	rename_column :schools, :Forbes, :forbes
  end
end

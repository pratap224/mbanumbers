class Addinterviewtoapplication < ActiveRecord::Migration
  def change
  	add_column :applications, :interview, :string
  end
end

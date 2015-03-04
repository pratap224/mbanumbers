class Changedesciontoapplication < ActiveRecord::Migration
  def change
  	change_column :applications, :descion, 'date USING CAST(descion AS date)'
  end
end

class Changecompletetoapplication < ActiveRecord::Migration
  def change
  	change_column :applications, :complete, 'date USING CAST(complete AS date)'
  end
end

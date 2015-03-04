class Recivedchangetoapplication < ActiveRecord::Migration
  def change
  	change_column :applications, :received, 'date USING CAST(received AS date)'
  end
end

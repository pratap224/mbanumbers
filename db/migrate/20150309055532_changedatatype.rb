class Changedatatype < ActiveRecord::Migration
  def change
  	change_column :members, :gmat_score, :decimal
  end
end

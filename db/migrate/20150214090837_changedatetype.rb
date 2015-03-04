class Changedatetype < ActiveRecord::Migration
  def change

   change_column :members, :year, :string
  
  end
end

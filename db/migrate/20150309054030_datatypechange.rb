class Datatypechange < ActiveRecord::Migration
  def change
  	change_column :members, :gpa, :decimal
  end
end

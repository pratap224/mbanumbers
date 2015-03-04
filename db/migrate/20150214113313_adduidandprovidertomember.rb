class Adduidandprovidertomember < ActiveRecord::Migration
  def change
  	add_column :members, :uid, :string
  	add_column :members, :provider, :string
  end
end

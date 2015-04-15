class CreateUcolleges < ActiveRecord::Migration
  def change
    create_table :ucolleges do |t|
      t.string :college
      t.integer :state_id

      t.timestamps
    end
  end
end

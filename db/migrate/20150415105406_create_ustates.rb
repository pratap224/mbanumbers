class CreateUstates < ActiveRecord::Migration
  def change
    create_table :ustates do |t|
      t.string :states

      t.timestamps
    end
  end
end

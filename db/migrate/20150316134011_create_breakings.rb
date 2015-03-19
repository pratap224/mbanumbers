class CreateBreakings < ActiveRecord::Migration
  def change
    create_table :breakings do |t|
      t.string :title
      t.text :description

      t.timestamps
    end
  end
end

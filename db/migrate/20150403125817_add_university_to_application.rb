class AddUniversityToApplication < ActiveRecord::Migration
  def change
    add_column :applications, :university, :string
  end
end

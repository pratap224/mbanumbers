class CreateApplications < ActiveRecord::Migration
  def change
    create_table :applications do |t|
      t.string :school
      t.string :status
      t.string :application_type
      t.string :program
      t.date :interviewdate
      t.string :choice
      t.string :seat
      t.string :received
      t.string :complete
      t.string :descion
      t.string :scholarship

      t.timestamps
    end
  end
end

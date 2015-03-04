class CreateOutboxes < ActiveRecord::Migration
  def change
    create_table :outboxes do |t|
      t.string :name
      t.string :subject
      t.string :message

      t.timestamps
    end
  end
end

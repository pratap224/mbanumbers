class CreateReplies < ActiveRecord::Migration
  def change
    create_table :replies do |t|
      t.integer :outbox_id
      t.string :message

      t.timestamps
    end
  end
end

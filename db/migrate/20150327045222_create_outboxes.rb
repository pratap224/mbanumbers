class CreateOutboxes < ActiveRecord::Migration
  def change
    create_table :outboxes do |t|
      t.string :name
      t.string :subject
      t.text :message
      t.integer :member_id
      t.string :from
      t.boolean :sender_at
      t.boolean :receiver_at

      t.timestamps
    end
  end
end

class AddSenderAtToOutboxes < ActiveRecord::Migration
  def change
    add_column :outboxes, :sender_at, :boolean
    add_column :outboxes, :receiver_at, :boolean
  end
end

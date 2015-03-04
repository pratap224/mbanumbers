class AddFromToOutboxes < ActiveRecord::Migration
  def change
    add_column :outboxes, :from, :string
  end
end

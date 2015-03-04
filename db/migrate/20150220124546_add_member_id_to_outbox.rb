class AddMemberIdToOutbox < ActiveRecord::Migration
  def change
    add_column :outboxes, :member_id, :integer
  end
end

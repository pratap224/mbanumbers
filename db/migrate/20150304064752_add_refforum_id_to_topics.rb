class AddRefforumIdToTopics < ActiveRecord::Migration
  def change
    add_column :topics, :refforum_id, :integer
  end
end

class AddDescriptionToRefineryAnnouncements < ActiveRecord::Migration
  def change
    add_column :refinery_announcements, :description, :string
  end
end

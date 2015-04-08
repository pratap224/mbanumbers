class ChangeDatatypeToMembers < ActiveRecord::Migration
  def change



change_column :members, :gmat_score, :integer
change_column :members, :experience, :string


  end
end

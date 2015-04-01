class ChangeDatatypeToMembers < ActiveRecord::Migration
  def change



change_column :members, :gmat_score, :integer


  end
end

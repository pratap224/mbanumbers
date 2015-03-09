class AddQuestionToMembers < ActiveRecord::Migration
  def change
    add_column :members, :question, :string
  end
end

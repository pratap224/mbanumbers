class CreateSchools < ActiveRecord::Migration
  def change
    create_table :schools do |t|
      t.string :business_school
      t.string :university
      t.string :state
      t.string :city
      t.integer :US_News_Ranking
      t.integer :BW
      t.integer :Forbes
      t.integer :Ec
      t.integer :FT
      t.integer :AE
      t.integer :CNN
      t.integer :BI
      t.integer :ARWU

      t.timestamps
    end
  end
end

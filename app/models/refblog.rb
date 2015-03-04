class Refblog < Refinery::Core::BaseModel
  self.table_name = 'refinery_blogposts'
  has_many :myadvices
end
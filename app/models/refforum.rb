class Refforum < Refinery::Core::BaseModel
  self.table_name = 'refinery_forums'
  has_many :topics, :dependent => :destroy
 default_scope { order('created_at DESC') }
  # attr_accessible :title, :photo_id, :created_at
end

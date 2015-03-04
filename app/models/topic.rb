class Topic < ActiveRecord::Base
	belongs_to :forum
	has_many :posts, :dependent => :destroy
	belongs_to :member
	default_scope { order('created_at DESC') }
end

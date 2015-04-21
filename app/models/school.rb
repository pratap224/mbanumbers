class School < ActiveRecord::Base
	dragonfly_accessor :image
	belongs_to :state
end
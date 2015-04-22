class School < ActiveRecord::Base
	dragonfly_accessor :image
	validates :school, :presence => true
end
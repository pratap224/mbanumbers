class School < ActiveRecord::Base
	dragonfly_accessor :image
	belongs_to :state

	validates :school, presence: true



end

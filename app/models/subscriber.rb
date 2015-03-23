class Subscriber < ActiveRecord::Base
	validates :email, presence: true
	validates :email, format: /@/
end

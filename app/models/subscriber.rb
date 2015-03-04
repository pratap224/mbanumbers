class Subscriber < ActiveRecord::Base
	validates :email, format: /@/
end

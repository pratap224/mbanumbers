class Member < ActiveRecord::Base
	include BCrypt
	validates :username, presence: true
	validates :username, uniqueness: true
	validates :username, length: {maximum: 30, minimum: 6 }
	validates :email, presence: true
	validates :email, format: /@/
	validate :username, :uniqueness => {:case_sensitive => false}
	dragonfly_accessor :image
	has_one :stuff
	has_many :posts
	has_many :topics

	def self.from_omniauth(auth)
		where(provider: auth.provider, uid: auth.uid).first_or_create do |member|
			member.provider = auth.provider 
			member.uid      = auth.uid
			member.name = auth.info.name
			member.email = auth.info.email
			member.save
		end
	end

	def password
    	@password ||= Password.new(password_hash)
 	end
	def password=(new_password)
    	@password = Password.create(new_password)
    	self.password_hash = @password
 	end
 	def self.authenticate(username, password)
 		user = self.find_by_email(username) || self.find_by_username(username)
 		unless user.nil?
 			user.id if BCrypt::Password.new(user.password) == password && user.active
 		end
 	end


end
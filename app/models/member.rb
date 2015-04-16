class Member < ActiveRecord::Base
	include BCrypt
	validates :username, presence: true
	validates :username, uniqueness: true
	validates :username, length: {maximum: 30, minimum: 6 }
	validates :email, presence: true
	validates :email, uniqueness: true
	validates :email, format: /@/
	validate :username, :uniqueness => {:case_sensitive => false}
	validates :gpa, presence: true
	validates_numericality_of :gpa , :less_than_or_equal_to=>4.00, :greater_than_or_equal_to=>1.00
    validates :gmat_score, presence: true
	validates_numericality_of :gmat_score , :less_than_or_equal_to=>800, :greater_than_or_equal_to=>200
	# validates :password, :presence =>true,
 #                    :length => { :minimum => 5, :maximum => 40 },
 #                    :confirmation =>true
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
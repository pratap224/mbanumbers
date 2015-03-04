module HomepageHelper
	def getpath id
		@dynamic = Refphoto.find(id).image_uid unless id.nil?
		@val = "/system/refinery/images/#{@dynamic}"
	end
end

Rails.application.config.middleware.use OmniAuth::Builder do
  
  provider :facebook, "1563360190578255", "4f6de4495890ae536e044379acf8feca"
  provider :twitter, "EIBn524i2fmRolpsHhK3BAm9s", "pBC2jFo0ui9CvPlOfp2aGAV6kzcUZHTp2Jhc0K4L1ekbMH3wJu"
  
 provider :gplus, "162789301578-tgdgcmb9svqlbivl5ud8ljjh32rf6j1p.apps.googleusercontent.com", "kHnEGWgcADX8vCaHSwimZRQM", scope: 'plus.login'
  provider :linkedin, "78xb135uzh9mdj", "OE0RDMTroTYMvS0U", :scope => 'r_fullprofile r_emailaddress r_network'
end
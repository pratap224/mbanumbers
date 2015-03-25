Rails.application.config.middleware.use OmniAuth::Builder do
  
  provider :facebook, "743165642457456", "76712f8f1b264da60f15556403f4ef32"
  provider :twitter, "EIBn524i2fmRolpsHhK3BAm9s", "pBC2jFo0ui9CvPlOfp2aGAV6kzcUZHTp2Jhc0K4L1ekbMH3wJu"
  
 provider :gplus, "162789301578-tgdgcmb9svqlbivl5ud8ljjh32rf6j1p.apps.googleusercontent.com", "kHnEGWgcADX8vCaHSwimZRQM", scope: 'plus.login'
  provider :linkedin, "78xb135uzh9mdj", "OE0RDMTroTYMvS0U", :scope => 'r_fullprofile r_emailaddress r_network'
end
# This file should contain all the record creation needed to seed the database with its default values.
# The data can then be loaded with the rake db:seed (or created alongside the db with db:setup).
#
# Examples:
#
#   cities = City.create([{ name: 'Chicago' }, { name: 'Copenhagen' }])
#   Mayor.create(name: 'Emanuel', city: cities.first)

# Added by Refinery CMS Pages extension
Refinery::Pages::Engine.load_seed



# Added by Refinery CMS Blogposts extension
Refinery::Blogposts::Engine.load_seed

# Added by Refinery CMS Testimonials extension
Refinery::Testimonials::Engine.load_seed

# Added by Refinery CMS Forums extension
Refinery::Forums::Engine.load_seed



# Added by Refinery CMS Newcasts extension
Refinery::Newcasts::Engine.load_seed

# Added by Refinery CMS Announcements extension

# Added by Refinery CMS Announces extension
Refinery::Announces::Engine.load_seed

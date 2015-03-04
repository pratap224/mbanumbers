
FactoryGirl.define do
  factory :blogpost, :class => Refinery::Blogposts::Blogpost do
    sequence(:title) { |n| "refinery#{n}" }
  end
end


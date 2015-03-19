
FactoryGirl.define do
  factory :newcast, :class => Refinery::Newcasts::Newcast do
    sequence(:title) { |n| "refinery#{n}" }
  end
end


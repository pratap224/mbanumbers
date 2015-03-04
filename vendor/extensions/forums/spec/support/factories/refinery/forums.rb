
FactoryGirl.define do
  factory :forum, :class => Refinery::Forums::Forum do
    sequence(:name) { |n| "refinery#{n}" }
  end
end


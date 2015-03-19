
FactoryGirl.define do
  factory :breaking, :class => Refinery::Breakings::Breaking do
    sequence(:title) { |n| "refinery#{n}" }
  end
end


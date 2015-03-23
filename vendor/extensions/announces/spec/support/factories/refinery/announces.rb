
FactoryGirl.define do
  factory :announce, :class => Refinery::Announces::Announce do
    sequence(:title) { |n| "refinery#{n}" }
  end
end


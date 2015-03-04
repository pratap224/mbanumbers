
FactoryGirl.define do
  factory :testimonial, :class => Refinery::Testimonials::Testimonial do
    sequence(:name) { |n| "refinery#{n}" }
  end
end


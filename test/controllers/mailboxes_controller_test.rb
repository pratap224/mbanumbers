require 'test_helper'

class MailboxesControllerTest < ActionController::TestCase
  test "should get mailbox" do
    get :mailbox
    assert_response :success
  end

  test "should get outbox" do
    get :outbox
    assert_response :success
  end

  test "should get newest" do
    get :newest
    assert_response :success
  end

  test "should get show" do
    get :show
    assert_response :success
  end

  test "should get new" do
    get :new
    assert_response :success
  end

  test "should get save" do
    get :save
    assert_response :success
  end

end

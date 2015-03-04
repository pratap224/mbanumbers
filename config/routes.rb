  Rails.application.routes.draw do

  get 'mailboxes/mailbox'
  get 'mailboxes/show/:id' => "mailboxes#show", :as => 'mailboxes_show'
  post 'mailboxes/compose'
  get 'mailboxes/destroy/:id' => 'mailboxes#destroy', :as => 'mailboxes_destroy'
  get 'mailboxes/new'
  post 'mailboxes/save'
  get 'mailboxes/outbox'
  get 'mailboxes/newest'
  get 'mailboxes/outboxdel/:id' => 'mailboxes#outboxdel', :as => 'mailboxes_outboxdel'

  get 'schools/index', :as => 'schools'
  get 'schools/profile'
  get 'schools/name'
  get 'schools/search'
  post 'schools/create'
  post 'profile/stuff' => 'profile#stuffupdate', :as => 'stuffs'
  patch 'profile/stuff' => 'profile#stuffupdate', :as => 'stuff'

  get 'schools/edit/:id' => 'schools#edit',  as: 'schools_edit'
  patch 'schools/update/:id' => 'schools#update', as: 'schools_update'
  get 'schools/destroy/:id' => 'schools#destroy', :as => 'schools_destroy'
  get 'schools/ranking'
  get 'schools/state'
  get 'schools/statelist'
  get 'forums/index'
  get 'forums/:id/topics' => 'forums#topics', :as => 'forum_topic'
  post 'forums/topics/new' => 'forums#topic_new', :as => 'topic_new'
  get 'forums/topics/:topic/posts' => 'forums#posts', :as => 'forum_posts'
  post 'forums/posts/new' => 'forums#post_new', :as => 'post_new'
  get 'forums/new'
  # get 'forums/:id' => 'forums#show'
  get 'forums/post/:id' => 'forums#post', as: 'forum_post'
  post 'forums/create'
  post 'forums/postcreate'

  mount Refinery::Core::Engine, at: Refinery::Core.mounted_path
   

  get 'authentications/index'

  get 'members/index' #(signuup)
  get 'members/signup'
  post 'members/create'
  #get 'members/login'
  get 'members/verifieamil/:token' => 'members#verifiemail', as: 'member_verify'
  root 'homepage#index'

  get 'homepage/create'
  
  get 'myadvices/myadvice'
  get 'myadvice/blog/:id' => 'myadvices#blogdata', as: 'myadvices_blog' 
  get 'myadvices/new'
  post 'myadvices/create'
   # get 'admin/show/:id' => 'admins#show', as: 'show_admin'
  
  get 'auth/:provider/callback' => 'authentications#create' 
  get 'logout' => 'authentications#destroy'

  get 'members/index'
  
  post 'subscribes/subscribe' 
  get 'subscribes/confirm/:token' => 'subscribes#confirm'

  post 'subscribes/submitcontact'
  get 'subscribes/contactus'

  #--------profile routes-------------#
  get 'profile/index' => 'profile#index', :as => 'profile_index'
  get 'profile/login'
  post 'profile/create'
  get 'profile/mailbox'
  get 'profile/show/:id' => "profile#show", :as => 'profile_show'
  post 'profile/compose'
  get 'profile/destroy/:id' => 'profile#destroy', :as => 'profile_destroy'
  get 'profile/new'
  post 'profile/save'

  get 'profile/settings'
  post 'profile/profilecreate'
  get 'profile/chnagepwd'
  post 'profile/changepwdcreate'
  get 'profile/forgotpassword'
  post 'profile/createforgotpassword'
  get 'profile/updatepassword/:token' => 'profile#updatepassword', :as => 'profile_updatepwd'
  post 'profile/createupdatepwd'
  # resources :schools

  get 'member/:username' => 'profile#staticprofile', :as => 'static_profile'
  get 'profiles/all' => 'profile#staticbulk'
  get 'user/bookmark/:currentuserid/:bookmarkuserid' => 'profile#bookmark', :as => 'member_bookmark'
  get 'user/remove/:id' => 'profile#remove', :as => 'user_remove'
  
  post 'comments/create' => 'profile#commentcreate', :as => 'comment_new'

  get 'profile/topusers' => 'profile#topusers', :as => 'topusers'
  
  get 'profile/bookmarklist'
  get 'bookmark/remove/:id' => 'profile#removebookmarklist', :as => 'booklist_remove'

  get 'schools/schoolappinfo/:schoolname' => 'schools#schoolappinfo', :as => 'school_appinfo'
end



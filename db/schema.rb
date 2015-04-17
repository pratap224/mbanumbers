# encoding: UTF-8
# This file is auto-generated from the current state of the database. Instead
# of editing this file, please use the migrations feature of Active Record to
# incrementally modify your database, and then regenerate this schema definition.
#
# Note that this schema.rb definition is the authoritative source for your
# database schema. If you need to create the application database on another
# system, you should be using db:schema:load, not running all the migrations
# from scratch. The latter is a flawed and unsustainable approach (the more migrations
# you'll amass, the slower it'll run and the greater likelihood for issues).
#
# It's strongly recommended that you check this file into your version control system.

ActiveRecord::Schema.define(version: 20150415105406) do

  # These are extensions that must be enabled in order to support this database
  enable_extension "plpgsql"

  create_table "announces", force: true do |t|
    t.string   "title"
    t.text     "description"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "applications", force: true do |t|
    t.string   "school"
    t.string   "status"
    t.string   "application_type"
    t.string   "program"
    t.date     "interviewdate"
    t.string   "choice"
    t.string   "seat"
    t.date     "received"
    t.date     "complete"
    t.date     "descion"
    t.string   "scholarship"
    t.datetime "created_at"
    t.datetime "updated_at"
    t.integer  "user_id"
    t.string   "university"
    t.string   "interview"
  end

  create_table "bookmarks", force: true do |t|
    t.integer  "currentuserid"
    t.integer  "bookmarkuserid"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "breakings", force: true do |t|
    t.string   "title"
    t.text     "description"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "colleges", force: true do |t|
    t.string   "college"
    t.integer  "state_id"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "comments", force: true do |t|
    t.string   "title"
    t.text     "comment"
    t.integer  "user_id"
    t.datetime "created_at"
    t.datetime "updated_at"
    t.integer  "target_id"
  end

  create_table "contacts", force: true do |t|
    t.string   "name"
    t.string   "email"
    t.string   "subject"
    t.text     "message"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "forums", force: true do |t|
    t.string   "name"
    t.text     "description"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "likes", force: true do |t|
    t.integer  "cuser_id"
    t.integer  "puser_id"
    t.integer  "count"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "members", force: true do |t|
    t.string   "name"
    t.string   "email"
    t.integer  "zipcode"
    t.string   "year"
    t.string   "password_hash"
    t.boolean  "active"
    t.datetime "created_at"
    t.datetime "updated_at"
    t.string   "token"
    t.string   "uid"
    t.string   "provider"
    t.string   "username"
    t.string   "image_uid"
    t.string   "image_name"
    t.string   "undergraduate_school"
    t.decimal  "gpa"
    t.integer  "gmat_score"
    t.string   "hometown"
    t.string   "state"
    t.string   "question"
    t.string   "friend"
    t.string   "status"
    t.integer  "experience"
    t.string   "commitschool"
    t.string   "exp"
    t.string   "descion"
  end

  create_table "myadvices", force: true do |t|
    t.string   "title"
    t.string   "comment"
    t.integer  "post_id"
    t.integer  "member_id"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "outboxes", force: true do |t|
    t.string   "name"
    t.string   "subject"
    t.text     "message"
    t.integer  "member_id"
    t.string   "from"
    t.boolean  "sender_at"
    t.boolean  "receiver_at"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "posts", force: true do |t|
    t.text     "content"
    t.datetime "created_at"
    t.datetime "updated_at"
    t.integer  "topic_id"
    t.integer  "member_id"
  end

  create_table "rasts", force: true do |t|
    t.string   "name"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "refinery_announcements", force: true do |t|
    t.string   "title"
    t.integer  "photo_id"
    t.integer  "position"
    t.datetime "created_at"
    t.datetime "updated_at"
    t.string   "description"
  end

  create_table "refinery_announces", force: true do |t|
    t.string   "title"
    t.text     "description"
    t.integer  "position"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "refinery_blogposts", force: true do |t|
    t.string   "title"
    t.integer  "photo_id"
    t.text     "description"
    t.integer  "position"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "refinery_breakings", force: true do |t|
    t.string   "title"
    t.text     "description"
    t.integer  "position"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "refinery_forums", force: true do |t|
    t.string   "name"
    t.text     "description"
    t.integer  "position"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "refinery_images", force: true do |t|
    t.string   "image_mime_type"
    t.string   "image_name"
    t.integer  "image_size"
    t.integer  "image_width"
    t.integer  "image_height"
    t.string   "image_uid"
    t.datetime "created_at"
    t.datetime "updated_at"
    t.string   "image_title"
    t.string   "image_alt"
  end

  create_table "refinery_newcasts", force: true do |t|
    t.string   "title"
    t.text     "description"
    t.string   "url"
    t.integer  "position"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "refinery_news", force: true do |t|
    t.string   "title"
    t.text     "description"
    t.integer  "position"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "refinery_page_part_translations", force: true do |t|
    t.integer  "refinery_page_part_id", null: false
    t.string   "locale",                null: false
    t.datetime "created_at"
    t.datetime "updated_at"
    t.text     "body"
  end

  add_index "refinery_page_part_translations", ["locale"], name: "index_refinery_page_part_translations_on_locale", using: :btree
  add_index "refinery_page_part_translations", ["refinery_page_part_id"], name: "index_refinery_page_part_translations_on_refinery_page_part_id", using: :btree

  create_table "refinery_page_parts", force: true do |t|
    t.integer  "refinery_page_id"
    t.string   "title"
    t.text     "body"
    t.integer  "position"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  add_index "refinery_page_parts", ["id"], name: "index_refinery_page_parts_on_id", using: :btree
  add_index "refinery_page_parts", ["refinery_page_id"], name: "index_refinery_page_parts_on_refinery_page_id", using: :btree

  create_table "refinery_page_translations", force: true do |t|
    t.integer  "refinery_page_id", null: false
    t.string   "locale",           null: false
    t.datetime "created_at"
    t.datetime "updated_at"
    t.string   "title"
    t.string   "custom_slug"
    t.string   "menu_title"
    t.string   "slug"
  end

  add_index "refinery_page_translations", ["locale"], name: "index_refinery_page_translations_on_locale", using: :btree
  add_index "refinery_page_translations", ["refinery_page_id"], name: "index_refinery_page_translations_on_refinery_page_id", using: :btree

  create_table "refinery_pages", force: true do |t|
    t.integer  "parent_id"
    t.string   "path"
    t.string   "slug"
    t.string   "custom_slug"
    t.boolean  "show_in_menu",        default: true
    t.string   "link_url"
    t.string   "menu_match"
    t.boolean  "deletable",           default: true
    t.boolean  "draft",               default: false
    t.boolean  "skip_to_first_child", default: false
    t.integer  "lft"
    t.integer  "rgt"
    t.integer  "depth"
    t.string   "view_template"
    t.string   "layout_template"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  add_index "refinery_pages", ["depth"], name: "index_refinery_pages_on_depth", using: :btree
  add_index "refinery_pages", ["id"], name: "index_refinery_pages_on_id", using: :btree
  add_index "refinery_pages", ["lft"], name: "index_refinery_pages_on_lft", using: :btree
  add_index "refinery_pages", ["parent_id"], name: "index_refinery_pages_on_parent_id", using: :btree
  add_index "refinery_pages", ["rgt"], name: "index_refinery_pages_on_rgt", using: :btree

  create_table "refinery_resources", force: true do |t|
    t.string   "file_mime_type"
    t.string   "file_name"
    t.integer  "file_size"
    t.string   "file_uid"
    t.string   "file_ext"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "refinery_roles", force: true do |t|
    t.string "title"
  end

  create_table "refinery_roles_users", id: false, force: true do |t|
    t.integer "user_id"
    t.integer "role_id"
  end

  add_index "refinery_roles_users", ["role_id", "user_id"], name: "index_refinery_roles_users_on_role_id_and_user_id", using: :btree
  add_index "refinery_roles_users", ["user_id", "role_id"], name: "index_refinery_roles_users_on_user_id_and_role_id", using: :btree

  create_table "refinery_testimonials", force: true do |t|
    t.string   "name"
    t.string   "role"
    t.text     "content"
    t.integer  "position"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "refinery_user_plugins", force: true do |t|
    t.integer "user_id"
    t.string  "name"
    t.integer "position"
  end

  add_index "refinery_user_plugins", ["name"], name: "index_refinery_user_plugins_on_name", using: :btree
  add_index "refinery_user_plugins", ["user_id", "name"], name: "index_refinery_user_plugins_on_user_id_and_name", unique: true, using: :btree

  create_table "refinery_users", force: true do |t|
    t.string   "username",               null: false
    t.string   "email",                  null: false
    t.string   "encrypted_password",     null: false
    t.datetime "current_sign_in_at"
    t.datetime "last_sign_in_at"
    t.string   "current_sign_in_ip"
    t.string   "last_sign_in_ip"
    t.integer  "sign_in_count"
    t.datetime "remember_created_at"
    t.string   "reset_password_token"
    t.datetime "reset_password_sent_at"
    t.datetime "created_at"
    t.datetime "updated_at"
    t.string   "slug"
    t.string   "full_name"
  end

  add_index "refinery_users", ["id"], name: "index_refinery_users_on_id", using: :btree
  add_index "refinery_users", ["slug"], name: "index_refinery_users_on_slug", using: :btree

  create_table "replies", force: true do |t|
    t.integer  "outbox_id"
    t.string   "message"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "schools", force: true do |t|
    t.string   "business_school"
    t.string   "university"
    t.string   "name"
    t.string   "city"
    t.integer  "US_News_Ranking"
    t.integer  "BW"
    t.integer  "forbes"
    t.integer  "Ec"
    t.integer  "FT"
    t.integer  "AE"
    t.integer  "CNN"
    t.integer  "BI"
    t.integer  "ARWU"
    t.datetime "created_at"
    t.datetime "updated_at"
    t.string   "image_uid"
    t.string   "image_name"
    t.integer  "state_id"
  end

  create_table "seo_meta", force: true do |t|
    t.integer  "seo_meta_id"
    t.string   "seo_meta_type"
    t.string   "browser_title"
    t.text     "meta_description"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  add_index "seo_meta", ["id"], name: "index_seo_meta_on_id", using: :btree
  add_index "seo_meta", ["seo_meta_id", "seo_meta_type"], name: "id_type_index_on_seo_meta", using: :btree

  create_table "states", force: true do |t|
    t.string   "name"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "stuffs", force: true do |t|
    t.integer  "member_id"
    t.string   "ugschool"
    t.float    "gpa"
    t.float    "gmat"
    t.string   "hometown"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "subscribers", force: true do |t|
    t.string   "email"
    t.string   "token"
    t.boolean  "activation"
    t.datetime "created_at", null: false
    t.datetime "updated_at", null: false
  end

  create_table "topics", force: true do |t|
    t.string   "name"
    t.integer  "last_poster_id"
    t.datetime "last_post_at"
    t.datetime "created_at"
    t.datetime "updated_at"
    t.integer  "forum_id"
    t.integer  "member_id"
    t.integer  "refforum_id"
  end

  create_table "ucolleges", force: true do |t|
    t.string   "college"
    t.integer  "state_id"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

  create_table "users", force: true do |t|
    t.string   "email"
    t.string   "password_hash"
    t.string   "first_name"
    t.string   "last_name"
    t.datetime "created_at",    null: false
    t.datetime "updated_at",    null: false
    t.string   "provider"
    t.string   "uid"
  end

  create_table "ustates", force: true do |t|
    t.string   "states"
    t.datetime "created_at"
    t.datetime "updated_at"
  end

end

<?php

defined('BASEPATH') or exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: DatabaseMigrate.php
 *  Path: application/controllers/DatabaseMigrate.php
 *  Description: Default Database setup
 *
 *  Run Syntex: php index.php services/DatabaseMigrate
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         22/09/2020              Created
 */
if (!class_exists('DatabaseMigrate')) {

	class DatabaseMigrate extends CI_Controller
	{

		public function __construct()
		{
			parent::__construct();
			$this->load->library('CliTools', null, 'cli');
			$this->cli->is_accessible();
			$this->load->dbforge();
		}

		public function index()
		{
			echo "Start Creating Tables....\n\n";
			$this->table_users(true);
			$this->table_system_config(true);
			$this->table_access_token(true);
			$this->table_blogs(true);
			$this->table_posts(true);
			$this->table_category(true);
			$this->table_tags(true);
			$this->table_post_tags(true);
			$this->table_post_hashtag(true);
			$this->table_adsize(true);
			$this->table_adgroup(true);
			$this->table_ads(true);
			$this->table_uploads(true);
			$this->table_themes(true);
			$this->table_feeder(true);
			$this->table_country(true);
			$this->table_user_role(true);
			$this->table_access_groups(true);
			$this->table_access(true);
			$this->table_access_role(true);
		}

		public function table_users($drop = false)
		{
			$this->dbforge->add_field(array(
				'id' => array('type' => 'BIGINT', 'null' => false, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'Unique user id'),
				'gid' => array('type' => 'VARCHAR', 'constraint' => 32, 'default' => '', 'comment' => 'Google user id'),
				'first_name' => array('type' => 'VARCHAR', 'constraint' => 32, 'null' => false, 'default' => '', 'comment' => 'User First Name'),
				'middle_name' => array('type' => 'VARCHAR', 'constraint' => 32, 'null' => false, 'default' => '', 'comment' => 'User Middle Name'),
				'last_name' => array('type' => 'VARCHAR', 'constraint' => 32, 'null' => false, 'default' => '', 'comment' => 'User Ser Name'),
				'display_name' => array('type' => 'VARCHAR', 'constraint' => 128, 'null' => false, 'default' => '', 'comment' => 'Full name of user publicly available'),
				'email' => array('type' => 'VARCHAR', 'constraint' => 64, 'null' => false, 'default' => '', 'unique' => true, 'comment' => 'User Email Address'),
				'email_v' => array('type' => 'BOOLEAN', 'null' => false, 'default' => false, 'comment' => 'Is user email address verified.'),
				'username' => array('type' => 'VARCHAR', 'constraint' => 64, 'null' => false, 'default' => '', 'unique' => true, 'comment' => 'User account Username'),
				'password' => array('type' => 'VARCHAR', 'constraint' => 64, 'null' => false, 'comment' => 'User account Password'),
				'reset' => array('type' => 'SMALLINT', 'unsigned' => true, 'default' => 0, 'comment' => 'How much time password has been changed?'),
				'pic_url' => array('type' => 'VARCHAR', 'constraint' => 256, 'null' => false, 'default' => '', 'comment' => 'image url of user'),
				'user_role' => array('type' => 'SMALLINT', 'unsigned' => true, 'null' => false, 'comment' => 'User Role eg: 1->Super User, 2-> Moderator Foreign Key: kdb_user_role->id'),
				'state' => array('type' => 'TINYINT', 'unsigned' => true, 'null' => false, 'default' => 0, 'comment' => 'Status of user account. eg: 0->pending, 1->Active, 2-> deactive, 3-> Blocked, 4-> Delete'),
				"reg_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'when user registered'",
				"last_active DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'When user active'",
			));
			$this->dbforge->add_key('id', true);
			$this->create_table($drop, "users");
		}

		public function table_system_config($drop = false)
		{
			$this->dbforge->add_field(array(
				'id' => array('type' => 'BIGINT', 'null' => false, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'Unique id'),
				'blog_id' => array('type' => 'BIGINT', 'unsigned' => true, 'null' => false, 'default' => 0, 'comment' => 'Blog id, Foreign Key: kdb_blogs->id'),
				'user_id' => array('type' => 'BIGINT', 'unsigned' => true, 'null' => false, 'default' => 0, 'comment' => 'For which user this setting saved'),
				'setting' => array('type' => 'VARCHAR', 'constraint' => 64, 'null' => false, 'comment' => 'Fixed name of setting in config'),
				'value' => array('type' => 'TEXT', 'null' => false, 'comment' => 'Multiple format will be saved like Integer, Float, String etc'),
				"create_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'When this setting added in database'",
				"update_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'When this setting updated'",
			));
			$this->dbforge->add_key('id', true);
			$this->dbforge->add_key(array('blog_id', 'user_id', 'setting'));
			$this->create_table($drop, "system_config", $this->table_system_config_data());
		}

		public function table_system_config_data()
		{
			return array(
				"setting" => "_db_config_default_user_role",
				"value" => 1,
			);
		}

		public function table_access_token($drop = false)
		{
			$this->dbforge->add_field(array(
				'id' => array('type' => 'BIGINT', 'null' => false, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'Unique id'),
				'user_id' => array('type' => 'BIGINT', 'unsigned' => true, 'null' => false, 'default' => 0, 'unique' => true, 'comment' => 'User who have google access, Foreign Key: kdb_users->id'),
				'access_token' => array('type' => 'TEXT', 'null' => false, 'default' => '', 'comment' => 'This is access token used for create article'),
				'refresh_token' => array('type' => 'VARCHAR', 'constraint' => 512, 'null' => false, 'comment' => 'This is used for update access token'),
				'valid_access' => array('type' => 'BOOLEAN', 'null' => false, 'default' => false, 'comment' => 'TRUE/FALSE'),
			));
			$this->dbforge->add_key('id', true);
			$this->create_table($drop, "access_token");
		}

		public function table_blogs($drop = false)
		{
			$this->dbforge->add_field(array(
				'id' => array('type' => 'BIGINT', 'null' => false, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'Unique blog id'),
				'name' => array('type' => 'VARCHAR', 'constraint' => 128, 'null' => false, 'comment' => 'Blog Name'),
				'username' => array('type' => 'VARCHAR', 'constraint' => 64, 'null' => false, 'unique' => true, 'comment' => 'Unique Blog Username'),
				'user_id' => array('type' => 'BIGINT', 'unsigned' => true, 'null' => false, 'default' => 0, 'comment' => 'User who create this blog, Foreign Key: kdb_users->id'),
				'cat_id' => array('type' => 'INT', 'unsigned' => true, 'null' => false, 'default' => 0, 'comment' => 'Blog category ID, Foreign Key: kdb_category->id '),
				'logo_url' => array('type' => 'VARCHAR', 'constraint' => 256, 'null' => false, 'default' => '', 'comment' => 'Blog logo url eg: sitelogo.png'),
				'metadesc' => array('type' => 'VARCHAR', 'constraint' => 256, 'null' => false, 'default' => '', 'comment' => 'Blog short description'),
				'status' => array('type' => 'TINYINT', 'unsigned' => true, 'null' => false, 'comment' => 'Status of blog account. eg: 0->pending, 1->Active, 2-> deactive, 3-> Spam, 4-> Blocked, 5-> Delete'),
				"create_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Time when this website added in database'",
				"update_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Time when this website details updated'",
			));
			$this->dbforge->add_key('id', true);
			$this->dbforge->add_key(array('username', 'user_id'));
			$this->create_table($drop, "blogs");
		}

		public function table_posts($drop = false)
		{
			$this->dbforge->add_field(array(
				'id' => array('type' => 'BIGINT', 'null' => false, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'Unique post id'),
				'blog_id' => array('type' => 'BIGINT', 'unsigned' => true, 'null' => false, 'comment' => 'Blog id, Foreign Key: kdb_blogs->id'),
				'user_id' => array('type' => 'BIGINT', 'unsigned' => true, 'null' => false, 'comment' => 'Who created this post, Foreign Key: kdb_users->id'),
				'post_key' => array('type' => 'VARCHAR', 'constraint' => 64, 'null' => false, 'unique' => true, 'comment' => 'Using time base algorithm generated Unique Post Key'),
				'title' => array('type' => 'VARCHAR', 'constraint' => 128, 'null' => false, 'comment' => 'Post title'),
				'content' => array('type' => 'TEXT', 'null' => false, 'comment' => 'Post content'),
				'slug' => array('type' => 'VARCHAR', 'constraint' => 256, 'null' => false, 'comment' => 'Post slug'),
				'reference' => array('type' => 'VARCHAR', 'constraint' => 256, 'null' => false, 'default' => '', 'comment' => 'Reference URL'),
				'thumbnail' => array('type' => 'VARCHAR', 'constraint' => 256, 'null' => false, 'default' => '', 'comment' => 'Post Thumbnail url'),
				'metadesc' => array('type' => 'VARCHAR', 'constraint' => 256, 'null' => false, 'default' => '', 'comment' => 'Post description'),
				'cat_id' => array('type' => 'INT', 'unsigned' => true, 'null' => false, 'default' => 0, 'comment' => 'Post category ID, Foreign Key: kdb_category->id '),
				'lang' => array('type' => 'VARCHAR', 'constraint' => 64, 'null' => false, 'comment' => 'Post Language'),
				'type' => array('type' => 'VARCHAR', 'constraint' => 16, 'null' => false, 'default' => 'post', 'comment' => 'Which type of post is this. Like Post, Video etc'),
				'info' => array('type' => 'VARCHAR', 'constraint' => 1024, 'null' => false, 'default' => '', 'comment' => 'Extra info of this post in json format'),
				'status' => array('type' => 'VARCHAR', 'constraint' => 16, 'null' => false, 'default' => 'draft', 'comment' => 'Status of post: draft/publish/delete'),
				"create_time DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Post create time'",
				"update_time DATETIME NOT NULL DEFAULT NOW() ON UPDATE NOW() COMMENT 'Time when this post details updated'",
			));
			$this->dbforge->add_key('id', true);
			$this->dbforge->add_key(array('blog_id', 'user_id', 'post_key', 'slug'));
			$this->create_table($drop, "posts");
		}

		public function table_category($drop = false)
		{
			$this->dbforge->add_field(array(
				'id' => array('type' => 'INT', 'null' => false, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'Unique id'),
				'name' => array('type' => 'VARCHAR', 'constraint' => 64, 'null' => false, 'comment' => 'Category name'),
				'slug' => array('type' => 'VARCHAR', 'constraint' => 64, 'null' => false, 'unique' => true, 'comment' => 'Category slug'),
				'parent_id' => array('type' => 'INT', 'unsigned' => true, 'null' => false, 'default' => 0, 'comment' => 'Catgory id for multi level caegory, Foreign Key: kdb_category->id'),
				'ctype' => array('type' => 'VARCHAR', 'constraint' => 16, 'null' => false, 'default' => 'user', 'comment' => 'Category Type user or system'),
				'user_id' => array('type' => 'BIGINT', 'unsigned' => true, 'null' => false, 'default' => 0, 'comment' => 'Who create this category, Foreign Key: kdb_users->id'),
				"create_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Time when this category added in database'",
				"update_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Time when this category details updated'",
			));
			$this->dbforge->add_key('id', true);
			$this->create_table($drop, "category", $this->table_category_data());
		}

		public function table_category_data()
		{
			return array(
				"name" => "Education",
				"slug" => "education",
				"ctype" => "system",
			);
		}

		public function table_tags($drop = false)
		{
			$this->dbforge->add_field(array(
				'id' => array('type' => 'BIGINT', 'null' => false, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'Tag Unique id'),
				'name' => array('type' => 'VARCHAR', 'constraint' => 128, 'null' => false, 'unique' => true, 'comment' => 'Tag name'),
			));
			$this->dbforge->add_key('id', true);
			$this->create_table($drop, "tags");
		}

		public function table_post_tags($drop = false)
		{
			$this->dbforge->add_field(array(
				'blog_id' => array('type' => 'BIGINT', 'unsigned' => true, 'null' => false, 'comment' => 'Blog related to tag post, Foreign Key: kdb_blogs->id'),
				'user_id' => array('type' => 'BIGINT', 'unsigned' => true, 'null' => false, 'comment' => 'Who created post, Foreign Key: kdb_users->id'),
				'post_id' => array('type' => 'BIGINT', 'unsigned' => true, 'null' => false, 'comment' => 'Post Related to tag, Foreign Key: kdb_posts->id'),
				'tag_id' => array('type' => 'BIGINT', 'unsigned' => true, 'null' => false, 'comment' => 'tag Id, Foreign Key: kdb_tags->id'),
				"create_time DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Tag added time'",
			));
			$this->dbforge->add_key(array('blog_id', 'user_id', 'post_id', 'tag_id'));
			$this->create_table($drop, "post_tags");
		}

		public function table_post_hashtag($drop = false)
		{
			$this->dbforge->add_field(array(
				'blog_id' => array('type' => 'BIGINT', 'unsigned' => true, 'null' => false, 'comment' => 'Blog related to tag post, Foreign Key: kdb_blogs->id'),
				'user_id' => array('type' => 'BIGINT', 'unsigned' => true, 'null' => false, 'comment' => 'Who created post, Foreign Key: kdb_users->id'),
				'post_id' => array('type' => 'BIGINT', 'unsigned' => true, 'null' => false, 'comment' => 'Post Related to hashtag, Foreign Key: kdb_posts->id'),
				'tag_id' => array('type' => 'BIGINT', 'unsigned' => true, 'null' => false, 'comment' => 'Hashtag Id, Foreign Key: kdb_tags->id'),
				"create_time DATETIME DEFAULT CURRENT_TIMESTAMP COMMENT 'Hashtag added time'",
			));
			$this->dbforge->add_key(array('blog_id', 'user_id', 'post_id', 'tag_id'));
			$this->create_table($drop, "post_hashtag");
		}

		public function table_adsize($drop = false)
		{
			$this->dbforge->add_field(array(
				'id' => array('type' => 'INT', 'null' => false, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'Unique id'),
				'user_id' => array('type' => 'BIGINT', 'unsigned' => true, 'null' => false, 'default' => 0, 'comment' => 'Who create this adsize, Foreign Key: kdb_users->id'),
				'name' => array('type' => 'VARCHAR', 'constraint' => 64, 'null' => false, 'comment' => 'AdSize name'),
				'width' => array('type' => 'BIGINT', 'unsigned' => true, 'null' => false, 'default' => 0, 'comment' => 'Adsize width'),
				'height' => array('type' => 'BIGINT', 'unsigned' => true, 'null' => false, 'default' => 0, 'comment' => 'Adsize height'),
				'sitekey' => array('type' => 'VARCHAR', 'constraint' => 64, 'null' => false, 'unique' => true, 'comment' => 'AdSize unique key'),
				"create_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Time when this adsize added in database'",
				"update_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Time when this adsize details updated'",
			));
			$this->dbforge->add_key('id', true);
			$this->create_table($drop, "adsize");
		}

		public function table_adgroup($drop = false)
		{
			$this->dbforge->add_field(array(
				'id' => array('type' => 'INT', 'null' => false, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'Unique id'),
				'blog_id' => array('type' => 'BIGINT', 'unsigned' => true, 'null' => false, 'default' => 0, 'comment' => 'Blog id, Foreign Key: kdb_blogs->id'),
				'user_id' => array('type' => 'BIGINT', 'unsigned' => true, 'null' => false, 'default' => 0, 'comment' => 'Who create this adgroup, Foreign Key: kdb_users->id'),
				'name' => array('type' => 'VARCHAR', 'constraint' => 64, 'null' => false, 'comment' => 'AdGroup name'),
				'platform' => array('type' => 'CHAR', 'constraint' => 2, 'null' => false, 'default' => 'a', 'comment' => 'AdGroup Device Platform'),
				'metadesc' => array('type' => 'VARCHAR', 'constraint' => 512, 'null' => false, 'comment' => 'AdGroup descriptions'),
				'adsize_id' => array('type' => 'INT', 'unsigned' => true, 'null' => false, 'comment' => 'Adsize id key Foreign Key: kdb_adsize->id'),
				'ads_count' => array('type' => 'INT', 'unsigned' => true, 'null' => false, 'default' => 0, 'comment' => 'Number of total ads in this group'),
				"create_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Time when this adgroup added in database'",
				"update_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Time when this adgroup details updated'",
			));
			$this->dbforge->add_key('id', true);
			$this->dbforge->add_key(array('blog_id', 'user_id', 'adsize_id'));
			$this->create_table($drop, "adgroup");
		}

		public function table_ads($drop = false)
		{
			$this->dbforge->add_field(array(
				'id' => array('type' => 'BIGINT', 'null' => false, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'Unique ads id'),
				'blog_id' => array('type' => 'BIGINT', 'unsigned' => true, 'null' => false, 'default' => 0, 'comment' => 'Blog id, Foreign Key: kdb_blogs->id'),
				'user_id' => array('type' => 'BIGINT', 'unsigned' => true, 'null' => false, 'default' => 0, 'comment' => 'Who create this ads, Foreign Key: kdb_users->id'),
				'name' => array('type' => 'VARCHAR', 'constraint' => 128, 'null' => false, 'comment' => 'Ads Name'),
				'position' => array('type' => 'INT', 'unsigned' => true, 'null' => false, 'default' => 0, 'comment' => 'Ads position id , Foreign Key: kdb_adspos->id'),
				'image_url' => array('type' => 'VARCHAR', 'constraint' => 512, 'null' => false, 'default' => '', 'comment' => 'Ads Banner URL'),
				'target' => array('type' => 'VARCHAR', 'constraint' => 512, 'null' => false, 'default' => '', 'comment' => 'Ads Target url'),
				'status' => array('type' => 'VARCHAR', 'constraint' => 16, 'null' => false, 'default' => 'pending', 'comment' => 'Status of ads: pending/pause/live'),
				'enabled' => array('type' => 'BOOLEAN', 'null' => false, 'default' => true, 'comment' => 'Is this ad active or not?'),
				"create_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Ads create time'",
				"expire_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Time when this ads will expire'",
				"update_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Time when this ads details updated'",
			));
			$this->dbforge->add_key('id', true);
			$this->dbforge->add_key(array('blog_id', 'user_id'));
			$this->create_table($drop, "ads");
		}

		public function table_uploads($drop = false)
		{
			$this->dbforge->add_field(array(
				'id' => array('type' => 'BIGINT', 'null' => false, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'Upload Unique id'),
				'blog_id' => array('type' => 'BIGINT', 'unsigned' => true, 'null' => false, 'default' => 0, 'comment' => 'Unique Blog id, Foreign Key: kdb_blogs->id'),
				'user_id' => array('type' => 'BIGINT', 'unsigned' => true, 'null' => false, 'default' => 0, 'comment' => 'Who uploaded this file, Foreign Key: kdb_users->id'),
				'name' => array('type' => 'VARCHAR', 'constraint' => 256, 'null' => false, 'comment' => 'File name'),
				'privacy' => array('type' => 'CHAR', 'constraint' => 2, 'null' => false, 'comment' => 'Privacy of this file.'),
				'tags' => array('type' => 'VARCHAR', 'constraint' => 512, 'null' => false, 'comment' => 'Tags for this file.'),
				'path' => array('type' => 'VARCHAR', 'constraint' => 256, 'null' => false, 'comment' => 'Path of this file.'),
				'is_image' => array('type' => 'BOOLEAN', 'null' => false, 'comment' => 'Is this file image?'),
				'file_type' => array('type' => 'VARCHAR', 'constraint' => 128, 'null' => false, 'comment' => 'Type of this file.'),
				'file_size' => array('type' => 'INT', 'unsigned' => true, 'null' => false, 'default' => 0, 'comment' => 'Size of this file.'),
				'width' => array('type' => 'INT', 'unsigned' => true, 'null' => false, 'default' => 0, 'comment' => 'Width of image.'),
				'height' => array('type' => 'INT', 'unsigned' => true, 'null' => false, 'default' => 0, 'comment' => 'Height of image.'),
				'url' => array('type' => 'VARCHAR', 'constraint' => 512, 'null' => false, 'comment' => 'URL of this file.'),
				'public_image' => array('type' => 'BOOLEAN', 'null' => false, 'default' => true, 'comment' => 'Is this image is public or only for user who uploaded'),
				"upload_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date and time when this file uploaded to server'",
			));
			$this->dbforge->add_key('id', true);
			$this->dbforge->add_key(array('blog_id', 'user_id'));
			$this->create_table($drop, "uploads");
		}

		public function table_themes($drop = false)
		{
			$this->dbforge->add_field(array(
				'id' => array('type' => 'BIGINT', 'null' => false, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'Unique id for theme'),
				'name' => array('type' => 'VARCHAR', 'constraint' => 256, 'null' => false, 'default' => '', 'comment' => 'name of theme'),
				'name_key' => array('type' => 'VARCHAR', 'constraint' => 64, 'null' => false, 'unique' => true, 'comment' => 'Using time base algorithm generated Unique Theme Key'),
				'path' => array('type' => 'VARCHAR', 'constraint' => 256, 'null' => false, 'default' => '', 'comment' => 'path of theme directory'),
				'version' => array('type' => 'VARCHAR', 'constraint' => 15, 'null' => false, 'default' => '1.0.0', 'comment' => 'version of theme'),
				'menus' => array('type' => 'VARCHAR', 'constraint' => 512, 'null' => false, 'default' => '', 'comment' => 'Array of menu blocks available in theme by device type in JSON Format'),
				'tools' => array('type' => 'VARCHAR', 'constraint' => 512, 'null' => false, 'default' => '', 'comment' => 'Array List of tools available in theme by device type in JSON Format'),
				'thumbnail' => array('type' => 'VARCHAR', 'constraint' => 512, 'null' => false, 'default' => '', 'comment' => 'Thumbnail image url of this theme'),
				'enabled' => array('type' => 'BOOLEAN', 'null' => false, 'default' => false, 'comment' => 'Is this theme publicly available for user.'),
				"create_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'when this theme first added'",
				"update_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Time when this theme details updated'",
			));
			$this->dbforge->add_key('id', true);
			$this->create_table($drop, "themes", $this->table_themes_data());
		}

		public function table_themes_data()
		{
			return array(
				"name" => "News Papper",
				"name_key" => "newspaper",
				"enabled" => true,
			);
		}

		public function table_feeder($drop = false)
		{
			$this->dbforge->add_field(array(
				'id' => array('type' => 'BIGINT', 'null' => false, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'Unique feed id'),
				'name' => array('type' => 'VARCHAR', 'constraint' => 64, 'null' => false, 'comment' => 'Feed Name'),
				'blog_id' => array('type' => 'BIGINT', 'unsigned' => true, 'null' => false, 'default' => 0, 'comment' => 'Unique Blog id, Foreign Key: kdb_blogs->id'),
				'user_id' => array('type' => 'BIGINT', 'unsigned' => true, 'null' => false, 'default' => 0, 'comment' => 'Who uploaded this file, Foreign Key: kdb_users->id'),
				'cat_id' => array('type' => 'INT', 'unsigned' => true, 'null' => false, 'default' => 0, 'comment' => 'Feed content category id, Foreign Key: kdb_category->id '),
				'tags' => array('type' => 'VARCHAR', 'constraint' => 512, 'null' => false, 'comment' => 'Content tags of this cron. Multiple tags allowed seperated by comma(,).'),
				'source_url' => array('type' => 'VARCHAR', 'constraint' => 512, 'null' => false, 'comment' => 'Source url which is used for get conten'),
				'feed_format' => array('type' => 'INT', 'unsigned' => true, 'null' => false, 'default' => 0, 'comment' => 'feed Format ID, Foreign Key: kdb_formats->id '),
				'enabled' => array('type' => 'BOOLEAN', 'null' => false, 'default' => false, 'comment' => 'Is this feed enabled ?'),
				'run_count' => array('type' => 'INT', 'unsigned' => true, 'null' => false, 'default' => 0, 'comment' => 'How much time this feed is executed.'),
				"create_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'when this feed added to system.'",
				"execute_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'when this feed executed last time.'",
				"update_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Time when this theme details updated'",
			));
			$this->dbforge->add_key('id', true);
			$this->dbforge->add_key(array('blog_id', 'user_id'));
			$this->create_table($drop, "feeder");
		}

		public function table_country($drop = false)
		{
			$this->dbforge->add_field(array(
				'id' => array('type' => 'TINYINT', 'null' => false, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'Unique Country ID'),
				'name' => array('type' => 'VARCHAR', 'constraint' => 64, 'null' => false, 'comment' => 'Country Name'),
				'iso_two' => array('type' => 'CHAR', 'constraint' => 2, 'null' => false, 'unique' => true, 'comment' => 'Country ISO Two'),
				'iso_three' => array('type' => 'CHAR', 'constraint' => 3, 'null' => false, 'unique' => true, 'comment' => 'Country ISO Three'),
				'num_iso' => array('type' => 'SMALLINT', 'unsigned' => true, 'null' => false, 'default' => 0, 'comment' => 'Country ISO Number'),
				'isd' => array('type' => 'SMALLINT', 'unsigned' => true, 'null' => false, 'unique' => true, 'default' => 0, 'comment' => 'Country ISD Number'),
				'enabled' => array('type' => 'BOOLEAN', 'null' => false, 'default' => false, 'comment' => 'System Enabled in this country'),
				"create_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'when this country added to system.'",
				"update_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Time when this country details updated'",
			));
			$this->dbforge->add_key('id', true);
			$this->create_table($drop, "country");
		}

		public function table_user_role($drop = false)
		{
			$this->dbforge->add_field(array(
				'id' => array('type' => 'SMALLINT', 'null' => false, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'Unique User Role ID'),
				'name' => array('type' => 'VARCHAR', 'constraint' => 32, 'null' => false, 'default' => '', 'comment' => 'Name of User Role'),
				'keyname' => array('type' => 'VARCHAR', 'constraint' => 32, 'null' => false, 'unique' => true, 'default' => '', 'comment' => 'User Role Unique key'),
				'description' => array('type' => 'VARCHAR', 'constraint' => 256, 'null' => false, 'default' => '', 'comment' => 'User Role short description'),
				"create_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'when this user role added to system.'",
				"update_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Time when this user role details updated'",
			));
			$this->dbforge->add_key('id', true);
			$this->create_table($drop, "user_role", $this->table_user_role_data());
		}

		public function table_user_role_data()
		{
			return array(
				"name" => "Super User",
				"keyname" => "super_user",
			);
		}

		public function table_access_groups($drop = false)
		{
			$this->dbforge->add_field(array(
				'id' => array('type' => 'SMALLINT', 'null' => false, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'Unique Access Group Unique ID'),
				'name' => array('type' => 'VARCHAR', 'constraint' => 32, 'null' => false, 'default' => '', 'comment' => 'Access Group Name'),
				'keyname' => array('type' => 'VARCHAR', 'constraint' => 32, 'null' => false, 'unique' => true, 'default' => '', 'comment' => 'Access Group Unique key'),
				'description' => array('type' => 'VARCHAR', 'constraint' => 256, 'null' => false, 'default' => '', 'comment' => 'Access Group short description'),
				"create_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'when this access groups added to system.'",
				"update_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Time when this access groups details updated'",
			));
			$this->dbforge->add_key('id', true);
			$this->create_table($drop, "access_groups", $this->table_access_groups_data());
		}

		public function table_access_groups_data()
		{
			return [
				["name" => "Blogs", "keyname" => "BLOGS"],
				["name" => "Category", "keyname" => "CATEGORY"],
				["name" => "Advertisement", "keyname" => "ADVERTISEMENT"],
				["name" => "Collection", "keyname" => "COLLECTION"],
				["name" => "Configurations", "keyname" => "CONFIGURATIONS"],
				["name" => "Settings", "keyname" => "SETTINGS"],
				["name" => "Themes", "keyname" => "THEMES"],
				["name" => "Users", "keyname" => "USERS"],
				["name" => "User Role", "keyname" => "USER_ROLE"],
			];
		}

		public function table_access($drop = false)
		{
			$this->dbforge->add_field(array(
				'id' => array('type' => 'SMALLINT', 'null' => false, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'System Access unique ID'),
				'group_id' => array('type' => 'SMALLINT', 'null' => false, 'unsigned' => true, 'default' => 0, 'comment' => 'Related Access Group ID, Foreign Key: : kdb_access_groups->id'),
				'name' => array('type' => 'VARCHAR', 'constraint' => 32, 'null' => false, 'default' => '', 'comment' => 'Access Name'),
				'keyname' => array('type' => 'VARCHAR', 'constraint' => 32, 'null' => false, 'unique' => true, 'default' => '', 'comment' => 'Access Unique key'),
				'description' => array('type' => 'VARCHAR', 'constraint' => 256, 'null' => false, 'default' => '', 'comment' => 'Access short description'),
				"create_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'when this access added to system.'",
				"update_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Time when this access details updated'",
			));
			$this->dbforge->add_key('id', true);
			$this->create_table($drop, "access", $this->table_access_data());
		}

		public function table_access_data()
		{
			return array(
				["group_id" => 1, "name" => "View Blog Summery", "keyname" => "VIEW_SUMMERY"],
				["group_id" => 1, "name" => "Posts Feature", "keyname" => "FEATURE_POSTS"],
				["group_id" => 1, "name" => "View Post List", "keyname" => "VIEW_POST_LIST"],
				["group_id" => 1, "name" => "Add New Post", "keyname" => "ADD_NEW_POST"],
				["group_id" => 1, "name" => "Edit Post", "keyname" => "EDIT_POST"],
				["group_id" => 1, "name" => "Delete Post", "keyname" => "DELETE_POST"],
				["group_id" => 1, "name" => "Videos Feature", "keyname" => "FEATURE_VIDEOS"],
				["group_id" => 1, "name" => "View Video List", "keyname" => "VIEW_VIDEO_LIST"],
				["group_id" => 1, "name" => "Search Videos", "keyname" => "SEARCH_VIDEOS"],
				["group_id" => 1, "name" => "Search Youtube Video", "keyname" => "SEARCH_YOUTUBE_VIDEO"],
				["group_id" => 1, "name" => "Search Facebook Video", "keyname" => "SEARCH_FACEBOOK_VIDEO"],
				["group_id" => 1, "name" => "Search Vimeo Video", "keyname" => "SEARCH_VIMEO_VIDEO"],
				["group_id" => 1, "name" => "Add New Video", "keyname" => "ADD_NEW_VIDEO"],
				["group_id" => 1, "name" => "Edit Video", "keyname" => "EDIT_VIDEO"],
				["group_id" => 1, "name" => "Delete Video", "keyname" => "DELETE_VIDEO"],
				["group_id" => 1, "name" => "Page Feature", "keyname" => "FEATURE_PAGES"],
				["group_id" => 1, "name" => "View Page List", "keyname" => "VIEW_PAGE_LIST"],
				["group_id" => 1, "name" => "Add New Page", "keyname" => "ADD_NEW_PAGE"],
				["group_id" => 1, "name" => "Edit Page", "keyname" => "EDIT_PAGE"],
				["group_id" => 1, "name" => "Delete Page", "keyname" => "DELETE_PAGE"],
				["group_id" => 2, "name" => "Category Feature", "keyname" => "FEATURE_CATEGORY"],
				["group_id" => 2, "name" => "View Category List", "keyname" => "VIEW_CATEGORY_LIST"],
				["group_id" => 2, "name" => "Add New Category", "keyname" => "ADD_NEW_CATEGORY"],
				["group_id" => 2, "name" => "Edit Category", "keyname" => "EDIT_CATEGORY"],
				["group_id" => 2, "name" => "Delete Category", "keyname" => "DELETE_CATEGORY"],
				["group_id" => 2, "name" => "Add New System Category", "keyname" => "ADD_NEW_SYSTEM_CATEGORY"],
				["group_id" => 2, "name" => "Edit System Category", "keyname" => "EDIT_SYSTEM_CATEGORY"],
				["group_id" => 2, "name" => "Delete System Category", "keyname" => "DELETE_SYSTEM_CATEGORY"],
				["group_id" => 3, "name" => "Advertisment Feature", "keyname" => "FEATURE_ADS"],
				["group_id" => 3, "name" => "View Advertisment List", "keyname" => "VIEW_ADS_LIST"],
				["group_id" => 3, "name" => "Add New Advertisement", "keyname" => "ADD_NEW_ADS"],
				["group_id" => 3, "name" => "Edit Advertisement", "keyname" => "EDIT_ADS"],
				["group_id" => 3, "name" => "Delete Advertisement", "keyname" => "DELETE_ADS"],
				["group_id" => 3, "name" => "View Advertisement Group List", "keyname" => "VIEW_ADS_GROUP_LIST"],
				["group_id" => 3, "name" => "Add new Advertisement Group", "keyname" => "ADD_NEW_ADS_GROUP"],
				["group_id" => 3, "name" => "Edit Advertisement Group", "keyname" => "EDIT_ADS_GROUP"],
				["group_id" => 3, "name" => "Delete Advertisement Group", "keyname" => "DELETE_ADS_GROUP"],
				["group_id" => 4, "name" => "Files Collection Feature", "keyname" => "FEATURE_COLLECTION"],
				["group_id" => 4, "name" => "View Image List", "keyname" => "VIEW_IMAGE_LIST"],
				["group_id" => 4, "name" => "View Document List", "keyname" => "VIEW_DOCUMENT_LIST"],
				["group_id" => 4, "name" => "Upload New Image", "keyname" => "UPLOAD_NEW_IMAGE"],
				["group_id" => 4, "name" => "Upload Public Image", "keyname" => "UPLOAD_PUBLIC_IMAGE"],
				["group_id" => 4, "name" => "Delete Images", "keyname" => "DELETE_IMAGE"],
				["group_id" => 4, "name" => "Delete Public Images", "keyname" => "DELETE_PUBLIC_IMAGE"],
				["group_id" => 4, "name" => "Upload New Document", "keyname" => "UPLOAD_NEW_DOCUMENT"],
				["group_id" => 4, "name" => "Upload Public Document", "keyname" => "UPLOAD_PUBLIC_DOCUMENT"],
				["group_id" => 4, "name" => "Delete Documents", "keyname" => "DELETE_DOCUMENT"],
				["group_id" => 4, "name" => "Delete Public Documents", "keyname" => "DELETE_PUBLIC_DOCUMENT"],
				["group_id" => 6, "name" => "Settings", "keyname" => "FEATURE_SETTINGS"],
				["group_id" => 6, "name" => "General Settings", "keyname" => "BLOG_GENERAL_SETTINGS"],
				["group_id" => 6, "name" => "Change Theme", "keyname" => "CHANGE_BLOG_THEME"],
				["group_id" => 7, "name" => "Menu Feature", "keyname" => "FEATURE_MENU"],
				["group_id" => 7, "name" => "View Menu List", "keyname" => "VIEW_MENU_LIST"],
				["group_id" => 7, "name" => "Add New Menu", "keyname" => "ADD_NEW_MENU"],
				["group_id" => 7, "name" => "Edit Menu", "keyname" => "EDIT_MENU"],
				["group_id" => 7, "name" => "Delete Menu", "keyname" => "DELETE_MENU"],
				["group_id" => 6, "name" => "Settings", "keyname" => "ACCOUNT_SETTINGS"],
				["group_id" => 6, "name" => "Change Password", "keyname" => "CHANGE_PASSWORD"],
				["group_id" => 6, "name" => "Add New Blog", "keyname" => "ADD_NEW_BLOG"],
				["group_id" => 6, "name" => "Edit Blog", "keyname" => "EDIT_BLOG"],
				["group_id" => 6, "name" => "View Blog List", "keyname" => "VIEW_BLOG_LIST"],
				["group_id" => 7, "name" => "Themes Feature", "keyname" => "THEME_FEATURE"],
				["group_id" => 7, "name" => "View Theme List", "keyname" => "VIEW_THEME_LIST"],
				["group_id" => 7, "name" => "Add new Theme", "keyname" => "ADD_NEW_THEME"],
				["group_id" => 7, "name" => "Edit Theme", "keyname" => "EDIT_THEME"],
				["group_id" => 7, "name" => "Enable Theme", "keyname" => "ENABLE_THEME"],
				["group_id" => 7, "name" => "Disable Theme", "keyname" => "DISABLE_THEME"],
				["group_id" => 7, "name" => "Remove Theme", "keyname" => "REMOVE_THEME"],
				["group_id" => 3, "name" => "View Ads Size List", "keyname" => "VIEW_ADSIZE_LIST"],
				["group_id" => 3, "name" => "Add New Ads Size", "keyname" => "ADD_NEW_ADSIZE"],
				["group_id" => 3, "name" => "Edit Ads Size", "keyname" => "EDIT_ADSIZE"],
				["group_id" => 3, "name" => "Delete Ads Size", "keyname" => "DELETE_ADSIZE"],
				["group_id" => 8, "name" => "View User List", "keyname" => "VIEW_USER_LIST"],
				["group_id" => 8, "name" => "Add New User", "keyname" => "ADD_NEW_USER"],
				["group_id" => 8, "name" => "Edit User", "keyname" => "EDIT_USER"],
				["group_id" => 8, "name" => "Activate User", "keyname" => "ACTIVATE_USER"],
				["group_id" => 8, "name" => "Deactivate User", "keyname" => "DEACTIVATE_USER"],
				["group_id" => 8, "name" => "Block User", "keyname" => "BLOCK_USER"],
				["group_id" => 8, "name" => "Delete User", "keyname" => "DELETE_USER"],
				["group_id" => 9, "name" => "User Role Feature", "keyname" => "USER_ROLE_FEATURE"],
				["group_id" => 9, "name" => "View User Role List", "keyname" => "VIEW_USER_ROLE_LIST"],
				["group_id" => 9, "name" => "Add New User Role", "keyname" => "ADD_NEW_USER_ROLE"],
				["group_id" => 9, "name" => "Edit User Role", "keyname" => "EDIT_USER_ROLE"],
				["group_id" => 9, "name" => "Delete User Role", "keyname" => "DELETE_USER_ROLE"],
				["group_id" => 9, "name" => "View Access Group List", "keyname" => "VIEW_ACCESS_GROUP_LIST"],
				["group_id" => 9, "name" => "Add New Access Group", "keyname" => "ADD_NEW_ACCESS_GROUP"],
				["group_id" => 9, "name" => "Edit Access Group", "keyname" => "EDIT_ACCESS_GROUP"],
				["group_id" => 9, "name" => "Delete Access Group", "keyname" => "DELETE_ACCESS_GROUP"],
				["group_id" => 9, "name" => "View Access List", "keyname" => "VIEW_ACCESS_LIST"],
				["group_id" => 9, "name" => "Add New Access", "keyname" => "ADD_NEW_ACCESS"],
				["group_id" => 9, "name" => "Edit Access", "keyname" => "EDIT_ACCESS"],
				["group_id" => 9, "name" => "Delete Access", "keyname" => "DELETE_ACCESS"],
				["group_id" => 9, "name" => "Change User Role Access", "keyname" => "CHANGE_USER_ROLE_ACCESS"],
				["group_id" => 5, "name" => "Set Default User Role", "keyname" => "SET_DEFAULT_USER_ROLE"],
			);
		}

		public function table_access_role($drop = false)
		{
			$this->dbforge->add_field(array(
				'id' => array('type' => 'INT', 'null' => false, 'unsigned' => true, 'auto_increment' => true, 'comment' => 'System Access Grant Unique ID'),
				'user_id' => array('type' => 'BIGINT', 'unsigned' => true, 'null' => false, 'default' => 0, 'comment' => 'Who updated this access, Foreign Key: kdb_users->id'),
				'role_id' => array('type' => 'SMALLINT', 'null' => false, 'unsigned' => true, 'default' => 0, 'comment' => 'User Role Id, Foreign Key: kdb_user_role->id'),
				'access_id' => array('type' => 'SMALLINT', 'null' => false, 'unsigned' => true, 'default' => 0, 'comment' => 'Access Id, Foreign Key: kdb_access->id'),
				'enabled' => array('type' => 'BOOLEAN', 'null' => false, 'default' => false, 'comment' => 'Is this access enabled'),
				"create_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'A time when access granted.'",
				"update_time DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Time when access updated'",
			));
			$this->dbforge->add_key('id', true);
			$this->dbforge->add_key(array('user_id', 'role_id', 'access_id'));
			$this->create_table($drop, "access_role", $this->table_access_role_data());
		}

		public function table_access_role_data()
		{
			return array(
				array("user_id" => 1, "role_id" => 1, "access_id" => 1, "enabled" => true),
				array("user_id" => 1, "role_id" => 1, "access_id" => 49, "enabled" => true),
				array("user_id" => 1, "role_id" => 1, "access_id" => 57, "enabled" => true),
				array("user_id" => 1, "role_id" => 1, "access_id" => 58, "enabled" => true),
				array("user_id" => 1, "role_id" => 1, "access_id" => 59, "enabled" => true),
				array("user_id" => 1, "role_id" => 1, "access_id" => 61, "enabled" => true),
				array("user_id" => 1, "role_id" => 1, "access_id" => 80, "enabled" => true),
				array("user_id" => 1, "role_id" => 1, "access_id" => 81, "enabled" => true),
				array("user_id" => 1, "role_id" => 1, "access_id" => 82, "enabled" => true),
				array("user_id" => 1, "role_id" => 1, "access_id" => 83, "enabled" => true),
				array("user_id" => 1, "role_id" => 1, "access_id" => 84, "enabled" => true),
				array("user_id" => 1, "role_id" => 1, "access_id" => 89, "enabled" => true),
				array("user_id" => 1, "role_id" => 1, "access_id" => 90, "enabled" => true),
				array("user_id" => 1, "role_id" => 1, "access_id" => 91, "enabled" => true),
				array("user_id" => 1, "role_id" => 1, "access_id" => 92, "enabled" => true),
				array("user_id" => 1, "role_id" => 1, "access_id" => 93, "enabled" => true),
				array("user_id" => 1, "role_id" => 1, "access_id" => 94, "enabled" => true),
			);
		}

		/* ======================================================================================== */
		/* ======================================================================================== */
		/* ======================================================================================== */

		private function create_table($drop, $table, $data = [])
		{
			if ($drop) {
				echo "Deleting $table....\n";
				$this->dbforge->drop_table($table, true);
			}

			echo "Creating $table....\n";
			$this->dbforge->create_table($table, true);
			if (is_array($data) && count($data) > 0) {
				echo "Inserting data in $table....\n";
				(is_array(reset($data))) ? $this->db->insert_batch($table, $data) : $this->db->insert($table, $data);
			}
		}

	}

}

<?php

if (!class_exists('Database')) {

    class Database {

        private $db;

        function __construct() {
            global $config;
            $this->db = new mysqli($config->get('DB-HOST'), $config->get('DB-USER'), $config->get('DB-PASSWORD'), $config->get('DB-DATABASE'));
            if ($this->db->connect_error) {
                die("Connection failed: " . $this->db->connect_error);
            }
        }

        /* Functions for Cron Tabs */

        public function getCronReport($name) {
            $sql = "select * from crontab where crontab='$name'";
            $data = $this->runMyQuery($sql, 'select');
            if (count($data) > 0 AND isset($data[0]['last_post_key'])) {
                return $data[0]['last_post_key'];
            } else {
                $sql = "insert into crontab (crontab, last_post_key, last_run) values('$name', '', now());";
                $insert = $this->runMyQuery($sql);
                if ($insert) {
                    return "";
                } else {
                    return FALSE;
                }
            }
        }

        public function getWebsiteInfo($website_id) {
            $sql = "select * from website where id='$website_id'";
            $data = $this->runMyQuery($sql, 'select');
            return (isset($data[0]) AND count($data) == 1) ? $data[0] : false;            
        }
        
        public function setCronLastPost($cron, $key) {
			$update_time = date('Y-m-d H:i:s');
            $sql = "update crontab set last_post_key='$key', last_run='$update_time' where crontab='$cron';";
            return $this->runMyQuery($sql, 'update');
        }

        /* Function for handle website users */

        public function getUser($username) {
            $sql = "select * from users where username='$username'";
            $data = $this->runMyQuery($sql, 'select');
            return (count($data) == 1 AND isset($data[0])) ? $data[0] : false;
        }

        public function getCronList() {
            $sql = "select a.*, b.language from crontab_list as a left join website as b on b.id=a.website_id where a.enabled='1';";
            $data = $this->runMyQuery($sql, 'select');
            return (count($data) != 0) ? $data : false;
        }
        
        public function getUserData($userid) {
            $sql = "select * from users where id='$userid'";
            $data = $this->runMyQuery($sql, 'select');
            return (count($data) == 1 AND isset($data[0])) ? $data[0] : false;
        }
        
        public function getAccessToken($username = '') {
            return ($username != '') ? $this->GAccessToken($username) : false;
        }

        public function updateTodayPost($keyUserid, $today) {
            $sql = "select today from users where id='$keyUserid'";
            $data = $this->runMyQuery($sql, 'select');
            $isToday = (isset($data[0]) && date("Y-m-d", strtotime($data[0]['today'])) == $today) ? TRUE : FALSE;
            $this->updateWebsitePostCount($isToday);
            if ($isToday) {
                $sql = "UPDATE users SET lifetime_count=lifetime_count+1, today_count = today_count+1 WHERE id='$keyUserid'";
            } else {
                $sql = "UPDATE users SET lifetime_count=lifetime_count+1, today_count = '1', today='$today' WHERE id='$keyUserid'";
            }
            return $this->runMyQuery($sql, 'update');
        }

        public function updateWebsitePostCount($isToday){
            global $config;
            $website_id = $config->get("B-WEBSITE_ID");
            if ($isToday) {
                $sql = "UPDATE website SET lifetime_count=lifetime_count+1, today_count = today_count+1 WHERE id='$website_id'";
            } else {
                $sql = "UPDATE website SET lifetime_count=lifetime_count+1, today_count = '1' WHERE id='$website_id'";
            }
            return $this->runMyQuery($sql, 'update');
        }
		
		public function insertThisPostInDb($userid, $articleId, $content) {
            $content = $this->db->real_escape_string($content);
            $sql = "insert into articles (userid, article_id, content) values('$userid', '$articleId', '$content');";
            return $this->runMyQuery($sql);
        }
		
		public function addNewPhoto($userid, $image){
            $url    = $this->db->real_escape_string($image['url']);
            $width  = $this->db->real_escape_string($image['width']);
            $height = $this->db->real_escape_string($image['height']);
            $sql = "insert into images (url, width, height, userid) values ('$url',$width,$height,$userid);";
            return $this->runMyQuery($sql);
        }

        public function getImagesList($offset) {
            $sql = "select id as number, url as src, width, height from images order by id desc limit 20 OFFSET $offset;";
            $data = $this->runMyQuery($sql, 'select');
            return $data;
        }
        
        public function updateUserAccessToken($google) {
            $sql = "UPDATE users SET ";
            $sql = (isset($google['token'])) ? $sql . "access_token='" . $google['token'] . "'," : $sql;
            $sql = (isset($google['refresh'])) ? $sql . "update_token='" . $google['refresh'] . "'," : $sql;
            $sql = (isset($google['time'])) ? $sql . "expire_time='" . $google['time'] . "'" : rtrim($sql, ",");
            $sql .= " WHERE id='" . $google['userid'] . "';";
            $rowsAffected = $this->runMyQuery($sql, 'update', FALSE, TRUE);
            return ($rowsAffected >= 1) ? TRUE : FALSE;
        }

		/** This query will add Post key for check unique in todays posts. **/
        public function insertPostCache($website_id, $article, $date = FALSE) {
			$date = ($date == FALSE)? date("Y-m-d") : $date;
            $post_key = $this->db->real_escape_string($article['key']);
            $post_title = $this->db->real_escape_string($article['title']);
            $post_image = $this->db->real_escape_string($article['key_img']);
            $website_id = $this->db->real_escape_string($website_id);
			$sql = "INSERT INTO cache_post (website_id, post_date, post_key, post_title,post_image) VALUES ('$website_id', '$date', '$post_key', '$post_title','$post_image');";
			return $this->runMyQuery($sql);
        }
		
		/** This query will check is post exist in database already or is new post **/
        public function postExistInCache($website_id, $article, $date = FALSE) {
			$post_key = $this->db->real_escape_string($article['key']);
            $post_title = $this->db->real_escape_string($article['title']);
            $post_image = $this->db->real_escape_string($article['key_img']);
			$intervaldate 	= $date;
			if($date == FALSE){
				$date 			= date("Y-m-d");
				$intervaldate 	= date('Y-m-d',strtotime("-10 days"));
			}
			$split_title = explode(" ", $post_title);
			$split_like = "";
			$tmp = "";
			foreach($split_title as $i => $v){
				if((($i+1)%5) == 0){
					$tmp = trim($tmp);
					$split_like .= " OR post_title LIKE '%$tmp%'";
					$tmp = "";
				}else{
					$tmp .= "$v ";
				}
			}			
			
            //$sql = "SELECT id FROM cache_post WHERE post_date='$date' AND website_id='$website_id' AND post_key LIKE '%$post_key%' OR post_title LIKE '%$post_title%';";
            $sql = "SELECT id FROM cache_post WHERE post_date='$date' AND post_date >= '$intervaldate' AND website_id='$website_id' AND post_key LIKE '%$post_key%' OR post_image LIKE '%$post_image%' OR post_title LIKE '%$post_title%' $split_like;";
            $data = $this->runMyQuery($sql, 'select');
            return (isset($data[0]) AND count($data) >= 0) ? TRUE : FALSE;
        }
		
        /* All Private function will be written here */

        private function GAccessToken($username) {
            global $config;
            $website_id = $config->get("B-WEBSITE_ID");
            //$sql = "SELECT id,username,access_token, update_token, expire_time FROM users WHERE (username='cron' AND update_token IS NOT NULL AND ( today_count<=47 OR today<CURRENT_DATE() )) OR (update_token IS NOT NULL AND ( today_count<=47 OR today<CURRENT_DATE() )) ORDER BY CASE WHEN username LIKE '$username%' THEN 0 ELSE 1 END LIMIT 1;";
            $sql = "SELECT u.id,u.username,u.access_token,u.update_token,u.expire_time FROM users as u left join website_access as w on u.id=w.user_id where w.website_id='$website_id' AND u.update_token IS NOT NULL AND ( u.today_count<=47 OR u.today<CURRENT_DATE() )  ORDER BY CASE WHEN u.username LIKE '$username%' THEN 0 ELSE 1 END LIMIT 1;";
            $data = $this->runMyQuery($sql, 'select');
            return (count($data) == 1 AND isset($data[0])) ? $data[0] : $data;
        }

        private function runMyQuery($sql, $operation = 'insert', $returnid = FALSE, $updatecount = FALSE, $rows = FALSE) {
            $query = $this->db->query($sql);
            if ($query == FALSE) {
                echo $this->db->error;
                return FALSE;
            }

            switch ($operation) {
                case 'insert':
                    if ($returnid == TRUE) {
                        return $this->db->insert_id;
                    } else {
                        return TRUE;
                    }
                    break;
                case 'select':
                    if ($rows == TRUE) {
                        return $this->db->num_rows;
                    } else {
                        return $query->fetch_all(MYSQLI_ASSOC);
                    }
                    break;
                case 'update':
                    if ($updatecount == TRUE) {
                        return $this->db->affected_rows;
                    } else {
                        return TRUE;
                    }
                    break;
            }
        }

    }

}
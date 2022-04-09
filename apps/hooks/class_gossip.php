<?php
session_start();
include ($config->get('CLASSPATH') . 'class_database.php');
include ($config->get('CLASSPATH') . 'class_html.php');
include ($config->get('CLASSPATH') . 'class_image.php');
include ($config->get('CLASSPATH') . 'class_blogger.php');
if (!class_exists('Application')) {
    class Application {
        public $db;
        private $html;
        private $image;
        private $config;
        private $configs;
        private $blogger;
        private $language;

        /**
         * Assign new constructore objects
         */
        function __construct() {
            global $config;
            $this->db = new Database();
            $this->html = new html();
            $this->image = new Image();
            $this->blogger = new Blogger();
            $this->setAllConfigs();
            $this->config = $config;
        }

        public function getPosts($startIndex = 1, $results = 10){
            global $config;
            $url = false;
            $posts = array();
            $role = $this->activeUserRole();
            switch ($role){
                case 'admin' :
                    $url = $config->get('B-PATH') . "feeds/posts/default?alt=json&redirect=false&start-index=$startIndex&max-results=$results";
                break;
                case 'user' :
                    $url = $config->get('B-PATH') . "feeds/posts/default/-/aut".$this->activeUsername()."/?alt=json&redirect=false&start-index=$startIndex&max-results=$results";
                break;
            }
           if($url != false){
               $array = $this->runViaCurl($url, FALSE, FALSE, FALSE, FALSE, TRUE);
               $list = $array['feed']['entry'];
               foreach ($list as $data){
                   $post = array(
                           'title'  => $data['title']['$t'],
                           'url'    => $data['link'][4]["href"],
                           'postid' => explode('-',$data['id']['$t'])[2]
                    );
                   array_push($posts, $post);
               }
           }
           return $posts;
        }

        public function getImages($startIndex = 0){
            $images = $this->db->getImagesList($startIndex);
            $return = array('images' => array(), 'next' => 'false');
            if(count($images) > 0){
                $return['images']  = $images;
                $return['next']    = $startIndex + count($images);
            }
            return $return;
        }

        public function getCategories() {
            return $this->configs['categories'];
        }

        public function getLanguages() {
            return $this->configs['language'];
        }

        public function getMenuList(){
            $role    = $this->activeUserRole();
            return $this->getUserMenuList($role);
        }

        /**
         * This function will create a new custom post
         * @param array $post
         */
        public function createCustomPost($post) {
            echo json_encode($this->createBloggerPost($post));
        }

        public function uploadNewPhoto($photo) {
            $image = array("status" => 'fail', "msg" => "Please select a valid image for upload");
            if (isset($photo['type'])) {
                if ($photo['type'] == 'file') {
                    $image = $this->image->getImageUrl($photo['content'], FALSE);
                    if(isset($image['status']) AND $image['status'] == "success" ){
                        $userid = $this->activeUserid();
                        $this->db->addNewPhoto($userid, $image);
                    }
                }
            }
            echo json_encode($image);
        }

        public function createBloggerPost($post) {
            $return = '';
            $image = FALSE;
            $postvalid = $this->validateContent($post);
            if ($postvalid == TRUE) {
                if (is_array($post['image']) && isset($post['image']['type'])) {
                    if ($post['image']['type'] == 'file') {
                        $image = $this->image->getImageUrl($post['image']['content'], FALSE);
                    } elseif ($post['image']['type'] == 'url') {
                        if ($post['image']['source'] == 'same') {
                            $image = array('status' => 'success', 'url' => $post['image']['content']);
                        } else {
                            $image = $this->image->getImageUrl($post['image']['content'], TRUE);
                        }
                    }
                }

                if ($image == FALSE) {
                    return array("status" => 'fail', "msg" => "Unable to handle image");
                } elseif ((isset($image['status'])) AND $image['status'] == "success") {
                    $post['image'] = $image['url'];
                    $post['subcategory'] = (isset($post['subcategory']))? $post['subcategory'] : "";
                    /* Retrive tags and set html content */
                    $tags = array($post['category'],$post['subcategory'], $post['type'] . "-" . $post['source']);
                    $refeenceTags = $this->getReferenceUrlTags($post);
                    $post['tags'] = array_unique(array_merge($tags, $post['tags'], $refeenceTags));
                    $post['taglist'] = array('tag' => $post['tags'], 'category' => $post['category'], 'subcat' => $post['subcategory']);
                    $post = $this->setuserTag($post);
                    $blogPost = $this->prepairPost($post);
                    $result = $this->createPost($blogPost);
                    if ($result != false) {
                        $this->postDBAction($post, $result);
                        if (is_array($result)) {
                            $return = array_merge($result, array("status" => 'success', "msg" => "New Artical added on website"));
                        } else {
                            $return = array("status" => 'success', "msg" => "New Artical added on website");
                        }
                    } else {
                        $return = array("status" => 'fail', "msg" => "Unable to cretae new Artical");
                    }
                }
            } else {
                $return = $postvalid;
            }
            return $return;
        }

        /* Users Functions Start */

        public function activeUsername() {
            return (isset($_SESSION['username'])) ? $_SESSION['username'] : FALSE;
        }

        public function activeUserid() {
            return (isset($_SESSION['userid'])) ? $_SESSION['userid'] : FALSE;
        }

        public function activeUseremail() {
            return (isset($_SESSION['email'])) ? $_SESSION['email'] : FALSE;
        }
        
        public function activeUserRole() {
            return (isset($_SESSION['role'])) ? $_SESSION['role'] : FALSE;
        }
        

        public function setSignupStart() {
            return ($_SESSION['signupstart'] = TRUE);
        }

        public function setSignupComplete() {
            return ($_SESSION['signupstart'] = NULL);
        }

        public function isSignupRequest() {
            return (isset($_SESSION['signupstart']) AND $_SESSION['signupstart'] == TRUE) ? TRUE : FALSE;
        }

        public function updateBloggerAccess($userid, $token) {
            if (isset($token['access_token'])) {
                $google['userid'] = $userid;
                $google['token'] = $token['access_token'];
                $google['time'] = $this->blogger->getTokenExpireTime($token['expires_in']);
                $google['refresh'] = $token['refresh_token'];
                return $this->db->updateUserAccessToken($google);
            }
        }

        /**
         * This function will check the login of application
         * @param boolean $notloginPage
         */
        public function checkIsLogin($notloginPage = TRUE) {
            if ($this->isLogin() != TRUE and $notloginPage == TRUE) {
                header('Location: login.php');
            } elseif ($this->isLogin() == TRUE and $notloginPage == FALSE) {
                header('Location: index.php');
            }
        }

        public function cronUserLogin($username, $password) {
            $user = $this->checkLogin($username, $password);
            if ($user != FALSE) {
                $this->setLoginUser($user);
            }
            return $user;
        }

        public function isLogin() {
            return (isset($_SESSION['login']) and $_SESSION['login'] == TRUE) ? TRUE : FALSE;
        }

        public function validateLogin($username, $password) {
            $user = $this->checkLogin($username, $password);
            if ($user != FALSE) {
                $this->setLoginUser($user);
                header('Location: index.php');
                exit();
            }
            return FALSE;
        }

        public function logout() {
            session_destroy();
        }

        public function get($url) {
            return $this->runViaCurl($url, FALSE, FALSE, FALSE, FALSE, FALSE);
        }

        public function post($url, $fields) {
            return $this->runViaCurl($url, $fields, true);
        }

        public function fetch($url) {
            return file_get_contents($url);
        }

		public function deletePost($post_id){
			return $this->blogger->delete($post_id);
		}
		
        /* Private function declares here */

        public function runViaCurl($url, $fields = false, $postRequest = false, $header = false, $customRequest = false, $decode = true) {
            $ch = curl_init();
            if (!$ch) {
                die("Couldn't initialize a cURL handle");
            }
            curl_setopt($ch, CURLOPT_URL, $url);
            ($header !== false) ? curl_setopt($ch, CURLOPT_HTTPHEADER, $header) : '';
            ($customRequest !== false) ? curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $customRequest) : '';
            ($postRequest == TRUE) ? curl_setopt($ch, CURLOPT_POST, TRUE) : '';
            ($fields !== false) ? curl_setopt($ch, CURLOPT_POSTFIELDS, $fields) : '';
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_FAILONERROR, TRUE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            ($header !== false) ? curl_setopt($ch, CURLINFO_HEADER_OUT, TRUE) : '';
            $response = curl_exec($ch);
            if (curl_errno($ch)) {
                die(curl_error($ch));
            }
            curl_close($ch);
            $return = ($decode == TRUE) ? json_decode($response, TRUE) : $response;
            return $return;
        }

        public function bugx($data) {
            echo "<pre>";
            var_dump($data);
            die();
        }

        public function debug($data) {
            echo "<pre>";
            var_dump($data);
            echo "</pre>";
        }

        /* Protected Function declares here which can be extends for access  */


        /* Private function written */
        private function getUserMenuList($role){
            $menu = array();
            if(in_array($role, array('user', 'admin'))){
                if($this->isGaccessAvailable() == false){
                    array_push($menu, array("class" => "blogaccess", "name"=> "Blog Access", "url" => "action.php?action=blogaccess"));
                }
            }
            
            if(in_array($role, array('admin'))){
                array_push($menu, array("class" => "banners", "name"=> "Banners", "url" => "#"));
                array_push($menu, array("class" => "photos", "name"=> "Photos", "url" => "#"));
            }
            
            return $menu;
        }

        private function isGaccessAvailable(){
            $userid = $this->activeUserid();
            if($userid != FALSE){
                $data   = $this->db->getUserData($userid);
                return (isset($data['update_token']) AND $data['update_token'] != null AND $data['update_token'] != "")? true : false;
            }
            return FALSE;
        }
        
        private function setuserTag($post) {
            $userTag = $this->activeUsername();
            if ($userTag != FALSE) {
                array_push($post['tags'], 'aut' . $userTag);
            }
            return $post;
        }
        
        private function getReferenceUrlTags($post){
            if(false && isset($post['reference']) AND $post['reference'] != ""){
                $url = $post['reference'];
                $tags = @get_meta_tags($url);
                $taglist = isset($tags['keywords']) ? explode(',', $tags['keywords']) : array();
                $taglist = array_map(function($value) { return str_replace(' ', '-', $value); }, array_map('strtolower', array_map('trim', $taglist)));
                return $taglist;
            }else{
                return array();
            }
        }
        
        private function prepairPost($post) {
            $blog['title'] = $post['title'];
            $blog['url'] = $post['url'];
            $blog['tags'] = $post['tags'];
            $blog['body'] = $this->getArticalBody($post);
            return $blog;
        }

        private function getArticalBody($post) {
            include($this->config->get('PANELPATH') . 'templates/blogger_article.php');
            return $html;
        }

        private function createPost($post) {
            return $this->blogger->create($post);
        }

        private function checkLogin($username, $password) {
            $user = $this->db->getUser($username);
            if (is_array($user) && isset($user['password'])) {
                return ($user['password'] == $password) ? $user : FALSE;
            } else {
                return FALSE;
            }
        }

        private function setAllConfigs() {
            $categories = array(
                "entertainment" => array("name" => "Entertainment", "tags" => "entertainment"),
                "bollywood" => array("name" => "Bollywood Gossip", "tags" => "bollywood"),
                "politics" => array("name" => "Politics", "tags" => "politics"),
                "sport" => array("name" => "Sport", "tags" => "sport")
            );

            $languages = array(
                "hindi" => array("name" => "हिन्दी", "tags" => "hindi", "default" => FALSE),
                "english" => array("name" => "English", "tags" => "english", "default" => TRUE),
                "punjabi" => array("name" => "Punjabi", "tags" => "punjabi", "default" => FALSE),
            );

            $this->configs = array(
                "categories" => $categories,
                "language" => $languages
            );
        }

        private function setLoginUser($user) {
            $_SESSION['username'] = (isset($user['username'])) ? $user['username'] : NULL;
            $_SESSION['userid'] = (isset($user['id'])) ? $user['id'] : NULL;
            $_SESSION['email'] = (isset($user['email'])) ? $user['email'] : NULL;
            $_SESSION['role'] = (isset($user['role'])) ? $user['role'] : NULL;
            $_SESSION['login'] = TRUE;
        }

        /* This function will return the category tags */

        private function getCategoryTags($category) {
            return (isset($this->configs['categories'][$category])) ? explode(',', $this->configs['categories'][$category]["tags"]) : array();
        }

        private function getLanguageTags($language) {
            return (isset($this->configs['language'][$language])) ? explode(',', $this->configs['language'][$language]["tags"]) : array();
        }

        private function currentAccessToken() {
            return (isset($_SESSION['accessToken'])) ? $_SESSION['accessToken'] : FALSE;
        }

        private function postDBAction($post, $blogpost) {
            /* After create post on blogger we perform following actions
              1. Increase today post of current access account
              2. Increase total post of current access account
              3. Insert this post in database
             */
            $keyUserid = isset($blogpost['tokenuser']) ? $blogpost['tokenuser'] : FALSE;
            if ($keyUserid != FALSE) {
                $today = strftime('%F');
                $this->db->updateTodayPost($keyUserid, $today);
            }
            $userid = $this->activeUserid();
            $content = json_encode($post);
            $articleId = isset($blogpost['id']) ? $blogpost['id'] : '';
            $this->db->insertThisPostInDb($userid, $articleId, $content);
        }

        private function validateContent($post) {
            if ($post['title'] == "" || strlen($post['title']) < 10) {
                return array("status" => 'fail', "msg" => "Provide a valid title for this article");
            } else if ($post['content'] == "" || strlen($post['content']) < 100) {
                return array("status" => 'fail', "msg" => "Provide a valid content for this article");
            } else if ($post['url'] == "" || strlen($post['url']) < 15) {
                return array("status" => 'fail', "msg" => "Provide a valid url for this article");
            } else if ($post['category'] == "" || !array_key_exists($post['category'], $this->configs['categories'])) {
                return array("status" => 'fail', "msg" => "Invalid category you selected");
            }
            return TRUE;
        }

    }
}

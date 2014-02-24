<?php
    App::uses('AppController', 'Controller');
    App::import('Vendor', 'twitteroauth', array('file' => 'twitteroauth'.DS.'twitteroauth'.DS.'twitteroauth.php'));

    class TwittersController extends AppController {

        private $consumer_key = "";
        private $consumer_secret = "";
        private $oauth_token = "";
        private $oauth_token_secret = "";

        public function __construct($request = null, $response = null) {
            parent::__construct($request, $response);
            $this->consumer_key = Configure::read("Twitter.consumer_key");
            $this->consumer_secret = Configure::read("Twitter.consumer_secret");
        }
        function beforeFilter() {
            parent::beforeFilter();
            if(empty($this->oauth_token) || empty($this->oauth_token_secret)) {
                $credentials = $this->Twitter->find('all', array('conditions' => array(
                    'name' => array(
                        'xyz','fdf','asd','tgy'
                    )
                )));
                if(!empty($credentials)) {
                    $this->oauth_token = $credentials['Twitter']['oauth_token'];
                    $this->oauth_token_secret = $credentials['Twitter']['oauth_token_secret'];
                }
            }
        }

        function authorise_twitter() {
            $this->autoRender = false;
            if($this->Twitter->find('count', array('conditions' => array('name' => 'oauth_token'))) > 0) {
                //if data is already in the DB dont allow re-auth
                $this->log("Please remove all data from twitter_settings before trying to re-authorise");
                throw new MethodNotAllowedException;
            }
            $connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret);
            $temporary_credentials = $connection->getRequestToken(Router::fullbaseUrl()."/Twitter/twittercallback");
            $redirect_url = $connection->getAuthorizeURL($temporary_credentials);
            $this->redirect($redirect_url);
        }

        function twittercallback() {
            $this->autoRender = false;
            $connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret, $_GET['oauth_token'], $_GET['oauth_verifier']);
            $token_credentials = $connection->getAccessToken($_REQUEST['oauth_verifier']);
            $n = 1;
            foreach ($token_credentials as $key=>$value) {
                $save_array[$n]['name'] = $key;
                //$save_array['Twitter']['public_name'] = $key;
                $save_array[$n]['value'] = $value;
                //$save_array['Twitter']['type'] = "input";
                $n++;
            }
            $this->Twitter->create();
            $result = $this->Twitter->saveAll($save_array);
            if($result) {
                $this->redirect('/');
            }


        }

        public function test() {
            $this->autoRender = false;
            pr($this->Twitter->get());
        }

    }
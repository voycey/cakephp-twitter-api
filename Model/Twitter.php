<?php
    App::uses('AppModel', 'Model');
    App::import('Vendor', 'twitteroauth', array('file' => 'twitteroauth'.DS.'twitteroauth'.DS.'twitteroauth.php'));

    class Twitter extends AppModel {
        public $useTable = "twitter_settings";
        private $screen_name = "";


        function get_token_connection() {
            $credentials = $this->find('list', array('fields' => array('name', 'value')));
            $this->oauth_token = $credentials['oauth_token'];
            $this->oauth_token_secret = $credentials['oauth_token_secret'];
            return new TwitterOAuth(Configure::read("Twitter.consumer_key"), Configure::read("Twitter.consumer_secret"), $credentials['oauth_token'], $credentials['oauth_token_secret']);
        }

        function get($endpoint="statuses/user_timeline", $parameters = array()) {
            if(empty($parameters)) {
                $parameters = array('screen_name' => Configure::read('Twitter.screen_name'), 'count'=>5);
            }
            return $this->get_token_connection()->get($endpoint, $parameters);
        }

        function post($endpoint="statuses/update", $parameters = array('status'=>'Dans twitter plugin is awesome')) {
            return $this->get_token_connection()->post($endpoint, $parameters);
        }
    }
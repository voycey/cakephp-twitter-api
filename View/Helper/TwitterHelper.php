<?php
/**
 * Created by PhpStorm.
 * User: Dan Voyce
 * Date: 24/02/14
 * Time: 6:30 PM
 */
    App::uses('AppHelper', 'View/Helper');

    class TwitterHelper extends AppHelper {
        public function parse_tweet($tweet) {
            $text = preg_replace(
                '@(https?://([-\w\.]+)+(/([\w/_\.]*(\?\S+)?(#\S+)?)?)?)@',
                '<span><a href="$1">$1</a></span>',
                $tweet);

            //Get Usernames
            $text = preg_replace(
                '/@(\w+)/',
                '<span><a href="http://twitter.com/$1">@$1</a></span>',
                $text);

            //Get Hashtags
            $text = preg_replace(
                '/\s+#(\w+)/',
                ' <span><a href="http://search.twitter.com/search?q=%23$1">#$1</a></span>',
                $text);

            return $text;
        }

        public function time_ago($date,$granularity=1) {
            $date = strtotime($date);
            $difference = time() - $date;
            $retval = "";
            $periods = array('decade' => 315360000,
                             'year' => 31536000,
                             'month' => 2628000,
                             'week' => 604800,
                             'day' => 86400,
                             'hour' => 3600,
                             'minute' => 60);

            foreach ($periods as $key => $value) {
                if ($difference >= $value) {
                    $time = floor($difference/$value);
                    $difference %= $value;
                    $retval .= ($retval ? ' ' : '').$time.' ';
                    $retval .= (($time > 1) ? $key.'s' : $key);
                    $granularity--;
                }
                if ($granularity == '0') { break; }
            }
            return ' '.$retval.' ago';
        }


    }
CakePHP Twitter Plugin for API v1.1
=============================

CakePHP 2.x Twitter API (V1.1) Plugin

@Author Daniel Voyce<br />
@Date 24th February 2014<br />
@Requires CakePHP 2.x (Tested on 2.4.3)<br />
@Requires https://github.com/abraham/twitteroauth (Forked in my repos)<br />

A plugin that takes care of all of the OAuth authentication and then fetches an OAuth Token (These are long lived and therefore can be used to display a twitter feed on your website or create a Twitter App / Interface.

Gives a model that can be imported into your controllers to interact with any of the Twitter GET / POST endpoints.

Installation
------------

1. Install Abrahams twitteroauth library (I have forked the version I used - https://github.com/voycey/twitteroauth) into app/Vendor/twitteroauth (so you should have app/Vendor/twitteroauth/twitteroauth)
2. Clone this repository into app/Plugin/Twitter
3. Import the SQL file into your database using whatever method you prefer
4. Edit app/Plugin/Config/bootstrap.php and put in your Consumer Key and Consumer Secret that you obtained from http://dev.twitter.com and your screen name.
5. Load the plugin in bootstrap.php of your app: 

```php
CakePlugin::load(array('Twitter' => array('routes' => true, 'bootstrap' => true)) 
```

Set-up
------

Ok so now you have the files in place you need to authorise your app with twitter:

1. Go to yourdomain.com/Twitter/authorise_twitter
2. Login with your twitter details if asked if not you should be redirected back to the homepage and your app is now authorised.

##### If you weren't redirected back to the homepage then you have probably missed a step - recheck.

Usage
-----

The basic usage of this is to instantiate a copy of the model (with either loadModel or by putting it in your $uses array) and then either use the GET or POST methods provided against whichever twitter end point you want:
https://dev.twitter.com/docs/api/1.1


#### Basic Examples:

This is the simplest usage of it - the default get() method fetches the tweets of the screen name you entered in bootstrap.php

```php
$this->loadModel('Twitter.Twitter');
$twitter = $this->Twitter->get();
```

This will get a different users 7 latest tweets:

```php
$this->loadModel('Twitter.Twitter');
$twitter = $this->Twitter->get('statuses/user_timeline', array('screen_name' => 'voycey', 'count' => 7));
```

And obviously you can do POST requests aswell, This will post an awesome message to your Twitter!

```php
$this->loadModel('Twitter.Twitter');
$twitter = $this->Twitter->post();
```

This will post a custom message to your Twitter:
```php
$this->loadModel('Twitter.Twitter');
$twitter = $this->Twitter->post('statuses/update',array('status'=>'This is an awesome status message');
```

##### See the full list of endpoints at https://dev.twitter.com/docs/api/1.1

#### There are also some handy functions I have put in Twitter.Helper:

This will take the text of a tweet and parse all of the links, hashtags and usernames into links (courtesy of http://saturnboy.com/2010/02/parsing-twitter-with-regexp/), pass in the twitter->text part and it will output a
nicely formatted html snippet of the tweet.

```php
public function parse_tweet($tweet_text) {}
```

I have also added in a time calculator so you have Twitters "Posted 20h ago" or "Posted 3 days ago"

```php 
function time_ago($date,$granularity=2) {}
```



Hope this helps - feel free to use / abuse this - since Twitter took all their public access off it can be quite confusing getting started with it

#### Custom Settings Table

If you want to use your own Settings Table you can change the $useTable variable in the Twitter Model and then make sure you change lines 50 onwards of TwittersController.php to match your databsase table structure.


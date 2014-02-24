<?php
    Router::connect('/Twitter/authorise_twitter', array('plugin' => 'twitter', 'controller' => 'Twitters', 'action' => 'authorise_twitter'));
    Router::connect('/Twitter/twittercallback', array('plugin' => 'twitter', 'controller' => 'Twitters', 'action' => 'twittercallback'));
    Router::connect('/Twitter/get/*',  array('plugin' => 'twitter', 'controller' => 'Twitters', 'action' => 'get'));
    Router::connect('/Twitter/post/*',  array('plugin' => 'twitter', 'controller' => 'Twitters', 'action' => 'post'));
    Router::connect('/Twitter/test/*',  array('plugin' => 'twitter', 'controller' => 'Twitters', 'action' => 'test'));
?>
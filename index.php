<?php

require_once 'vendor/autoload.php';
require_once 'MyProcessor.php';

$igKey    = getenv('INSTAGRAM_CLIENT_ID');
$igSecret = getenv('INSTAGRAM_CLIENT_SECRET');

MyProcessor::$client_secret = $igSecret;

if (isset($_GET['hub_challenge'])) {
    echo $_GET['hub_challenge'];
} elseif( isset($_SERVER['HTTP_X_HUB_SIGNATURE'])) {
    $igdata = file_get_contents("php://input");
    if (hash_hmac('sha1', $igdata, MyProcessor::$client_secret) == $_SERVER['HTTP_X_HUB_SIGNATURE']) {
        MyProcessor::process(json_decode($igdata));
    }
} else {
    $irt = new InstagramRealTime($igKey, $igSecret, 'http://sk-instagram-watcher.herokuapp.com/');
    $r = $irt->addSubscription('tag', 'media', 'skunenieki');
    error_log(json_encode($r));
}

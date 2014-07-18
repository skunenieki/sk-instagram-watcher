<?php

require_once 'vendor/autoload.php';
require_once 'MyProcessor.php';

$igKey    = getenv('INSTAGRAM_CLIENT_ID');
$igSecret = getenv('INSTAGRAM_CLIENT_SECRET');

$igKey    = 'c234442e093a4a7c8bbd68863ade29b1';
$igSecret = 'daef6ba42fad4868ba3d6cf9cc5f8fde';

if (isset($_GET['hub_challenge'])) {
    echo $_GET['hub_challenge'];
error_log('1111');
} elseif( isset($_SERVER['HTTP_X_HUB_SIGNATURE'])) {
error_log('222');
    $igdata = file_get_contents("php://input");
    if (hash_hmac('sha1', $igdata, MyProcessor::client_secret) == $_SERVER['HTTP_X_HUB_SIGNATURE']) {
        MyProcessor::process(json_decode($igdata));
    }
} else {
    $irt = new InstagramRealTime($igKey, $igSecret, 'http://sk-instagram-watcher.herokuapp.com/');
    $r = $irt->addSubscription('tag', 'media', 'skunenieki');
    error_log(json_encode($r));
}

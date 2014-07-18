<?php

class MyProcessor extends SubscriptionProcessor {
        public static $client_secret;

	// Redefine this function
	public static function process($data){
            error_log(json_encode($data));
	}
}

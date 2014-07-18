<?php

class MyProcessor extends SubscriptionProcessor {
	const client_secret = 'YOUR API SECRET';
	// Redefine this function
	public static function process($data){
            error_log($data);
	}
}

<?php

class MyProcessor extends SubscriptionProcessor {
	const client_secret = 'YOUR API SECRET';
	// Redefine this function
	public static function process($data){
		$file = file_get_contents('/tmp/updates.instagram');
		$fulldata = $file . "\n\n" . json_encode($data);
		file_put_contents('/tmp/updates.instagram', $fulldata);
	}
}

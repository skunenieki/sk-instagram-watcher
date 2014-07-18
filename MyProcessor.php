<?php

class MyProcessor extends SubscriptionProcessor {
	public static function process($data){
            error_log(json_encode($data));
	}
}

<?php

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPConnection;

class MyProcessor extends SubscriptionProcessor {
      public static $client_secret;

      public static function process($data) {
            $exchange = 'router';
            $queue    = 'msgs';
            $port     = '5672';

            $amqpUrl = getenv('CLOUDAMQP_URL');
            $parts   = explode('/', $amqpUrl);
            $user    = $vhost = $parts[3];
            $parts   = explode('@', $parts[2]);
            $host    = $parts[1];
            $pass    = str_replace($user.':', '', $parts[0]);

            $conn = new AMQPConnection($host, $port, $user, $pass, $vhost);
            $ch = $conn->channel();

            $ch->queue_declare($queue, false, true, false, false);
            $ch->exchange_declare($exchange, 'direct', false, true, false);
            $ch->queue_bind($queue, $exchange);

            $message = array('source' => 'ig', 'data' => $data);
            $msg_body = json_encode($message);
            $msg = new AMQPMessage($msg_body, array('content_type' => 'text/plain', 'delivery_mode' => 2));
            $ch->basic_publish($msg, $exchange);

            $ch->close();
            $conn->close();
      }
}


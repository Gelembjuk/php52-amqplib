<?php

require_once dirname(__FILE__) . '/config.php';

$connection = new PhpAmqpLib_Connection_AMQPConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

// declare  exchange but don`t bind any queue
$channel->exchange_declare('hidden_exchange', 'topic');

$msg = new PhpAmqpLib_Message_AMQPMessage("Hello World!");

echo " [x] Sent non-mandatory ...";
$channel->basic_publish($msg,
    'hidden_exchange',
    'rkey');
echo " done.\n";

global $wait;
$wait = true;

$return_listener = function ($reply_code, $reply_text,
    $exchange, $routing_key, $msg) {
	    
    global $wait;
    
    $GLOBALS['wait'] = false;

    echo "return: ",
    $reply_code, "\n",
    $reply_text, "\n",
    $exchange, "\n",
    $routing_key, "\n",
    $msg->body, "\n";
};

$channel->set_return_listener($return_listener);

echo " [x] Sent mandatory ... ";
$channel->basic_publish($msg,
    'hidden_exchange',
    'rkey',
    true);
echo " done.\n";

while ($wait) {
    $channel->wait();
}

$channel->close();
$connection->close();

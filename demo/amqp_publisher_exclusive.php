<?php

require_once dirname(__FILE__) . '/config.php';

$exchange = 'fanout_exclusive_example_exchange';

$conn = new PhpAmqpLib_Connection_AMQPConnection(HOST, PORT, USER, PASS, VHOST);
$ch = $conn->channel();

/*
    name: $exchange
    type: fanout
    passive: false // don't check is an exchange with the same name exists
    durable: false // the exchange won't survive server restarts
    auto_delete: true //the exchange will be deleted once the channel is closed.
*/

$ch->exchange_declare($exchange, 'fanout', false, false, true);

$msg_body = implode(' ', array_slice($argv, 1));
$msg = new PhpAmqpLib_Message_AMQPMessage($msg_body, array('content_type' => 'text/plain'));
$ch->basic_publish($msg, $exchange);

$ch->close();
$conn->close();

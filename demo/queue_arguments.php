<?php

require_once dirname(__FILE__) . '/config.php';

$exchange = 'router';
$queue = 'haqueue';
$specific_queue = 'specific-haqueue';

$consumer_tag = 'consumer';

$conn = new PhpAmqpLib_Connection_AMQPConnection(HOST, PORT, USER, PASS, VHOST);
$ch = $conn->channel();

$ch->queue_declare('test11', false, true, false, false, false, new PhpAmqpLib_Wire_AMQPTable(array(
   "x-dead-letter-exchange" => "t_test1",
   "x-message-ttl" => 15000,
   "x-expires" => 16000
)));

$ch->close();
$conn->close();

<?php

require_once dirname(__FILE__) . '/config.php';

$source = 'my_source_exchange';
$dest = 'my_dest_exchange';

$conn = new PhpAmqpLib_Connection_AMQPConnection(HOST, PORT, USER, PASS, VHOST);
$ch = $conn->channel();

$ch->exchange_declare($source, 'topic', false, true, false);

$ch->exchange_declare($dest, 'direct', false, true, false);

$ch->exchange_bind($dest, $source);

$ch->exchange_unbind($source, $dest);

$ch->close();
$conn->close();
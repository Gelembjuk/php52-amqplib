<?php

/**
 * Usage:
 *  - Publish 100 5mb messages:
 *      php file_publish.php 100
 *  - Publish 1 5mb message:
 *      php file_publish.php
 *
 * NOTE: The script will take some time while it reads data from /dev/urandom
 */

require_once dirname(__FILE__) . '/config.php';

//suboptimal function to generate random content
function generate_random_content($bytes)
{
    $handle = @fopen("/dev/urandom", "rb");

    $buffer = '';
    if ($handle) {
        $len = 0;
        $max = $bytes;
        while ($len < $max - 1) {
            $buffer .= fgets($handle, $max - $len);
            $len = mb_strlen($buffer, 'ASCII');
        }
        fclose($handle);
    }

    return $buffer;
}

$exchange = 'file_exchange';
$queue = 'file_queue';

$conn = new PhpAmqpLib_Connection_AMQPConnection(HOST, PORT, USER, PASS, VHOST);
$ch = $conn->channel();

$ch->queue_declare($queue, false, false, false, false);
$ch->exchange_declare($exchange, 'direct', false, false, false);
$ch->queue_bind($queue, $exchange);

$max = isset($argv[1]) ? (int) $argv[1] : 1;
$msg_size = 1024 * 1024 * 5 + 1;
$msg_body = generate_random_content($msg_size);

$msg = new PhpAmqpLib_Message_AMQPMessage($msg_body);

$time = microtime(true);

// Publishes $max messages using $msg_body as the content.
for ($i = 0; $i < $max; $i++) {
    $ch->basic_publish($msg, $exchange);
}

echo microtime(true) - $time, "\n";

$ch->basic_publish(new PhpAmqpLib_Message_AMQPMessage('quit'), $exchange);

$ch->close();
$conn->close();

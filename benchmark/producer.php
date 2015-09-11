<?php

/**
 * Usage:
 *  php producer.php 10000
 * The integer arguments tells the script how many messages to publish.
 */

require_once dirname(__FILE__) . '/config.php';

$exchange = 'bench_exchange';
$queue = 'bench_queue';

$conn = new  PhpAmqpLib_Connection_AMQPConnection(HOST, PORT, USER, PASS, VHOST);
$ch = $conn->channel();

$ch->queue_declare($queue, false, false, false, false);

$ch->exchange_declare($exchange, 'direct', false, false, false);

$ch->queue_bind($queue, $exchange);

$msg_body = <<<EOT
abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz
abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz
abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz
abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz
abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz
abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz
abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz
abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz
abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz
abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyza
EOT;

$msg = new PhpAmqpLib_Message_AMQPMessage($msg_body);

$time = microtime(true);

$max = isset($argv[1]) ? (int) $argv[1] : 1;

// Publishes $max messages using $msg_body as the content.
for ($i = 0; $i < $max; $i++) {
    $ch->basic_publish($msg, $exchange);
}

echo microtime(true) - $time, "\n";

$ch->basic_publish(new PhpAmqpLib_Message_AMQPMessage('quit'), $exchange);

$ch->close();
$conn->close();

<?php

require_once dirname(__FILE__) . '/config.php';

define('CERTS_PATH',
'/git/rabbitmqinaction/av_scratchwork/openssl');

$ssl_options = array(
    'cafile' => CERTS_PATH . '/rmqca/cacert.pem',
    'local_cert' => CERTS_PATH . '/phpcert.pem',
    'verify_peer' => true
);

$conn = new PhpAmqpLib_Connection_AMQPSSLConnection(HOST, PORT, USER, PASS, VHOST, $ssl_options);

/**
 * @param PhpAmqpLib_Connection_AbstractConnection $conn
 */
function shutdown($conn)
{
    $conn->close();
}

register_shutdown_function('shutdown', $conn);

while (true) {
}

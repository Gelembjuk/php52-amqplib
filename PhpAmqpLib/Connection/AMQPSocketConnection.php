<?php

class PhpAmqpLib_Connection_AMQPSocketConnection extends PhpAmqpLib_Connection_AbstractConnection
{
    /**
     * @param AbstractConnection $host
     * @param int $port
     * @param string $user
     * @param string $password
     * @param string $vhost
     * @param bool $insist
     * @param string $login_method
     * @param null $login_response
     * @param string $locale
     * @param int $timeout
     * @param bool $keepalive
     */
    public function __construct(
        $host,
        $port,
        $user,
        $password,
        $vhost = '/',
        $insist = false,
        $login_method = 'AMQPLAIN',
        $login_response = null,
        $locale = 'en_US',
        $timeout = 3,
        $keepalive = false
    ) {
        $io = new PhpAmqpLib_Wire_IO_SocketIO($host, $port, $timeout, $keepalive);

        parent::__construct($user, $password, $vhost, $insist, $login_method, $login_response, $locale, $io);
    }
}

<?php

/**
 * @deprecated use AMQPProtocolException instead
 */
class PhpAmqpLib_Exception_AMQPException extends Exception
{
    /** @var string */
    public $amqp_reply_code;

    /** @var int */
    public $amqp_reply_text;

    /** @var \Exception */
    public $amqp_method_sig;

    /** @var array */
    public $args;

    /**
     * @param string $reply_code
     * @param int $reply_text
     * @param \Exception $method_sig
     */
    public function __construct($reply_code, $reply_text, $method_sig)
    {
        parent::__construct($reply_text, $reply_code);

        $this->amqp_reply_code = $reply_code; // redundant, but kept for BC
        $this->amqp_reply_text = $reply_text; // redundant, but kept for BC
        $this->amqp_method_sig = $method_sig;

        $ms = PhpAmqpLib_Helper_MiscHelper::methodSig($method_sig);
        $PROTOCOL_CONSTANTS_CLASS = PhpAmqpLib_Channel_AbstractChannel::$PROTOCOL_CONSTANTS_CLASS;
	
	$GLOBAL_METHOD_NAMES = $this->getStaticProperty($PROTOCOL_CONSTANTS_CLASS,'GLOBAL_METHOD_NAMES');
	
        $mn = isset($GLOBAL_METHOD_NAMES[$ms])
            ? $GLOBAL_METHOD_NAMES[$ms]
            : $mn = '';

        $this->args = array($reply_code, $reply_text, $method_sig, $mn);
    }
    /**
     * It is trick to get static property value when class name is in a variable
     * 
     * @param string Class name
     * @param string Property name
     * @return string
     * @throws PhpAmqpLib_Exception_AMQPOutOfRangeException
     */
    public static function getStaticProperty($class,$property) {
	$vars = get_class_vars($class);
	return $vars[$property];
    }
}

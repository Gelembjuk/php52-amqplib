<?php

class PhpAmqpLib_Exception_AMQPBasicCancelException extends Exception implements PhpAmqpLib_Exception_AMQPExceptionInterface
{
    /** @var string */
    public $consumerTag;

    /**
     * @param string $consumerTag
     */
    public function __construct($consumerTag)
    {
        $this->consumerTag = $consumerTag;
    }
}

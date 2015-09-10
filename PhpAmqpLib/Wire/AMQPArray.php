<?php


class PhpAmqpLib_Wire_AMQPArray extends PhpAmqpLib_Wire_AMQPAbstractCollection
{

    public function __construct(array $data = null)
    {
        parent::__construct(empty($data) ? null : array_values($data));
    }

    /**
     * @return int
     */
    final public function getType()
    {
        return self::T_ARRAY;
    }

    /**
     * @param mixed $val
     * @param null $type
     * @return $this
     */
    public function push($val, $type = null)
    {
        $this->setValue($val, $type);

        return $this;
    }
}

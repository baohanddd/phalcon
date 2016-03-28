<?php
namespace Bob\Phalcon\Exception;

class Timestamp extends \Exception
{
    protected $message = 'Invalid `%s`';
    protected $code = 4102;

    public function __construct($key)
    {
        $this->message = sprintf($this->message, $key);
        parent::__construct();
    }
}
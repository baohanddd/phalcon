<?php
namespace Bob\Phalcon\Exception;

class Type extends \Exception
{
    protected $message = "Doesn't implement `%s` yet.";
    protected $code = 4102;

    public function __construct($key)
    {
        $this->message = sprintf($this->message, $key);
        parent::__construct();
    }
}
<?php
namespace Baohanddd\Request\Input\Exception;


class InvalidOperator extends \Exception
{
    protected $message = 'Invalid operator: %s';
    protected $code = 4104;

    public function __construct($key)
    {
        $this->message = sprintf($this->message, (string) $key);
    }
}
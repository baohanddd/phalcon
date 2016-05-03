<?php
namespace App\Component\Request\Input\Exception;


class Enum extends \Exception
{
    protected $message = 'The `%s` is not a specified value';
    protected $code = 4105;

    public function __construct($key)
    {
        $this->message = sprintf($this->message, $key);
    }
}
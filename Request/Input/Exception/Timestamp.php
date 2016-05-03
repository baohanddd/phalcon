<?php
namespace App\Component\Request\Input\Exception;


class Timestamp extends \Exception
{
    protected $message = 'The `%s` is invalid timestamp';
    protected $code = 4103;

    public function __construct($key)
    {
        $this->message = sprintf($this->message, $key);
    }
}
<?php
namespace Bob\Phalcon\Exception;

class Required extends \Exception
{
    protected $message = '`%s` is required';
    protected $code = 4101;

    public function __construct($key)
    {
        $this->message = sprintf($this->message, $key);
        parent::__construct();
    }
}
<?php
namespace Bob\Phalcon\Exception;

class Exist extends \Exception
{
    protected $code = 4031;

    public function __construct($message)
    {
        $this->message = $message;
        parent::__construct();
    }
}
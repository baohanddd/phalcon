<?php
namespace App\Component\Request\Input\Exception;


class Required extends \Exception
{
    protected $message = 'The %s must supplied';
    protected $code = 4101;

    public function __construct($key)
    {
        $this->message = sprintf($this->message, $key);
        parent::__construct();
    }
}
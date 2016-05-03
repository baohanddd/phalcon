<?php
namespace App\Component\Request\Exception;


class Create extends \Exception
{
    protected $message = 'Fails to create %s, due to %s';
    protected $code = 4200;

    public function __construct($key, $error)
    {
        $this->message = sprintf($this->message, $key, $error);
        parent::__construct();
    }
}
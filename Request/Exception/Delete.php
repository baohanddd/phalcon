<?php
namespace App\Component\Request\Exception;


class Delete extends \Exception
{
    protected $message = 'Fails to delete %s';
    protected $code = 4202;

    public function __construct($key)
    {
        $this->message = sprintf($this->message, $key);
        parent::__construct();
    }
}
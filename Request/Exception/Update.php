<?php
namespace Baohanddd\Request\Exception;


class Update extends \Exception
{
    protected $message = 'Fails to update %s, due to %s';
    protected $code = 4201;

    public function __construct($key, $error)
    {
        $this->message = sprintf($this->message, $key, $error);
        parent::__construct();
    }
}
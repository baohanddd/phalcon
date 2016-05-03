<?php
namespace App\Component\Request\Input\Exception;


class MongoId extends \Exception
{
    protected $message = 'The "%s" is invalid formation of mongo id';
    protected $code = 4102;

    public function __construct($key)
    {
        $this->message = sprintf($this->message, $key);
        parent::__construct();
    }
}
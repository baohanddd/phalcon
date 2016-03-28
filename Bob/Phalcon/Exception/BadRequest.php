<?php
namespace Bob\Phalcon\Exception;

class BadRequest extends \Exception
{
    protected $message = 'The %s params missing or invalid';
    protected $code = 4102;

    public function __construct($model)
    {
        $name = get_class($model);
        $this->message = sprintf($this->message, $name);
        parent::__construct();
    }
}
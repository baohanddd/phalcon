<?php
namespace Bob\Phalcon\Exception\Filter;

class MongoId extends \Exception
{
    protected $message = 'The value: "%s" is invalid formation of mongo id';
    protected $code = 4101;

    public function __construct($value)
    {
        $this->message = sprintf($this->message, $value);

        parent::__construct();
    }
}
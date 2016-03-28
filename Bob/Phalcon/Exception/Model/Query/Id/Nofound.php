<?php
namespace Bob\Phalcon\Exception\Model\Query\Id;

class Nofound extends \Exception
{
    protected $message = 'can not found %s by id = %s';
    protected $code = 4004;

    public function __construct($class, $id)
    {
        $this->message = sprintf($this->message, $class, $id);

        parent::__construct();
    }
}
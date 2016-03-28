<?php
namespace Bob\Phalcon\Exception;

class Increment extends \Exception
{
    protected $message = 'can not increase %s to %d on %s';
    protected $code = 4021;

    public function __construct($model, array $pair)
    {
        foreach($pair as $k => $v);

        $name = get_class($model);

        $this->message = sprintf($this->message, $k, $v, $name);

        parent::__construct();
    }
}
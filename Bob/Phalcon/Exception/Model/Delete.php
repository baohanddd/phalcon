<?php
namespace Bob\Phalcon\Exception\Model;

class Delete extends \Exception
{
    protected $message = 'Fails to delete model %s = %s';
    protected $code = 4002;

    public function __construct($class, $id)
    {
        $this->message = sprintf($this->message, $class, $id);

        parent::__construct();
    }
}
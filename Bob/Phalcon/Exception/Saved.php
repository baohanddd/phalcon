<?php
namespace Bob\Phalcon\Exception;

class Saved extends \Exception
{
    protected $code = 4001;

    public function __construct($model)
    {
        $this->message = $model->getMessages()[0]->getMessage();
        parent::__construct();
    }
}
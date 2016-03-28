<?php
namespace Bob\Phalcon\Model\Traits;

use Phalcon\DI;

trait Id
{
    public function getId()
    {
        return (string) parent::getId();
    }
}
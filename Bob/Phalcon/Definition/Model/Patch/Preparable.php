<?php
namespace Bob\Phalcon\Definition\Model\Patch;

interface Preparable
{
    /**
     * to get status of ready
     *
     * @return array
     */
    public function already(\Bob\Phalcon\Definition\Id $user);
}
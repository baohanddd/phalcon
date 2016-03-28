<?php
namespace Bob\Phalcon\Definition\Model\Patch;

interface Includable
{
    /**
     * @return array
     */
    public function only();
}
<?php
namespace Bob\Phalcon\Definition\Model\Patch;

interface Pathable
{
    /**
     * Get fields need to patch
     *
     * @return array
     */
    public function path();
}
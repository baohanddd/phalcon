<?php
namespace Bob\Phalcon\Definition\Model\Patch;

interface Mergable
{
    /**
     * Return which fields need to be merged into where
     *
     * @return array
     */
    public function merge();
}
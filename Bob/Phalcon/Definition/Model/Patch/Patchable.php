<?php
namespace Bob\Phalcon\Definition\Model\Patch;

interface Patchable
{
    /**
     * To patch model
     *
     * @return array
     */
    public function patch();
}
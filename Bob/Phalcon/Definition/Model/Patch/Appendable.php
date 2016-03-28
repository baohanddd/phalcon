<?php
namespace Bob\Phalcon\Definition\Model\Patch;

interface Appendable
{
    /**
     * Get fields need to append
     *
     * @return array
     */
    public function append();
}
<?php
namespace Bob\Phalcon\Definition\Model\Patch;

interface Prependable
{
    /**
     * Get fields need to prepend
     * @example
     *   ['tags' => ['map.tag.user.response' => [['user_id' => $this->getId()], ['created' => -1], 10]]]
     *
     * @return array
     */
    public function prepend();
}
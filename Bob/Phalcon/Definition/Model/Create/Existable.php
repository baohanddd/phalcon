<?php
namespace Bob\Phalcon\Definition\Model\Create;

interface Existable
{
    /**
     * query condition to check existent
     *
     * @example
     *  return ['gaode_id' => $this->gaode_id];
     *  return ['$or' => [
     *    [key1 => val1],
     *    [key2 => val2],
     *  ]]
     *
     * @return array
     */
    public function existent();
}
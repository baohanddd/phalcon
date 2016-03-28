<?php
namespace Bob\Phalcon\Definition\Model\Count;


interface Cachable
{
    /**
     * @return string cache key
     */
    public function key();

    /**
     * @return string model class name
     */
    public function source();

    /**
     * Clean cache
     * @return void
     */
    public function clean();

    /**
     * @example
     *  class::count([$query]);
     * @param array $query
     * @return int
     */
    public static function count(array $query);
}
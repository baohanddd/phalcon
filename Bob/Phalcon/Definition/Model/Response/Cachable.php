<?php
namespace Bob\Phalcon\Definition\Model\Response;


interface Cachable
{
    /**
     * @return string model class name
     */
    public static function source();

    /**
     * @param $id
     * @return mixed
     */
    public static function findById($id);

    /**
     * @param \Bob\Phalcon\Definition\Model\Collection $model
     * @return mixed
     */
    public static function clean(\Bob\Phalcon\Definition\Model\Collection $model);

    /**
     * @return int second time to live
     */
    public static function ttl();
}
<?php
namespace Bob\Phalcon\Definition\Model;


interface Callbackable
{
    /**
     * @return array
     */
    public static function events();

    /**
     * @param \Phalcon\Events\Event $event
     * @param \Bob\Phalcon\Definition\Model\Collection $model
     * @return mixed
     */
    public static function call(\Phalcon\Events\Event $event, \Bob\Phalcon\Definition\Model\Collection $model);
}
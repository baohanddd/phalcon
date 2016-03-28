<?php
namespace Bob\Phalcon\Model\Behavior;

use Phalcon\Mvc\Collection\Behavior;
use Phalcon\Mvc\Collection\BehaviorInterface;

class Timestamp extends Behavior implements BehaviorInterface
{
    public function notify($type, \Phalcon\Mvc\CollectionInterface $model)
    {
        switch ($type) {

            case 'beforeCreate':

                if(property_exists($model, 'created'))  $model->created  = new \MongoDate();
                if(property_exists($model, 'modified')) $model->modified = new \MongoDate();
                break;

            case 'beforeUpdate':

                if(property_exists($model, 'modified')) $model->modified = new \MongoDate();
                break;

            default:
                /* ignore the rest of events */
        }
    }
}
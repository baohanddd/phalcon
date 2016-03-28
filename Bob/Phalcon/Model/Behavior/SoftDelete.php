<?php
namespace Bob\Phalcon\Model\Behavior;

use Phalcon\Mvc\Collection\Behavior;
use Phalcon\Mvc\Collection\BehaviorInterface;

class SoftDelete extends Behavior implements BehaviorInterface
{
    public function notify($type, \Phalcon\Mvc\CollectionInterface $model)
    {
        switch ($type) {

            case 'beforeDelete':

                $model->skipOperation(true);

                $model->getCollection()->update(
                    ['_id'  => new \MongoId($model->getId())],
                    ['$set' => ['deleted' => 1]]
                );

                if($model->fireEventCancel("afterDelete") === false) {
                    return false;
                }

                break;

            default:
                /* ignore the rest of events */
        }
    }
}
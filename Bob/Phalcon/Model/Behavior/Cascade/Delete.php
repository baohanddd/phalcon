<?php
namespace Bob\Phalcon\Model\Behavior\Cascade;

use Phalcon\Mvc\Collection\Behavior;
use Phalcon\Mvc\Collection\BehaviorInterface;
use Phalcon\DI;

class Delete extends Behavior implements BehaviorInterface
{
    public function notify($type, \Phalcon\Mvc\CollectionInterface $model)
    {
        switch ($type) {

            case 'afterDelete':
                if(!$model instanceof \Bob\Phalcon\Definition\Model\Delete\Cascadable) return ;

                $fetch     = DI::getDefault()->get('fetch');
                $callbacks = $model->deleteCascade();

                foreach($callbacks as $model => $query) {
                    foreach(explode('.', $model) as $name) $fetch->setNamespace($name);
                    foreach($fetch->by($query) as $model)  $model->delete();
                }
                break;

            default:
                /* ignore the rest of events */
        }
    }
}
<?php
namespace Bob\Phalcon\Model\Behavior\Cascade;

use Phalcon\Mvc\Collection\Behavior;
use Phalcon\Mvc\Collection\BehaviorInterface;
use Phalcon\DI;

class Create extends Behavior implements BehaviorInterface
{
    public function notify($type, \Phalcon\Mvc\CollectionInterface $model)
    {
        switch ($type) {

            case 'afterCreate':
                if(!$model instanceof \Bob\Phalcon\Definition\Model\Create\Cascadable) return ;

                $fetch     = DI::getDefault()->get('fetch');
                $callbacks = $model->createCascade();

                foreach($callbacks as $model => $data) {
                    foreach (explode('.', $model) as $name) $fetch->setNamespace($name);
                    $fetch->create($data);
                }
                break;

            default:
                /* ignore the rest of events */
        }
    }
}
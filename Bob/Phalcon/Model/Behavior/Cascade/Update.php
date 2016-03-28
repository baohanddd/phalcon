<?php
namespace Bob\Phalcon\Model\Behavior\Cascade;

use Phalcon\Mvc\Collection\Behavior;
use Phalcon\Mvc\Collection\BehaviorInterface;
use Phalcon\DI;

class Update extends Behavior implements BehaviorInterface
{
    public function notify($type, \Phalcon\Mvc\CollectionInterface $model)
    {
        switch ($type) {

            case 'afterSave':
                if(!$model instanceof \Bob\Phalcon\Definition\Model\Update\Cascadable) return ;

                $fetch     = DI::getDefault()->get('fetch');
                $callbacks = $model->updateCascade();

                foreach($callbacks as $model => $param) {
                    list($data, $query) = $param;
                    foreach (explode('.', $model) as $name) $fetch->setNamespace($name);
                    $fetch->update($query, $data);
                }
                break;

            default:
                /* ignore the rest of events */
        }
    }
}
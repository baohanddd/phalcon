<?php
namespace Bob\Phalcon\Model\Behavior;

use Phalcon\Mvc\Collection\Behavior;
use Phalcon\Mvc\Collection\BehaviorInterface;
use Phalcon\DI;

class Incremental extends Behavior implements BehaviorInterface
{
    public function notify($type, \Phalcon\Mvc\CollectionInterface $model)
    {
        switch ($type) {

            case 'afterCreate':
                $this->step($model, $type);
                break;

            case 'beforeUpdate':
                $this->step($model, $type);
                break;

            case 'afterUpdate':
                $this->step($model, $type);
                break;

            case 'afterDelete':
                $this->step($model, $type);
                break;

            default:
                /* ignore the rest of events */
        }
    }

    private function step($model, $type)
    {
        if(!$model instanceof \Bob\Phalcon\Definition\Model\Incremental) return ;
        $callbacks = $model->increment();

        if(isset($callbacks[$type]))
        {
            $fetch = DI::getDefault()->get('fetch');
            foreach($callbacks[$type] as $class => $pair)
            {
                list($field, $update) = $pair;
                if($type == 'beforeUpdate') {
                    $path = get_class($model);
                    $prev = $path::findById($model->getId());
                    if(!isset($prev->$field)) continue;
                    $id = $prev->$field;
                } else {
                    if(!isset($model->$field) or !$model->$field) continue;
                    $id = $model->$field;
                }
                foreach(explode('.', $class) as $v) $fetch->setNamespace($v);
                $fetch->incr($id, $update);
            }
        }
    }
}
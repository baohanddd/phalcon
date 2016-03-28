<?php
namespace Bob\Phalcon\Model\Behavior;

use Phalcon\Mvc\Collection\Behavior;
use Phalcon\Mvc\Collection\BehaviorInterface;
use Phalcon\DI;

class CountCache extends Behavior implements BehaviorInterface
{
    public function notify($type, \Phalcon\Mvc\CollectionInterface $model)
    {
        switch ($type) {

            case 'afterCreate':
            case 'afterDelete':
            case 'afterUpdate':

                $this->updateCache($model);

                break;

            default:
                /* ignore the rest of events */
        }
    }

    private function updateCache($model)
    {
        if($model instanceof \Bob\Phalcon\Definition\Model\CountCachable)
        {
            $class = get_class($model);
            $redis = DI::getDefault()->get('redis');
            foreach($model->countQueries() as $query) {
                $redis->hDel($class, $query);
            }
        }
    }
}
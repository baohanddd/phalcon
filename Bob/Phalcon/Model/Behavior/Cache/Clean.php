<?php
namespace Bob\Phalcon\Model\Behavior\Cache;

use Phalcon\Mvc\Collection\Behavior;
use Phalcon\Mvc\Collection\BehaviorInterface;
use Phalcon\DI;

class Clean extends Behavior implements BehaviorInterface
{
    public function notify($type, \Phalcon\Mvc\CollectionInterface $model)
    {
        switch ($type) {

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
        $cache = DI::getDefault()->get('cache');
        $key   = '\\' . static::class . RDS . $model->getId();
        $cache->delete($key);
    }
}
<?php
namespace Bob\Phalcon\Model\Behavior;

use Bob\Phalcon\Exception\Exist;
use Phalcon\Mvc\Collection\Behavior;
use Phalcon\Mvc\Collection\BehaviorInterface;
use Phalcon\DI;

class Existent extends Behavior implements BehaviorInterface
{
    private $message;

    public function notify($type, \Phalcon\Mvc\CollectionInterface $model)
    {
        switch ($type) {

            case 'beforeCreate':

                if($this->check($model)) {
                    throw new Exist($this->message);
                }
                break;

            case 'beforeUpdate':

                if($this->check($model, false)) {
                    throw new Exist($this->message);
                }
                break;

            default:
                /* ignore the rest of events */
        }
    }

    /**
     * @param $model
     * @param bool|true $create
     * @return bool
     */
    private function check($model, $create = true)
    {
        if($model instanceof \Bob\Phalcon\Definition\Model\Create\Existable) {
            $class = get_class($model);
            $query = $model->existent();
            $this->message = $this->message($query);
            if(!$create) {
                $query['_id'] = ['$ne' => new \MongoId($model->getId())];
            }
            return $class::count([$query]) > 0;
        }
    }

    /**
     * @param $query
     * @return string
     */
    private function message($query)
    {
        $keys = [];
        if(isset($query['$or'])) {
            foreach($query['$or'] as $item) {
                foreach($item as $key => $val) {
                    $keys[] = $key;
                }
            }
        } else {
            foreach($query as $key => $val) {
                $keys[] = $key;
            }
        }

        $keys = array_map(function($key){ return "`$key`"; }, $keys);
        return sprintf('It has value exist on %s', implode(' or ', $keys));
    }
}
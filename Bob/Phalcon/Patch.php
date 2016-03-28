<?php
namespace Bob\Phalcon;

/**
 *
 * @todo rename to model or another one
 * @author baohanddd@gmail.com
 * @package Bob\Phalcon
 */
class Patch
{
    /**
     * @var \Phalcon\Di
     */
    protected $_di;

    protected $rules = array();

    private $cfg = [];

    public function __construct(\Phalcon\Di $di)
    {
        $this->_di   = $di;
        $this->cfg   = $this->_di->get('config');
    }

    /**
     * @example $this->patch->setRules('reply_user_id', 'user', 'replier');
     * @param string $key
     * @param string $model
     * @param string $name
     */
    public function setRules($key, $model, $name = '')
    {
        $this->rules[$key] = [$model, $name?:$model];
    }

    /**
     * @description
     *   [model => [field => [queries]]]
     * @example
     *  $this->patch->append($items);
     * @example
     *  ['map.user.topic' => ['watching' => ['topic_id' => $this->getId(), 'user_id' => $user->getId()]]]
     *
     * @deprecated
     */
    public function already(&$item)
    {
        if(!$item instanceof \Bob\Phalcon\Definition\Model\Patch\Preparable) return ;
        $fetch  = $this->_di->get('fetch');
        $token  = $this->_di->get('token');
        $rule   = $item->already($token);

        foreach($rule as $model => $pairs) {
            foreach($pairs as $field => $query) ;
            foreach(explode('.', $model) as $v) $fetch->setNamespace($v);
            $item->$field = $fetch->count($query) > 0;
        }
    }

    /**
     * @description
     *   [field, ... n]
     * @example
     *  $this->patch->trim($items);
     * @example
     *  ['created']
     *
     * @deprecated
     */
    public function trim(&$item)
    {
        if(!$item instanceof \Bob\Phalcon\Definition\Model\Patch\Trimable) return ;
        $rule = $item->trim();
        foreach($rule as $field) unset($item->$field);
    }

    /**
     * @example
     *  $this->patch->append($items);
     * @example
     *  ['cache.article' => 'article', 'thrown' => true]
     *  ['cache.article' => 'article', 'thrown' => false]
     *
     * @deprecated
     */
    public function append(&$item)
    {
        if(!$item instanceof \Bob\Phalcon\Definition\Model\Patch\Appendable) return ;
        $fetch  = $this->_di->get('fetch');
        $rule   = $item->append();

        foreach($rule as $key => $pairs) {
            $value = (string) $item->$key;
            if($value) {
                foreach($pairs as $model => $name) break;
                foreach(explode('.', $model) as $v) $fetch->setNamespace($v);
                $item->$name = $fetch->byId($value);
            }
        }
    }

    /**
     * @example $this->path($item)
     * @param array $item
     */
    public function path(&$item)
    {
        if(!$item instanceof \Bob\Phalcon\Definition\Model\Patch\Pathable) return ;
        $rules = $item->path();
        foreach($rules as $key => $cfg) {
            $val = $item->$key;
            if($val) {
                if(is_array($val)) {
                    foreach($item->$key as &$v) $v = $this->cfg->path[$cfg] . $v;
                } else {
                    $item->$key = $this->cfg->path[$cfg] . $val;
                }
            }
        }
    }

    /**
     * Extract specified key value from collection
     *
     * @param AppCollection $item
     */
    public function extract(&$item)
    {
        if(!$item instanceof \Bob\Phalcon\Definition\Model\Patch\Extractable) return ;
        $param = $item->extract();
        foreach($param as $field => $includes) ;

        if(isset($item->$field) && $item->$field) {
            $item = $item->$field;
            if($includes) {
                foreach(array_keys(get_object_vars($item)) as $k) {
                    if(!in_array($k, $includes)) unset($item->$k);
                }
            }
        }
    }

    /**
     * @param AppCollection $item
     */
    public function only(&$item)
    {
        if(!$item instanceof \Bob\Phalcon\Definition\Model\Patch\Includable) return ;
        $includes = $item->only();
        foreach((array) $item as $field => $value) {
            if(!isset($includes[$field])) unset($item->$field);
        }
    }

    public function total(&$item)
    {
        if(!$item instanceof \Bob\Phalcon\Definition\Model\Patch\Countable) return ;
        $rule = $item->total();
        $fetch = $this->_di->get('fetch');
        foreach($rule as $field => $pair) {
            foreach($pair as $class => $query) ;
            foreach(explode('.', $class) as $v) $fetch->setNamespace($v);
            $item->$field = $fetch->count($query);
        }
    }

    public function prepend(&$item)
    {
        if(!$item instanceof \Bob\Phalcon\Definition\Model\Patch\Prependable) return ;
        $rule  = $item->prepend();
        $fetch = $this->_di->get('fetch');
        foreach($rule as $field => $pair) {
            foreach($pair as $model => $queries) ;
            $query = $queries[0];
            $sort  = $queries[1];
            $limit = $queries[2];
            foreach(explode('.', $model) as $v) $fetch->setNamespace($v);
            $fetch->setLimit($limit);
            $item->$field = $fetch->by($query, $sort);
        }
    }

    public function merge(&$item)
    {
        if(!$item instanceof \Bob\Phalcon\Definition\Model\Patch\Mergable) return ;
        $rules = $item->merge();
        foreach($rules as $destination => $fields) {
            foreach($fields as $f)
                if(isset($item->$f)) $item->$destination->$f = $item->$f;
        }
    }
}
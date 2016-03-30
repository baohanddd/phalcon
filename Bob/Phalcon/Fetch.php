<?php
namespace Bob\Phalcon;

class Fetch
{
    /**
     * @var \Phalcon\Di
     */
    protected $_di;

    protected $patch;

    protected $request;

    protected $redis;

    protected $namespaces = array();

    protected $modes   = array();

    protected $patches = array();

    /**
     * default page number
     *
     * @var int
     */
    private $page = 1;

    /**
     * default limit
     *
     * @var int
     */
    private $limit = 10;
    
    public function __construct(\Phalcon\Di $di)
    {
        $this->_di = $di;
        $this->patch = $di->get('patch');
        $this->redis = $di->get('cache');
        $this->request = $di->get('request');
    }

    public function attach($action)
    {
        $this->modes[$action] = true;
    }

    public function __get($name)
    {
        $this->namespaces[] = $name;
        return $this;
    }

    public function setNamespace($name)
    {
        $this->namespaces[] = $name;
    }

    public function getNamespace()
    {
        return $this->namespaces;
    }

    /**
     * Create new model
     *
     * @param $data
     * @return \Bob\Phalcon\Definition\Model\Collection|bool
     * @throws \Bob\Phalcon\Exception\Saved
     */
    public function create($data)
    {
        $thrown = $this->hasThrown();
        $class  = $this->getClass();
        $model  = new $class();

        foreach($data as $k => $v) {
            if(property_exists($model, $k))
                $model->$k = $v;
        }

        if(!$model->save()) {
            if($thrown) throw new \Bob\Phalcon\Exception\Saved($model);
            return false;
        }
        return $model;
    }

    /**
     * Update model
     *
     * @param \Bob\Phalcon\Definition\Model\Collection $model
     * @param Collection $data
     * @return bool
     * @throws \Bob\Phalcon\Exception\Saved
     */
    public function update(\Bob\Phalcon\Definition\Model\Collection $model, Collection $data)
    {
        $thrown = $this->hasThrown();

        foreach($data as $k => $v) {
            if(property_exists($model, $k))
                $model->$k = $v;
        }

        $this->initNS();

        if(!$model->save()) {
            if($thrown) throw new \Bob\Phalcon\Exception\Saved($model);
            return false;
        }
        return true;
    }

    private function initNS()
    {
        $this->namespaces = [];
    }

    /**
     * @param \Bob\Phalcon\Definition\Model\Collection $model
     * @return bool
     * @throws \Bob\Phalcon\Exception\Saved
     */
    public function delete(\Bob\Phalcon\Definition\Model\Collection $model)
    {
        $thrown = $this->hasThrown();

        $this->initNS();

        if(!$model->delete()) {
            if($thrown) throw new \Bob\Phalcon\Exception\Saved($model);
            return false;
        }
        return true;
    }

    /**
     * @param $id
     * @param array $pair
     * @throws \Bob\Phalcon\Exception\Increment
     */
    public function incr($id, array $pair)
    {
        $class = $this->getClass();
        $self = new $class();
        $col = $self->getCollection();

        $cond['_id'] = new \MongoId($id);

        foreach($pair as $k => $v) ;
        $cond = ['_id' => new \MongoId($id)];
        if ($v < 0) $cond[$k] = ['$gte' => abs($v)];

        $ret = $col->update($cond, array('$inc' => array($k => $v)));
        if(!$ret) throw new \Bob\Phalcon\Exception\Increment($class, $pair);

        $this->redis->delete($class . RDS . $id);
    }

    /**
     * @param $id
     * @param array $pair
     * @throws \Bob\Phalcon\Exception\Increment
     */
    public function decr($id, array $pair)
    {
        $class = $this->getClass();
        $self = new $class();
        $col = $self->getCollection();

        $cond['_id'] = new \MongoId($id);

        foreach($pair as $k => $v) ;
        $cond = ['_id' => new \MongoId($id)];

        $ret = $col->update($cond, array('$inc' => array($k => -abs($v))));
        if(!$ret) throw new \Bob\Phalcon\Exception\Increment($class, $pair);

        $this->redis->delete($class . RDS . $id);
    }

    /**
     * @example
     *   $this->fetch->article->thrown->byId($id);
     * @param $id
     * @return mixed
     * @throws \Bob\Phalcon\Exception\Model\Query\Id\Nofound
     */
    public function byId($id)
    {
        $thrown = $this->hasThrown();
        $model  = $this->getById($id, $thrown);
        $this->patching($model);
        $this->initPatch();

        return $model;
    }

    /**
     * @example
     *  $this->fetch->match->thrown->already->prepend->first($query);
     * @param array|\Bob\Phalcon\Collection $query
     * @param array $sort
     * @return mixed
     * @throws \Bob\Phalcon\Exception\Model\Query\First\Nofound
     */
    public function first($query = null, $sort = [])
    {
        if(!$query) {
            $query = [];
        } else if ($query instanceof \Bob\Phalcon\Collection) {
            $query = $query->toArray();
        }

        $thrown = $this->hasThrown();
        $path   = $this->getClass();
        $model  = $path::findFirst([
            'conditions' => $query,
            'sort'       => $sort
        ]);
        if(!$model && $thrown) throw new \Bob\Phalcon\Exception\Model\Query\First\Nofound($path, $query);
        if($model) $this->patching($model);
        $this->initPatch();
        return $model;
    }

    public function by($query, $sort = [])
    {
        $thrown = $this->hasThrown();
        $path = $this->getClass();
        $cols = $path::find([
            'conditions' => $query,
            'sort' => $sort,
            'skip' => $this->getSkip(),
            'limit' => $this->getLimit()
        ]);

        if(!$cols && $thrown) throw new \Bob\Phalcon\Exception\Model\Query\Find\Nofound($path, $query);
        foreach($cols as &$col) $this->patching($col);
        $this->initPatch();

        return $cols;
    }

    public function count($query)
    {
        $path = $this->getClass();
        if(isset($query['location'])) unset($query['location']);
        return $path::count([$query]);
    }

    public function setPage($page)
    {
        $this->page = $page;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    private function getPage()
    {
        $page = $this->request->getQuery('page', 'int!')?:$this->page;
        return $page > 0 ? $page : 1;
    }

    private function getLimit()
    {
        $limit = $this->request->getQuery('limit', 'int!')?:$this->limit;
        return $limit > 0 ? $limit : 20;
    }

    private function getSkip()
    {
        return ($this->getPage() - 1) * $this->getLimit();
    }

    /**
     * @param $id
     * @param bool|false $thrown
     * @return mixed
     * @throws \Bob\Phalcon\Exception\Model\Query\Id\Nofound
     */
    private function getById($id, $thrown = false)
    {
        $cached = $this->hasCache();
        $class = $this->getClass();

        if($cached) {
            $key = $class . RDS . $id;
            $model = $this->redis->get($key);
            if (!$model) {
                $model = $class::findById($id);
                if($model) $this->redis->save($key, $model);
            }
        } else {
            $model = $class::findById($id);
        }

        if (!$model && $thrown)
            throw new \Bob\Phalcon\Exception\Model\Query\Id\Nofound($class, $id);

        return $model;
    }

    /**
     * @return string
     */
    private function getClass()
    {
        $path = '\App\Model';
        foreach($this->namespaces as $class) {
            if($class == 'cache')    continue;
            if($class == 'thrown')   continue;
            if(isset($this->modes[$class])) {
                $this->patches[$class] = true;
                continue;
            }

            $path .= '\\';
            $path .= ucfirst($class);
        }
        $this->initNS();
        return $path;
    }

    private function hasCache()
    {
        return in_array('cache', $this->namespaces);
    }

    private function hasThrown()
    {
        return in_array('thrown', $this->namespaces);
    }

    private function patching(&$model)
    {
        foreach($this->patches as $action => $enable)
            $this->patch->$action($model);
    }

    private function initPatch()
    {
        $this->patches = [];
    }

}
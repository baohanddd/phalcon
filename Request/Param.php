<?php
namespace Baohanddd\Request;


use Baohanddd\Request\Collection\Collection;
use Baohanddd\Request\Input\Base;
use App\Model\AppCollection;

class Param
{
    /**
     * @var Loader
     */
    private $l;

    /**
     * @var Collection
     */
    private $in;

    /**
     * @var Collection
     */
    private $result;

    /**
     * @var Collection
     */
    private $sort;

    /**
     * @var AppCollection
     */
    private $model;

    /**
     * @var string
     */
    private $err;

    public function __construct(Collection $inputData)
    {
        $this->in     = $inputData;
        $this->result = new Collection();
        $this->sort   = new Collection();
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->in->$name;
    }

    /**
     * @param $name
     * @return Model
     */
    public function getModel($name)
    {
        return new Model($this, $name);
    }

    /**
     * @param $key
     * @return Base
     */
    public function param($key)
    {
        return new Base($this->in, $this->result, $key);
    }

    /**
     * @param $key
     * @return Base
     */
    public function sort($key)
    {
        $new = str_replace('sort_', '', $key);
        $this->in->$new = $this->in->$key;
        return new Base($this->in, $this->sort, $new);
    }

    /**
     * @param $key
     * @return Base
     */
    public function range($key)
    {
        $new = str_replace('range_', '', $key);
        $this->in->$new = $this->in->$key;
        return new Base($this->in, $this->result, $new);
    }

    /**
     * @param $key
     */
    public function page($key)
    {
        $this->in->page = intval($key);
    }

    /**
     * @param $key
     */
    public function limit($key)
    {
        $this->in->limit = intval($key);
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return (int) $this->in->page?:1;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return (int) $this->in->limit?:10;
    }

    /**
     * @return int
     */
    public function getSkip()
    {
        return ($this->getPage() - 1) * $this->getLimit();
    }

    /**
     * @return array
     */
    public function getResult()
    {
        return $this->result->all();
    }

    /**
     * @return array
     */
    public function getSort()
    {
        return $this->sort->all();
    }
}
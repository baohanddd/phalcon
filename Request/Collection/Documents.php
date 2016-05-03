<?php
namespace Baohanddd\Request\Collection;

use Baohanddd\Request\Collection\Exception\Nofound;

class Documents extends Collection
{

    /**
     * @var Model
     */
    private $model;

    /**
     * @param Model $m
     */
    public function setModel(Model $m)
    {
        $this->model = $m;
    }

    /**
     * @return $this
     * @throws Nofound
     */
    public function must()
    {
        if($this->count() == 0) throw new Nofound($this->model->getClass());
        return $this;
    }
}
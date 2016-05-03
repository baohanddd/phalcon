<?php
namespace Baohanddd\Request;


use Baohanddd\Request\Collection\Documents;
use Baohanddd\Request\Exception\Nofound;
use Baohanddd\Request\Loader\Factory;
use App\Model\AppCollection;

class Model
{
    /**
     * @var Param
     */
    private $param;

    /**
     * @var string
     */
    private $class;

    /**
     * To check empty or not?
     *
     * @var bool
     */
    private $chkEmpty = false;

    /**
     * @var string
     */
    private $err = "";

    /**
     * @var AppCollection
     */
    private $model;

    public function __construct(Param $p, $name)
    {
        $f = new Factory();
        $l = $f->model();
        $l->setPath($name);
        $this->class = $l->getClass();
        $this->param = $p;
    }

    /**
     * @return $this
     * @throws Nofound
     */
    public function chkEmpty()
    {
        $this->chkEmpty = true;
        return $this;
    }

    /**
     * @param $id
     * @return Documents
     */
    public function id($id)
    {
        $class = $this->class;
        $this->model = new $class;

        $item = $this->model->findById($id);

        if($item) $d = new Documents([$item]);
        else      $d = new Documents();

        $this->afterFind($d);

        return $d;
    }

    /**
     * @return Documents
     */
    public function find()
    {
        $class = $this->class;

        $query = [
            'conditions' => $this->param->getResult(),
            'sort'       => $this->param->getSort(),
            'skip'       => $this->param->getSkip(),
            'limit'      => $this->param->getLimit()
        ];

        $items = $class::find($query);

        if($items) $d = new Documents($items);
        else       $d = new Documents();

        $this->afterFind($d);

        return $d;
    }

    /**
     * @return int
     */
    public function count()
    {
        $class = $this->class;
        return $class::count([$this->param->getResult()]);
    }

    /**
     * @return Documents
     */
    public function first()
    {
        $class = $this->class;

        $query = [
            'conditions' => $this->param->getResult(),
            'sort'       => $this->param->getSort(),
        ];
        $item = $class::findFirst($query);

        if($item) $d = new Documents([$item]);
        else      $d = new Documents();

        $this->afterFind($d);

        return $d;
    }

    /**
     * @return bool
     */
    public function create()
    {
        $class = $this->class;
        $this->model = new $class;

        $saved = $this->param->getResult();

        foreach($saved as $key => $val)
        {
            if(!property_exists($this->model, $key)) continue;
            $this->model->$key = $val;
        }

        if(!$this->model->save())
        {
            $this->err = $this->model->error();
            return false;
        }

        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    public function update($id)
    {
        $class = $this->class;

        $this->model = $class::findById($id);

        if(!$this->model)
        {
            $this->err = 'Invalid id';
            return false;
        }

        $saved = $this->param->getResult();

        foreach($saved as $key => $val)
        {
            if(!property_exists($this->model, $key)) continue;
            $this->model->$key = $val;
        }

        if(!$this->model->save())
        {
            $this->err = $this->model->error();
            return false;
        }

        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $class = $this->class;

        $this->model = $class::findById($id);

        if(!$this->model)
        {
            $this->err = 'Invalid id';
            return false;
        }

        if(!$this->model->delete()) {
            $this->err = 'Fail to delete';
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    public function deletes()
    {
        $class = $this->class;

        $query = [
            'conditions' => $this->param->getResult()
        ];
        $items = $class::find($query);

        foreach($items as $item) {
            if(!$item->delete()) {
                $this->err = 'Fail to delete ' . $item->getId();
                return false;
            }
        }
        return true;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->model->getId();
    }

    /**
     * @return AppCollection
     */
    public function model()
    {
        return $this->model;
    }

    /**
     * @return string
     */
    public function error()
    {
        return $this->err;
    }

    /**
     * @param Documents $d
     * @throws Nofound
     */
    public function afterFind(Documents $d)
    {
        if($this->chkEmpty) {
            if($d->count() == 0)
                throw new Nofound($this->param->getResult(), $this->class);
        }
    }
}
<?php
namespace App\Component\Request;

use App\Component\Request\Collection\Collection;
use Phalcon\Http\Request as RequestBase;

class Request
{
    /**
     * @var \Phalcon\Http\Request
     */
    private $req;

    public function __construct($requset)
    {
        $this->req = $requset;
    }

    /**
     * @param array $data
     * @return Param
     */
    public function getInput(array $data = [])
    {
        return new Param(new Collection($data));
    }

    /**
     * @return Param
     */
    public function getPost()
    {
        $data = $this->req->getPost();
        return new Param(new Collection($data));
    }

    /**
     * @return Param
     */
    public function getPut()
    {
        $data = $this->req->getPut();
        return new Param(new Collection($data));
    }

    /**
     * @return Param
     */
    public function getQuery()
    {
        $data = $this->req->getQuery();
        return new Param(new Collection($data));
    }

    /**
     * @return Param
     */
    public function getDelete()
    {
        $data = $this->req->getQuery();
        return new Param(new Collection($data));
    }
}

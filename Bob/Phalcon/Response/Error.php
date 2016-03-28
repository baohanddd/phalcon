<?php
namespace Bob\Phalcon\Response;

use Bob\Phalcon\Response\Response\Json;
use Phalcon\Mvc\Collection;

class Error
{

	protected $res;

    public function __construct(Json $res)
    {
        $this->res = $res;
    }

    /**
     * @param string $key
     * @return Phalcon\Http\Response
     */
    public function miss($key)
    {
        return $this->res->fail(4000, sprintf('`%s` is required', $key));
    }

    /**
     * @param Collection $model
     * @return Phalcon\Http\Response
     */
	public function model(Collection $model)
	{
        return $this->res->fail(5000, $model->getMessages()[0]->getMessage());
	}
}
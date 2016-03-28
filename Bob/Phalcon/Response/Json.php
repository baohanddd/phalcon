<?php
namespace Bob\Phalcon\Response;

class Json
{
    /**
     * @var \Phalcon\Di
     */
    protected $_di;

	protected $resp;

    public function __construct(\Phalcon\Di $di)
    {
        $this->_di = $di;
        $this->resp = $this->_di->get('response');
		$this->resp->setHeader('Content-type', 'application/json');
    }

	public function success($body = 'ok', $headers = array())
	{
		$this->resp->setStatusCode(200, 'OK');
		foreach($headers as $name => $val) $this->resp->setHeader($name, $val);
		$this->resp->setJsonContent(array('code' => 200, 'message' => $body));
		$this->resp->send();
	}

	public function created($id, $headers = array(), $extra = array())
	{
		$this->resp->setStatusCode(201, 'Created');
		foreach($headers as $name => $val) $this->resp->setHeader($name, $val);
		$data = array('code' => 201, 'message' => 'created','_id' => $id);
        $data = array_merge($data, $extra);
		$this->resp->setJsonContent($data);
		$this->resp->send();
	}

	public function fail($code = 4000, $message = '', $headers = array())
	{

		$this->resp->setStatusCode(400, 'Error');
		foreach($headers as $name => $val) $this->resp->setHeader($name, $val);
		$this->resp->setJsonContent(array('code' => $code, 'message' => $message));
		$this->resp->send();
	}

	public function delete()
	{
		$this->resp->setStatusCode(400, 'Error');
		$this->resp->setJsonContent(array('code' => 4005, 'message' => 'fails to delete resource'));
		$this->resp->send();
	}

	public function unauthenticate()
	{
		$this->resp->setStatusCode(400, 'Error');
		$this->resp->setJsonContent(array('code' => 4006, 'message' => 'Invalid fields to validate'));
		$this->resp->send();
	}

	public function message(\Phalcon\Mvc\Collection $model)
	{
		$this->resp->setStatusCode(400, 'Error');
		$this->resp->setJsonContent(array('code' => 4000, 'message' => $model->getMessages()[0]->getMessage()));
		$this->resp->send();
	}

	public function messages($messages = array())
	{
		$this->resp->setStatusCode(400, 'Error');
		$this->resp->setJsonContent(array('code' => 4000, 'message' => count($messages)?$messages[0]->getMessage():""));
		$this->resp->send();
	}

	public function nofound()
	{
		$this->resp->setStatusCode(400, 'Error');
		$this->resp->setJsonContent(array('code' => 4004, 'message' => 'can not found requested resource'));
		$this->resp->send();
	}

	public function unauthorized()
	{
		$this->resp->setStatusCode(400, 'Error');
		$this->resp->setJsonContent(array('code' => 4001, 'message' => 'need authorize first'));
		$this->resp->send();
	}

	public function forbidden()
	{
		$this->resp->setStatusCode(400, 'Error');
		$this->resp->setJsonContent(array('code' => 4003, 'message' => 'no grant to access'));
		$this->resp->send();
	}

	/**
	 * @param int $total
	 * @param array $headers
	 */
	public function total($total, $headers = array())
	{
		$doc = ['total' => $total];
		$this->result($doc, $headers);
	}

	public function result($doc, $headers = array())
	{
		$this->resp->setStatusCode(200, 'OK');
		foreach($headers as $name => $val) $this->resp->setHeader($name, $val);
		$this->resp->setJsonContent($doc?:[]);
		$this->resp->send();
	}

	public function results(array $docs = array(), $headers = array())
	{
		$this->resp->setStatusCode(200, 'OK');
		foreach($headers as $name => $val) $this->resp->setHeader($name, $val);
		$this->resp->setJsonContent(array('items' => $docs));
		$this->resp->send();
	}
}
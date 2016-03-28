<?php
namespace Bob\Phalcon;

use Bob\Phalcon\Exception\Required;

class Param
{
    /**
     * @var \Phalcon\Di
     */
    protected $_di;

    public $filter;

    /**
     * @var \Phalcon\Http\Request
     */
    public $request;

    public function __construct(\Phalcon\Di $di)
    {
        $this->_di = $di;
        $this->filter  = $di->get('filter');
        $this->request = $di->get('request');
    }

    /**
     * @param array $rules
     * @return \Bob\Phalcon\Collection
     * @throws Required
     */
    public function filter(array $rules = [])
    {
        $data = $this->getData();
        $this->trim($data, $rules);

        foreach($rules as $key => $formats) {
            $this->required($data, $key, $formats);
            if(!isset($data[$key])) continue;
            $data[$key] = $this->filter->sanitize($data[$key], $formats);
        }
        return new \Bob\Phalcon\Collection($data);
    }

    /**
     * @param array $data
     * @param array $keys
     */
    public function fields(array &$data = [], array $keys = [])
    {
        foreach($keys as $old => $new) {
            if(!isset($data[$old])) continue;
            $val = $data[$old];
            unset($data[$old]);
            $data[$new] = $val;
        }
    }

    /**
     * @param array $data
     */
    public function geo(array &$data = [])
    {
        if(isset($data['latitude']) && isset($data['longitude'])) {
            $data['location'] = [
                '$near' => [
                    $data['latitude'],
                    $data['longitude']
                ]
            ];
            unset($data['latitude']);
            unset($data['longitude']);
        }
    }

    /**
     * @param array $data
     * @param array $rules
     * @return void
     */
    private function trim(array &$data, array $rules)
    {
        foreach($data as $key => $val)
            if(!isset($rules[$key]))
                unset($data[$key]);
    }

    /**
     * @param array $data
     * @param $key
     * @param array $formats
     * @throws Required
     */
    private function required(array &$data, $key, array &$formats)
    {
        $pos = array_search('required', $formats);
        if(!isset($data[$key])) {
            if($pos !== FALSE) throw new Required($key);
        }
        if($pos === FALSE) return ;
        unset($formats[$pos]);
    }

    /**
     * @return mixed
     */
    private function getData()
    {
        if($this->request->isPut()) {
            $data = $this->request->getPut();
            return $data;
        } else {
            $data = $this->request->get();
            return $data;
        }
    }
}
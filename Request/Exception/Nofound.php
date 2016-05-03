<?php
namespace App\Component\Request\Exception;


class Nofound extends \Exception
{
    protected $message = 'Can not found %s by %s';
    protected $code = 4200;

    public function __construct($params, $class)
    {
        $this->message = sprintf($this->message, $class, $this->getParams($params));
        parent::__construct();
    }

    protected function getParams($params)
    {
        if(!is_array($params)) return $params;
        $pairs = [];
        foreach($params as $k => $v) $pairs[] = $k . "=" . $v;
        return implode(', ', $pairs);
    }
}
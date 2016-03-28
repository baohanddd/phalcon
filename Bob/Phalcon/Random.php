<?php
namespace Bob\Phalcon;

class Random
{
    /**
     * @var \Phalcon\Di
     */
    protected $_di;

    public function __construct(\Phalcon\Di $di)
    {
        $this->_di = $di;
    }
   
    public function string($require = 10)
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $len = strlen($chars);
        $rand = '';
        for ($i = 0; $i < $require; $i++) {
            $rand .= $chars[rand(0, $len - 1)];
        }
        return $rand;
    }
    
    public function hex($require = 10)
    {
        $chars = '0123456789ABCDEF';
        $len = strlen($chars);
        $rand = '';
        for ($i = 0; $i < $require; $i++) {
            $rand .= $chars[rand(0, $len - 1)];
        }
        return $rand;
    }
    
    public function number($require = 10)
    {
        $chars = '0123456789';
        $len = strlen($chars);
        $rand = '';
        for ($i = 0; $i < $require; $i++) {
            $rand .= $chars[rand(0, $len - 1)];
        }
        return $rand;
    }
}
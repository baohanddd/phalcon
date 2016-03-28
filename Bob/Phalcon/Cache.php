<?php
namespace Bob\Phalcon;

class Cache
{
    /**
     * @var \Phalcon\Di
     */
    protected $_di;

    /**
     * @var \Phalcon\Cache\Backend\Redis
     */
    private $cache;

    const EXPIRE = 7776000; // 3months
    
    public function __construct(\Phalcon\Di $di)
    {
        $this->_di = $di;
        $cfg = $this->_di->get('config');

        $front = new \Phalcon\Cache\Frontend\Data(["lifetime" => self::EXPIRE]);
        $this->cache = new \Phalcon\Cache\Backend\Redis($front, $cfg->redis);
    }
    
    public function getInstance()
    {
        return $this->cache;
    }
}
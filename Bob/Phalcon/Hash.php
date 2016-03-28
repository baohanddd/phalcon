<?php
namespace Bob\Phalcon;

class Hash
{
    /**
     * @var \Phalcon\Di
     */
    protected $_di;
    
    public function __construct(\Phalcon\Di $di)
    {
        $this->_di = $di;
    }
    
    /**
     * Hash string
	 *
     * @param string $string
     * @return string
     */
	public function generate($string)
	{
		$cfg = $this->_di->get('config');
		return md5($string + $cfg->salt);
	}
}
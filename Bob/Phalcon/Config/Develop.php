<?php
namespace Bob\Phalcon\Config;

use Phalcon\Mvc\Url;

class Develop
{
    /**
     * @var \Phalcon\Di
     */
    protected $_di;

	/**
	 * Salt for password hash
	 *
	 * @var string
	 */
	private $salt = "d&kDAuD70a3%jdli2#K3J";

    /**
     * Connection configure of Redis
     *
     * @var array
     */
    private $redis = array();
    
    private $qiniu = array();

    private $path = array();
    
    
    public function __construct(\Phalcon\Di $di)
    {
        $this->_di = $di;
        $this->redis = [
            'host' => 'localhost',
            'port' => 6379,
            'persistent' => true,
            'statsKey' => '_MAT', // prefix string
        ];
        
        $this->qiniu = [
            'access_key' => 'BW31iIz8A0RFS2esXExkNVyIX04VPO4OlIWgl_5N',
            'secret_key' => 'Xr7BZ71mOCnG-ss1FaXP6YAesyrwMYx6SFl2yOnU',
        ];

        $this->path = [
            'cover'  => 'http://7xnv08.com2.z0.glb.qiniucdn.com/',
            'avatar' => 'http://7xo3rn.com2.z0.glb.qiniucdn.com/',
        ];

        $this->mob = [
            'client_id' => 'YXA6Z5jSEEDNEeWMeQW_6uot5g',
            'client_secret' => 'YXA6sSExhlTKwCkSb2jEuChlLfA47IQ',
            'org_name' => 'goin2015',
            'app_name' => 'goin'
        ];

        $this->admin = [
            'goin@admin' => 'pppppppp'
        ];
    }
    
	public function __get($name)
	{
		if(isset($this->$name)) return $this->$name;
	}
}
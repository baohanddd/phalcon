<?php
namespace Bob\Phalcon\Token;

class Admin implements \Bob\Phalcon\Definition\Token
{
    /**
     * @var \Phalcon\Di
     */
    protected $_di;

    /**
     * @var \Phalcon\Http\Request
     */
    protected $request;

    /**
     * @var \Bob\Phalcon\Cache
     */
    protected $cache;

    const EXPIRE = 36000000;     // one hour
    
    const PREFIX = 'TOKEN_ADMIN_';
    
    public function __construct(\Phalcon\Di $di)
    {
        $this->_di     = $di;
        $this->request = $this->_di->get('request');
        $this->cache   = $this->_di->get('cache');
    }

    /**
     * @param bool|true $thrown
     * @return string|void
     * @throws \Exception
     */
    public function getId($thrown = true)
    {
        $token = $this->getToken($thrown);

        if($token) {
            if(!$this->cache->exists($this->getKey($token))) return $thrown ? $this->unauthorized() : "";
            return $this->cache->get($this->getKey($token));
        }

        return "";
    }

    /**
     * @throws \Exception
     */
    public function getUser()
    {
        $username = $this->getId(true);
        return \App\Model\Admin::getInstance($username);
    }

    /**
     * @param string $userId
     * @return bool
     */
    public function isSelf($userId)
    {
        return $this->getId(false) == $userId;
    }

    public function isRole($role)
    {
        return in_array($role, $this->getRole());
    }

    /**
     * @param $userId
     * @return array
     */
    public function update($username)
    {
        $random = $this->getRandom();
        $token  = $this->cache->get($this->getKey($username));

        if($token) {
            // update expire time...
            $this->cache->delete($this->getKey($username));
            $this->cache->delete($this->getKey($token));
            $this->cache->delete($this->getKey($token.'role'));
        } else {
            $token = $random->string(48);
        }
        $this->cache->save($this->getKey($username), $token,    self::EXPIRE);
        $this->cache->save($this->getKey($token),    $username, self::EXPIRE);
        $this->cache->save($this->getKey($token.'role'), [self::ROLE_ADMIN], self::EXPIRE);

        return ['token' => $token, 'expire' => time() + self::EXPIRE, 'role' => [self::ROLE_ADMIN]];
    }

    private function getRole()
    {
        $token = $this->getToken(true);
        $this->cache->get($this->getKey($token.'role'));
    }

    private function getToken($thrown)
    {
        $token = $this->request->getHeader('Authorization');
        if(!$token) return $thrown ? $this->unauthorized() : "";
        return $token;
    }
    
    private function getKey($key)
    {
        return self::PREFIX . $key;
    }
    
    private function getRandom()
    {
        return $this->_di->get('random');
    }

    private function unauthorized()
    {
        throw new \Exception('need authorized', 401);
    }
}
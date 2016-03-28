<?php
namespace Bob\Phalcon;

/**
 * Class Token
 *
 * @example
 *   $cred = $token->setCredential($id);
 *   $id   = $token->getCredential($hash);
 *
 * @package Bob\Phalcon
 */
class Token
{
    private $cache;

    const EXPIRE = 7776000;     // 3 months
    
    const PREFIX = 'TOKEN_';
    
    public function __construct($cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param $id
     * @param $hash
     * @return array
     */
    public function setCredential($id, $hash)
    {
        $this->cache->save($this->getKey($hash), $id, self::EXPIRE);
        return ['token' => $hash, 'expire' => time() + self::EXPIRE, 'user_id' => $id];
    }

    /**
     * @param $hash
     * @return array
     * @throws \Exception
     */
    public function getCredential($hash)
    {
        $key = $this->getKey($hash);
        $id = $this->cache->get($key);
        if($id) {
            return $this->setCredential($id, $hash);
        }
        $this->unauthorized();
    }

    /**
     * Destroy specified token
     *
     * @param $hash
     * @return void
     */
    public function delCredential($hash)
    {
        $key = $this->getKey($hash);
        $this->cache->delete($key);
    }
    
    private function getKey($key)
    {
        return self::PREFIX . $key;
    }

    private function unauthorized()
    {
        throw new \Exception('need authorized', 4001);
    }
}
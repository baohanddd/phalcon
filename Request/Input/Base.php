<?php
namespace Baohanddd\Request\Input;

use Baohanddd\Request\Collection\Collection;
use Baohanddd\Request\Input\Exception\Enum;
use Baohanddd\Request\Input\Exception\InvalidOperator;
use Baohanddd\Request\Input\Exception\MongoId;
use Baohanddd\Request\Input\Exception\Required;
use Baohanddd\Request\Input\Exception\Timestamp;

class Base
{
    /**
     * @var Collection
     */
    private $q;

    /**
     * @var string
     */
    private $key;

    /**
     * @var Collection
     */
    private $ret;

    public function __construct(Collection $query, Collection $result, $key)
    {
        $this->q   = $query;
        $this->key = $key;
        $this->ret = $result;

        if(!$this->null())
            $this->ret[$this->key] = $this->q[$this->key];
    }

    /**
     * @return $this
     * @throws Required
     */
    public function chkRequire()
    {
        if(!$this->q->has($this->key)) {
            throw new Required($this->key);
        }
        return $this;
    }

    /**
     * @return $this
     * @throws MongoId
     */
    public function chkMongoId()
    {
        if($this->null()) return $this;
        if(!preg_match('/^[0-9a-fA-F]{24}$/', $this->q[$this->key]))
            throw new MongoId($this->key);
        return $this;
    }

    /**
     * @return $this
     * @throws Timestamp
     */
    public function chkTimestamp()
    {
        if($this->null()) return $this;
        $val = $this->q[$this->key];
        $len = strlen((string) $val);
        if($len != 10 || !is_numeric($val))
            throw new Timestamp($this->key);

        return $this;
    }

    /**
     * @param array $enum
     * @return $this
     * @throws Enum
     */
    public function chkIn(array $enum)
    {
        if($this->null()) return $this;
        if(!in_array($this->q[$this->key], $enum))
            throw new Enum($this->key);
        return $this;
    }

    /**
     * @param $key
     * @return $this
     * @throws Required
     */
    public function chkRelated($key)
    {
        if(!$this->q->has($key)) {
            throw new Required($key);
        }
        return $this;
    }

    /**
     * @return $this
     * @throws InvalidOperator
     */
    public function range()
    {
        if($this->null()) return $this;
        $val = trim($this->q[$this->key]);
        list($op, $v) = array_map('trim', explode(' ', $val));
        $v = intval($v);
        switch($op)
        {
            case '>'  : $this->gt($v);   break;
            case '>=' : $this->gte($v);  break;
            case '<'  : $this->lt($v);   break;
            case '<=' : $this->lte($v);  break;
            case '==' : $this->eq($v);   break;
            default:
                throw new InvalidOperator($op);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function mongoDate()
    {
        $this->ret[$this->key] = new \MongoDate();
        return $this;
    }

    /**
     * @return $this
     */
    public function double()
    {
        if($this->null()) return $this;
        $this->ret[$this->key] = (double) $this->q[$this->key];
        return $this;
    }

    /**
     * @return $this
     */
    public function int()
    {
        if($this->null()) return $this;
        $this->ret[$this->key] = (int) $this->q[$this->key];
        return $this;
    }

    /**
     * @return $this
     */
    public function bool()
    {
        if($this->null()) return $this;
        $this->ret[$this->key] = (bool) (int) $this->q[$this->key];
        return $this;
    }

    /**
     * @return $this
     */
    public function defaults($val)
    {
        if($this->null()) {
            $this->ret[$this->key] = $val;
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function hash()
    {
        if($this->null()) return $this;
        $this->ret[$this->key] = md5($this->q[$this->key]);
        return $this;
    }

    /**
     * @param string $key
     * @return $this
     */
    public function assign($key)
    {
        if($this->null()) return $this;
        $this->ret[$key] = $this->q[$this->key];
        unset($this->ret[$this->key]);
        return $this;
    }

    /**
     * @return $this
     */
    public function json()
    {
        if($this->null()) return $this;
        $this->ret[$this->key] = json_decode($this->q[$this->key]);
        return $this;
    }

    /**
     * @return $this
     */
    public function token()
    {
        $token = \Phalcon\DI::getDefault()->get('token');
        $this->ret[$this->key] = $token->getId();
        return $this;
    }

    /**
     * @return $this
     */
    public function trim()
    {
        if($this->null()) return $this;
        $this->ret[$this->key] = trim($this->q[$this->key]);
        return $this;
    }

    /**
     * @return $this
     */
    public function lower()
    {
        if($this->null()) return $this;
        $this->ret[$this->key] = $this->ret[$this->key]
            ? strtolower($this->ret[$this->key]) : strtolower($this->q[$this->key]);
        return $this;
    }

    /**
     * @return $this
     */
    public function upper()
    {
        if($this->null()) return $this;
        $this->ret[$this->key] = $this->ret[$this->key]
            ? strtoupper($this->ret[$this->key]) : strtoupper($this->q[$this->key]);
        return $this;
    }

    /**
     * @return $this
     */
    public function str2arr()
    {
        if($this->null())                    return $this;
        if(!is_string($this->q[$this->key])) return $this;
        $this->ret[$this->key] = array_map('trim', explode(',', $this->q[$this->key]));
        return $this;
    }

    /**
     * @param array $items
     * @return $this
     */
    public function nin(array $items = [])
    {
        if($items)              $this->ret[$this->key] = ['$nin' => $items];
        else if(!$this->null()) $this->ret[$this->key] = ['$nin' => $this->q[$this->key]];
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function eq($value)
    {
        $this->ret[$this->key] = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function ne($value = null)
    {
        if($value)               $this->ret[$this->key] = ['$ne' => $value];
        else if(!$this->null())  $this->ret[$this->key] = ['$ne' => $this->q[$this->key]];
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function gt($value = null)
    {
        if($value)               $this->ret[$this->key] = ['$gt' => $value];
        else if(!$this->null())  $this->ret[$this->key] = ['$gt' => $this->q[$this->key]];
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function gte($value = null)
    {
        if($value)               $this->ret[$this->key] = ['$gte' => $value];
        else if(!$this->null())  $this->ret[$this->key] = ['$gte' => $this->q[$this->key]];
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function lt($value = null)
    {
        if($value)              $this->ret[$this->key] = ['$lt' => $value];
        else if(!$this->null()) $this->ret[$this->key] = ['$lt' => $this->q[$this->key]];
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function lte($value = null)
    {
        if($value)              $this->ret[$this->key] = ['$lte' => $value];
        else if(!$this->null()) $this->ret[$this->key] = ['$lte' => $this->q[$this->key]];
        return $this;
    }

    /**
     * @return $this
     */
    public function exists()
    {
        $this->ret[$this->key] = ['$exists' => true];
        return $this;
    }

    /**
     * @return $this
     */
    public function regex()
    {
        if($this->null()) return $this;
        $this->ret[$this->key] = ['$regex' => $this->q[$this->key]];
        return $this;
    }

    /**
     * @return bool
     */
    private function null()
    {
        return ! isset($this->q[$this->key]) &&
            ($this->q[$this->key] or $this->q[$this->key] !== '0' or $this->q[$this->key] !== 'false');
    }
}
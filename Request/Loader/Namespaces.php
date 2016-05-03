<?php
namespace App\Component\Request\Loader;

/**
 * Class Loader
 * @package App\Component
 * @example
 *   $loader = $l->model();
 *   $loader->game->getClass();
 *   $loader->game->sport->getInstance();
 */
class Namespaces
{
    /**
     * @var array
     */
    private $namespaces = [];

    /**
     * @var string
     */
    private $prefix;

    public function __construct($prefix = '')
    {
        $this->prefix = $prefix;
    }

    public function __get($name)
    {
        $this->namespaces[] = $name;
        return $this;
    }

    public function set($name)
    {
        $this->namespaces[] = $name;
        return $this;
    }

    /**
     * @param $path app.model.game.sport
     * @return $this
     */
    public function setPath($path)
    {
        foreach(explode('.', $path) as $v) $this->set($v);
        return $this;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        $path = $this->prefix;
        foreach($this->namespaces as $class) {
            $path .= '\\';
            $path .= ucfirst($class);
        }
//        $this->namespaces = [];
        return $path;
    }

    /**
     * @return mixed
     */
    public function getInstance()
    {
        $class = $this->getClass();
        return new $class();
    }

    /**
     * @return array
     */
    public function getNamespace()
    {
        return $this->namespaces;
    }

    public function reset()
    {
        $this->namespaces = [];
    }
}
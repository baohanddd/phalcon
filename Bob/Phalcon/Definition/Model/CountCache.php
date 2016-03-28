<?php
namespace Bob\Phalcon\Definition\Model;


trait CountCache
{
    public function counting($arguments)
    {
        $queries = [];
        $class = get_class($this);
        foreach($arguments as $k => $v) $queries[] = sprintf("%s=%s", $k, $v);
        $queryStr = implode('&', $queries);

        $redis = \Phalcon\DI::getDefault()->get("redis");
        $size  = $redis->hGet($class,$queryStr);
        if($size === FALSE) {
            $source = $this->getSource();
            $col = $this->getConnection()->$source;
            $size = $col->count($arguments);
            $redis->hSet($class,$queryStr,$size);
        }
        return $size;
    }
}
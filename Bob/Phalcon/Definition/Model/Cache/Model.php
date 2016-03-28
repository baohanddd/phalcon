<?php
namespace Bob\Phalcon\Definition\Model\Cache;


trait Model
{
    public static function findById($id)
    {
        $cache = \Phalcon\DI::getDefault()->get('cache');
        $model = $cache->get(self::_cache_model_key($id));
        if($model === null)
        {
            $model = self::_cache_model_source($id);
            $cache->save(self::_cache_model_key($id), $model);
        }
        return $model;
    }

    public static function clean($id)
    {
        $cache = \Phalcon\DI::getDefault()->get('redis');
        $cache->delete(self::_cache_model_key($id));
    }

    private static function _cache_model_key($id)
    {
        return self::MODEL_CLASS_NAME . $id;
    }

    private static function _cache_model_source($id)
    {
        $class = self::MODEL_CLASS_NAME;
        $model = $class::findById($id);
        return $model;
    }
}
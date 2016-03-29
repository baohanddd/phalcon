<?php
/**
 * Responser will format data stream to right way
 */
$di->set('responser', function () use ($di) {
    return new Bob\Phalcon\Response\Json($di);
}, true);

/**
 * Responser will format data stream to right way
 */
$di->set('err', function () use ($di) {
    return new Bob\Phalcon\Response\Error($di->responser);
}, true);

/**
 * Criteria parser
 */
$di->set('criteria', function () use ($di) {
    return new \Bob\Phalcon\Criteria($di);
}, true);

/**
 * Responser will format data stream to right way
 */
$di->set('param', function () use ($di) {
    return new \Bob\Phalcon\Param($di);
}, true);

/**
 * Filters
 */
$di->set('filter', function () use ($di) {
    $filter = new \Phalcon\Filter();
    $filter->add('str2arr', new \Bob\Phalcon\Filter\Split());
    $filter->add('mongoId', new \Bob\Phalcon\Filter\MongoId());
    $filter->add('mongodate', new \Bob\Phalcon\Filter\MongoDate());
    $filter->add('like', new \Bob\Phalcon\Filter\Like());
    $filter->add('double', new \Bob\Phalcon\Filter\Double());
    $filter->add('json', new \Bob\Phalcon\Filter\Json());
    $filter->add('token', new \Bob\Phalcon\Filter\Token());
    $filter->add('password', new \Bob\Phalcon\Filter\Password());
    $filter->add('timestamp', new \Bob\Phalcon\Filter\Timestamp());
    return $filter;
}, true);

/**
 * Patch when found base data in db
 */
$di->set('patch', function () use ($di) {
    $patch = new \Bob\Phalcon\Patch($di);
    return $patch;
}, true);

/**
 * Fetch data from model
 */
$di->set('fetch', function () use ($di) {
    $o = new \Bob\Phalcon\Fetch($di);
    $o->attach('already');
    $o->attach('trim');
    $o->attach('append');
    $o->attach('path');
    $o->attach('extract');
    $o->attach('only');
    $o->attach('total');
    $o->attach('prepend');
    $o->attach('merge');
    return $o;
});

/**
 * Redis service
 */
$di->set('redis', function () use ($di) {
    $redis = new \Redis();
    $redis->pconnect('127.0.0.1', 6379);
    return $redis;
}, true);

/**
 * Application config
 */
$di->set('config', function () use ($di) {
    return new \Bob\Phalcon\Config\Develop($di);
}, true);

/**
 * Cache service
 */
$di->set('cache', function () use ($di) {
    $cache = new \Bob\Phalcon\Cache($di);
    return $cache->getInstance();
}, true);

/**
 * Token service
 */
$di->set('token', function () use ($di) {
    return new \Bob\Phalcon\Token($di->get('cache'));
}, true);

/**
 * Random service
 */
$di->set('random', function () use ($di) {
    return new \Bob\Phalcon\Random($di);
}, true);

/**
 * Password service
 *
 * It provides `verify` and `generate` hash act as `password`
 */
$di->set('password', function () {
    return new \Bob\Phalcon\Password();
}, true);
<?php
namespace Bob\Phalcon\Exception\Coin;

class Earn extends \Exception
{
    protected $message = 'fails to earn coin for user';
    protected $code = 4098;
}
<?php
namespace Bob\Phalcon\Exception\Coin;

class Cost extends \Exception
{
    protected $message = 'fails to cost coin for user';
    protected $code = 4099;
}
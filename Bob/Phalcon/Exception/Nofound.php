<?php
namespace Bob\Phalcon\Exception;

class Nofound extends \Exception
{
    protected $message = 'can not found requested resource';
    protected $code = 4004;
}
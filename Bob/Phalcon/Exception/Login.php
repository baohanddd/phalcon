<?php
namespace Bob\Phalcon\Exception;

class Login extends \Exception
{
    protected $message = 'username/phone or password is invalid';
    protected $code = 4103;
}
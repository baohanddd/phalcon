<?php
namespace Bob\Phalcon\Exception\Filter\Password;

class Length extends \Exception
{
    protected $message = 'Password length must be between 6 ~ 12';
    protected $code = 4111;
}
<?php
namespace Bob\Phalcon\Exception\Filter;

class Timestamp extends \Exception
{
    protected $message = 'It\'s invalid timestamp';
    protected $code = 4102;
}
<?php
namespace Bob\Phalcon\Exception\Model\Query\First;

class Nofound extends \Exception
{
    protected $message = 'can not found the first item of %s by %s';
    protected $code = 4004;

    public function __construct($class, array $queries)
    {
        $qs = [];
        foreach($queries as $k => $v) $qs[] = sprintf('%s=%s', $k, $v);
        $this->message = sprintf($this->message, $class, $qs?implode(' and ', $qs):'[]');

        parent::__construct();
    }
}
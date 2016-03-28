<?php
namespace Bob\Phalcon\Definition\Model\Update;

trait Increment
{
    public function incr(array $queries, array $updates)
    {
        $source = $this->getSource();
        $col = $this->getConnection()->$source;
        $ret = $col->update($queries, array('$inc' => $updates));

        if($ret['n'] == 0)
            throw new \Bob\Phalcon\Exception\Increment($this, $updates);
    }
}
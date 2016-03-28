<?php
namespace Bob\Phalcon\Definition\Model;


interface Incremental
{
    /**
     * @example
     * [
     *   'afterCreate' => ['article' => [$this->article_id, ['awesome_total' =>  1]]],
     *   'afterDelete' => ['article' => [$this->article_id, ['awesome_total' => -1]]],
     * ]
     * @return array
     */
    public function increment();
}
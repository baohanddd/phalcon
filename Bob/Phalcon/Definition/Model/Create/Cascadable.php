<?php
namespace Bob\Phalcon\Definition\Model\Create;


interface Cascadable
{
    /**
     * @example
     * [
     * 'map.article.hot' => [
     *     'article_id' => $this->getId(),
     *     'score'      => DI::getDefault()->get('rank')->article($this->getId())->score()
     *   ]
     * ]
     * @return array
     */
    public function createCascade();
}
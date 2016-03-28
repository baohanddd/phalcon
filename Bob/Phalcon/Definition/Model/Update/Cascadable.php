<?php
namespace Bob\Phalcon\Definition\Model\Update;


interface Cascadable
{
    /**
     * @example
     * [
     *   'map.article.hot' => [
     *     [
     *       'article_id' => $this->article_id,
     *       'score' => DI::getDefault()->get('rank')->article($this->article_id)->score()
     *     ],
     *     [
     *       'article_id' => $this->article_id  // queries
     *     ]
     *   ]
     * ]
     *
     * @return array
     */
    public function updateCascade();
}
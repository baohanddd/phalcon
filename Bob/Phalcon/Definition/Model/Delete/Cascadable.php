<?php
namespace Bob\Phalcon\Definition\Model\Delete;


interface Cascadable
{
    /**
     * @example
     * [
     *   'map.article.selection' => ['article_id' => $this->getId()],
     *   'map.article.hot'       => ['article_id' => $this->getId()],
     * ]
     * @return array
     */
    public function deleteCascade();
}
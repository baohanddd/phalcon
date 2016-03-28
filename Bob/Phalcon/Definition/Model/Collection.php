<?php
namespace Bob\Phalcon\Definition\Model;


interface Collection
{
    /**
     * @return string source name
     */
    public function getSource();

    /**
     * @return \MongoCollection
     */
    public function getCollection();
}
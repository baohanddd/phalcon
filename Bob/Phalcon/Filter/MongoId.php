<?php
namespace Bob\Phalcon\Filter;

class MongoId
{
    public function filter($value)
    {
        if(is_array($value)) {
            foreach($value as $item)
                $this->checkString($item);
        } else {
            $this->checkString($value);
        }
        return $value;
    }

    private function checkString($str)
    {
        if(!$this->check($str))
            throw new \Bob\Phalcon\Exception\Filter\MongoId($str);
    }

    private function check($value)
    {
        return preg_match('/^[0-9a-fA-F]{24}$/', $value);
    }
}
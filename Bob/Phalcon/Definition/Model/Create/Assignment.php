<?php
namespace Bob\Phalcon\Definition\Model\Create;


trait Assignment
{
    public function assign($data)
    {
        foreach($data as $k => $v) {
            if (!property_exists($this, $k)) continue;
            $this->$k = $v;
        }

        $rules = $this->_assignment_getRules();
        $this->_assignment_format($rules);
    }

    private function _assignment_getRules()
    {
        $rules = [];

        $reader = new \Phalcon\Annotations\Adapter\Memory();

        // Reflect the annotations in the class Example
        $reflector = $reader->get(static::class);

        // Read the annotations in the class' docblock
        $annotations = $reflector->getPropertiesAnnotations();

        // Check if the method has an annotation 'Cache'
        foreach($annotations as $field => $collection) {
            if ($collection->has('param')) {
                // The method has the annotation 'Cache'
                $param = $collection->get('param');

                $required = $param->getNamedParameter('required');
                $format   = $param->getNamedParameter('format');

                $formats = ($format) ? array_map('trim', explode(',',$format)) : [];
                if($required) $formats[] = 'required';

                $rules[$field] = $formats;
            }
        }

        return $rules;
    }

    private function _assignment_format(array $rules = [])
    {
        $filter = \Phalcon\DI::getDefault()->get('filter');

        try {
            foreach($rules as $key => $formats) {
                foreach($formats as $format) {
                    if(is_array($this->$key)) continue;
                    $this->$key = $filter->sanitize($this->$key, $format);
                }
            }
        } catch(\Bob\Phalcon\Exception\Filter\Required $e) {
            throw new \Bob\Phalcon\Exception\Required($this, $key);
        }
    }
}
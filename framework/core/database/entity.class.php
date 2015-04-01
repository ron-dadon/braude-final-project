<?php

abstract class Entity
{

    public function get_fields()
    {
        return get_object_vars($this);
    }

    public function get_name()
    {
        return str_replace('_entity', '', strtolower(get_class($this)));
    }

    /**
     * @return array
     * @throws Trident_Exception
     */
    protected function get_properties()
    {
        $entity = new ReflectionClass($this);
        $path = dirname($entity->getFileName());
        if (file_exists($file = $path . DS . $this->get_name() . '.json') && is_readable($file))
        {
            if (($properties = json_decode(file_get_contents($file), true)) === null)
            {
                throw new Trident_Exception("Entity: invalid json data in entity properties file");
            }
            return $properties;
        }
        else
        {
            throw new Trident_Exception("Entity: missing or not readable properties file");
        }
    }

    /**
     * Validate field
     *
     * @param string $field
     *
     * @return bool
     * @throws Trident_Exception
     */
    public function is_valid_field($field)
    {
        $properties = $this->get_properties();
        if (!isset($properties[$field]))
        {
            throw new Trident_Exception("Entity: field $field doesn't exists");
        }
        $properties = $properties[$field];
        $valid = true;
        if (isset($properties['empty']) && $properties['empty'] == false)
        {
            $valid &= ($this->$field === '' || $this->$field === null);
        }
        if (isset($properties['min_length']) && $properties['min_length'] > 0)
        {
            $valid &= strlen($this->$field) >= $properties['min_length'];
        }
        if (isset($properties['max_length']) && $properties['max_length'] > 0)
        {
            $valid &= strlen($this->$field) <= $properties['max_length'];
        }
        if (isset($properties['email']) && $properties['email'] == true)
        {
            $valid &= filter_var($this->$field, FILTER_VALIDATE_EMAIL) !== false;
        }
        if (isset($properties['ip']) && $properties['ip'] == true)
        {
            $valid &= filter_var($this->$field, FILTER_VALIDATE_IP) !== false;
        }
        if (isset($properties['boolean']) && $properties['boolean'] == true)
        {
            $valid &= filter_var($this->$field, FILTER_VALIDATE_BOOLEAN) !== false;
        }
        if (isset($properties['regex']))
        {
            $valid &= filter_var($this->$field, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => $properties['regex']]]) !== false;
        }
        if (isset($properties['integer']) && $properties['integer'] == true)
        {
            $options = [];
            if (isset($properties['min']))
            {
                $options['options']['min_range'] = $properties['min'];
            }
            if (isset($properties['max']))
            {
                $options['options']['max_range'] = $properties['max'];
            }
            $valid &= filter_var($this->$field, FILTER_VALIDATE_INT, $options) !== false;
        }
        if (isset($properties['float']) && $properties['float'] == true)
        {
            $options = [];
            if (isset($properties['min']))
            {
                $options['options']['min_range'] = $properties['min'];
            }
            if (isset($properties['max']))
            {
                $options['options']['max_range'] = $properties['max'];
            }
            $valid &= filter_var($this->$field, FILTER_VALIDATE_FLOAT, $options) !== false;
        }
        return $valid;
    }

    /**
     * Validate entity
     *
     * @return bool
     * @throws Trident_Exception
     */
    public function is_valid()
    {
        $fields = array_keys($this->get_fields());
        $valid = true;
        foreach ($fields as $field)
        {
            $valid &= $this->is_valid_field($field);
        }
        return $valid;
    }
}
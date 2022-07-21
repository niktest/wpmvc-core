<?php
class Model extends stdClass
{
    protected $attributes;
    public function __construct($attributes = [])
    {
        $this->attributes = $attributes;
    }
    public function to_array()
    {
        return $this->attributes;
    }
}
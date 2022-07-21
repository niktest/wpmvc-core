<?php
class ObjectClass extends stdClass
{
    protected $attributes;
    public function __construct($attributes = [])
    {
        $this->attributes = $attributes;
    }
    public function toArray()
    {
        return $this->attributes;
    }
}
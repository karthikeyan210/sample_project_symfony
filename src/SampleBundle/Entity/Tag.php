<?php
// src/SampleBundle/Entity/Tag.php
namespace SampleBundle\Entity;

class Tag
{
    private $name;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}

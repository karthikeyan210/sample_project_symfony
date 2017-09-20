<?php

// src/SampleBundle/Entity/Task.php
namespace SampleBundle\Entity;

class Task
{
    protected $task;
    protected $dueDate;
    protected $firstname;
    protected $lastname;
    protected $dateofbirth;

    public function getTask()
    {
        return $this->task;
    }

    public function setTask($task)
    {
        $this->task = $task;
    }

    public function getDueDate()
    {
        return $this->dueDate;
    }

    public function setDueDate(\DateTime $dueDate = null)
    {
        $this->dueDate = $dueDate;
    }

    public function getFirstName()
    {
        return $this->firstname;
    }

    public function setFirstName($firstname)
    {
        $this->firstname = $firstname;
    }

    public function getLastName()
    {
        return $this->lastname;
    }

    public function setLastName($lastname)
    {
        $this->lastname = $lastname;
    }

    public function getDateOfBirth()
    {
        return $this->dateofbirth;
    }

    public function setDateOfBirth(\DateTime $dateofbirth = null)
    {
        $this->dateofbirth = $dateofbirth;
    }
}
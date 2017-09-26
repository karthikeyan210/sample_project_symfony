<?php

// src/UserManagementBundle/Entity/Task.php
namespace UserManagementBundle\Entity;

class Task
{
    protected $username;
    protected $task;
    protected $dueDate;
    protected $firstname;
    protected $lastname;
    protected $dateofbirth;
    protected $emails;
    protected $gender;
    protected $bloodgroup;
    protected $course;
    protected $stream;
    protected $college;
    protected $location;
    protected $areaofinterest;
    protected $mobilenumber;
    public function __toString() 
    {
        return serialize($this);
        
    }
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

    public function getEmails()
    {
        return $this->emails;
    }

    public function setEmails($emails)
    {
        $this->emails = $emails;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function getBloodGroup()
    {
        return $this->bloodgroup;
    }

    public function setBloodGroup($bloodgroup)
    {
        $this->bloodgroup = $bloodgroup;
    }

    public function getCourse()
    {
        return $this->course;
    }

    public function setCourse($course)
    {
        $this->course = $course;
    }

    public function getStream()
    {
        return $this->stream;
    }

    public function setStream($stream)
    {
        $this->stream = $stream;
    }

    public function getCollege()
    {
        return $this->college;
    }

    public function setCollege($college)
    {
        $this->college = $college;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }


    public function getMobileNumber()
    {
        return $this->mobilenumber;
    }

    public function setMobileNumber($mobilenumber)
    {
        $this->mobilenumber = $mobilenumber;
    }

    public function getAreaOfInterest()
    {
        return $this->areaofinterest;
    }

    public function setAreaOfInterest($areaofinterest)
    {
        $this->areaofinterest = $areaofinterest;
    }
    
    public function getUserName()
    {
        return $this->username;
    }

    public function setUserName($username)
    {
        $this->username = $username;
    }

    // public function get()
    // {
    //     return $this->;
    // }

    // public function set()
    // {
    //     $this->
    // }
}
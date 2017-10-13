<?php

namespace UserManagementBundle\Entity;

use UserManagementBundle\Validator\Constraints\ContainsAlphanumericValidator;
/**
 * User
 */
class User
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var \DateTime
     */
    private $dob;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $emails;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $mobileNumbers;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $education;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $interests;

    /**
     * @var \UserManagementBundle\Entity\BloodGroup
     */
    private $blood;

    /**
     * @var \UserManagementBundle\Entity\Gender
     */
    private $gender;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->emails = new \Doctrine\Common\Collections\ArrayCollection();
        $this->mobileNumbers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->education = new \Doctrine\Common\Collections\ArrayCollection();
        $this->interests = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set dob
     *
     * @param \DateTime $dob
     *
     * @return User
     */
    public function setDob($dob)
    {
        $this->dob = $dob;

        return $this;
    }

    /**
     * Get dob
     *
     * @return \DateTime
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * Add email
     *
     * @param \UserManagementBundle\Entity\UserEmail $email
     *
     * @return User
     */
    public function addEmail(\UserManagementBundle\Entity\UserEmail $email)
    {   
        $this->emails[] = $email;
        $email->setUser($this);
        return $this;
    }

    /**
     * Remove email
     *
     * @param \UserManagementBundle\Entity\UserEmail $email
     */
    public function removeEmail(\UserManagementBundle\Entity\UserEmail $email)
    {
        $this->emails->removeElement($email);
    }

    /**
     * Get emails
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * Add mobileNumber
     *
     * @param \UserManagementBundle\Entity\UserPhone $mobileNumber
     *
     * @return User
     */
    public function addMobileNumber(\UserManagementBundle\Entity\UserPhone $mobileNumber)
    {
        $this->mobileNumbers[] = $mobileNumber;
        $mobileNumber->setUser($this);  
        return $this;
    }

    /**
     * Remove mobileNumber
     *
     * @param \UserManagementBundle\Entity\UserPhone $mobileNumber
     */
    public function removeMobileNumber(\UserManagementBundle\Entity\UserPhone $mobileNumber)
    {
        $this->mobileNumbers->removeElement($mobileNumber);
    }

    /**
     * Get mobileNumbers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMobileNumbers()
    {
        return $this->mobileNumbers;
    }

    /**
     * Add education
     *
     * @param \UserManagementBundle\Entity\UserEducation $education
     *
     * @return User
     */
    public function addEducation(\UserManagementBundle\Entity\UserEducation $education)
    {
        $this->education[] = $education;
        $education->setUser($this);
        return $this;
    }

    /**
     * Remove education
     *
     * @param \UserManagementBundle\Entity\UserEducation $education
     */
    public function removeEducation(\UserManagementBundle\Entity\UserEducation $education)
    {
        $this->education->removeElement($education);
    }

    /**
     * Get education
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * Add interest
     *
     * @param \UserManagementBundle\Entity\UserInterest $interest
     *
     * @return User
     */
    public function addInterest(\UserManagementBundle\Entity\UserInterest $interest)
    {
        $this->interests[] = $interest;
        $interest->setUser($this);
        return $this;
    }

    /**
     * Remove interest
     *
     * @param \UserManagementBundle\Entity\UserInterest $interest
     */
    public function removeInterest(\UserManagementBundle\Entity\UserInterest $interest)
    {
        $this->interests->removeElement($interest);
    }

    /**
     * Get interests
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInterests()
    {
        return $this->interests;
    }

    /**
     * Set blood
     *
     * @param \UserManagementBundle\Entity\BloodGroup $blood
     *
     * @return User
     */
    public function setBlood(\UserManagementBundle\Entity\BloodGroup $blood = null)
    {
        $this->blood = $blood;

        return $this;
    }

    /**
     * Get blood
     *
     * @return \UserManagementBundle\Entity\BloodGroup
     */
    public function getBlood()
    {
        return $this->blood;
    }

    /**
     * Set gender
     *
     * @param \UserManagementBundle\Entity\Gender $gender
     *
     * @return User
     */
    public function setGender(\UserManagementBundle\Entity\Gender $gender = null)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return \UserManagementBundle\Entity\Gender
     */
    public function getGender()
    {
        return $this->gender;
    }
}

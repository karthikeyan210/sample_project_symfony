<?php

namespace UserManagementBundle\Entity;

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
     * @var \DateTime
     */
    private $createdAt;
    
    /**
     * @var \DateTime
     */
    private $updatedAt;

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
    
    /**
     * Gets triggered only on insert
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
    }
    
    /**
     * Gets triggered every time on update
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime();
    }
    
    /**
     * set/update the email from CSV file
     * 
     * @param array $emails
     */
    public function setCsvEmail($emails)
    {
        $emailArray = $this->getEmails();
        for ($index = 0; $index < count($emails); $index++) {
            $emailExist = false;
            if ($emailArray) {
                foreach ($emailArray as $email) {
                    if ($email->getEmailAddr() == $emails[$index]) {
                        $emailExist = true;
                        break;
                    }
                }
            }
            if (!$emailExist) {
                $email = new UserEmail();
                $email->setEmailAddr($emails[$index]);
                $this->addEmail($email);
            }
        }
    }
    
    /**
     * set/update the mobile number from CSV file
     * 
     * @param array $mobileNumbers
     */
    public function setCsvPhone($mobileNumbers)
    {
        $phoneArray = $this->getMobileNumbers();
        for ($index = 0; $index < count($mobileNumbers); $index++) {
            $numberExist = false;
            if ($phoneArray) {
                foreach ($phoneArray as $number) {
                    if ($number->getNumber() == $mobileNumbers[$index]) {
                        $numberExist = true;
                        break;
                    }
                }
            }
            if (!$numberExist) {
                $number = new UserPhone();
                $number->setNumber($mobileNumbers[$index]);
                $this->addMobileNumber($number);
            }
        }
    }
    
    /**
     * set blood from CSV file
     * 
     * @param array  $bloodArray
     * @param string $userBlood
     * @return \UserManagementBundle\Entity\BloodGroup
     */
    public function setCsvBlood($bloodArray, $userBlood)
    {
        foreach ($bloodArray as $value) {
            $blood = null;
            if ($value->getName() == $userBlood) {
                $blood = $value;
                break;
           }
        }
        return $blood;
    }
    
    /**
     * set gender from CSV file
     * 
     * @param array  $genderArray
     * @param string $userGender
     * 
     * @return \UserManagementBundle\Entity\Gender
     */
    public function setCsvGender($genderArray, $userGender)
    {
        foreach ($genderArray as $value) {
            $gender = null;
            if ($value->getName() == $userGender) {
                $gender = $value;
                break;
           }
        }
        return $gender;
    }
    
    /**
     * set interest from CSV file
     * 
     * @param array $interestArray
     * @param array $userInterests
     * 
     * @return boolean
     */
    public function setCsvInterest($interestArray, $userInterests)
    {
        for ($index = 0; $index < count($userInterests); $index++) {
            foreach ($interestArray as $value) {
                $isValidInterest = false;
                if ($value->getName() == $userInterests[$index]) {
                    $interest = $value;
                    $isValidInterest = true;
                    break;
                }
            }
            if (!$isValidInterest) {
                return false;
            }
            $userInterestArray = $this->getInterests();
            $interestExist = false;
            if ($userInterestArray) {
                foreach ($userInterestArray as $userInterest) {
                    if ($userInterest->getInterest() == $interest) {
                        $interestExist = true;
                        break;
                    }
                }
            }
            if (!$interestExist) {
                $userinterest = new UserInterest();
                $userinterest->setInterest($interest);
                $this->addInterest($userinterest);
            }
        }
        return true;
    }
    
    /**
     * set education from CSV file
     * 
     * @param array $edutypeArray
     * @param array $userEducations
     * 
     * @return boolean
     */
    public function setCsvEducation($edutypeArray, $userEducations)
    {
        foreach($userEducations as $edu) {
            $education = explode('-', $edu);
            foreach ($edutypeArray as $eduType) {
                $isValidEdutype = false;
                if ($eduType->getType() == $education[0]) {
                    $edutype = $eduType;
                    $isValidEdutype = true;
                    break;
                }
            }
            if (!$isValidEdutype) {
                return false;
            }

            $userEducationArray = $this->getEducation();
            $educationExist = false;
            if ($userEducationArray) {
                foreach ($userEducationArray as $userEducation) {
                    if ($userEducation->getEduType() == $edutype) {
                        $educationExist = true;
                        break;
                    }
                }
            }
            if (!$educationExist) {
                $usereducation = new UserEducation();
                $usereducation->setEduType($edutype);
                $usereducation->setInstitute($education[1]);
                $this->addEducation($usereducation);
            }
        }
        return true;
    }
}

<?php

namespace UserManagementBundle\Entity;

/**
 * UserEducation
 */
class UserEducation
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $institute;

    /**
     * @var \UserManagementBundle\Entity\EducationType
     */
    private $eduType;

    /**
     * @var \UserManagementBundle\Entity\User
     */
    private $user;


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
     * Set institute
     *
     * @param string $institute
     *
     * @return UserEducation
     */
    public function setInstitute($institute)
    {
        $this->institute = $institute;

        return $this;
    }

    /**
     * Get institute
     *
     * @return string
     */
    public function getInstitute()
    {
        return $this->institute;
    }

    /**
     * Set eduType
     *
     * @param \UserManagementBundle\Entity\EducationType $eduType
     *
     * @return UserEducation
     */
    public function setEduType(\UserManagementBundle\Entity\EducationType $eduType = null)
    {
        $this->eduType = $eduType;

        return $this;
    }

    /**
     * Get eduType
     *
     * @return \UserManagementBundle\Entity\EducationType
     */
    public function getEduType()
    {
        return $this->eduType;
    }

    /**
     * Set user
     *
     * @param \UserManagementBundle\Entity\User $user
     *
     * @return UserEducation
     */
    public function setUser(\UserManagementBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserManagementBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}

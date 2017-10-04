<?php

namespace UserManagementBundle\Entity;


use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * UserEmail
 */
class UserEmail
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $emailAddr;

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
     * Set emailAddr
     *
     * @param string $emailAddr
     *
     * @return UserEmail
     */
    public function setEmailAddr($emailAddr)
    {
        $this->emailAddr = $emailAddr;

        return $this;
    }

    /**
     * Get emailAddr
     *
     * @return string
     */
    public function getEmailAddr()
    {
        return $this->emailAddr;
    }

    /**
     * Set user
     *
     * @param \UserManagementBundle\Entity\User $user
     *
     * @return UserEmail
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

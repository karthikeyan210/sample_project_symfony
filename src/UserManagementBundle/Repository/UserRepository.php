<?php

namespace UserManagementBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class UserRepository extends EntityRepository
{
    public function getAllUsers($currentPage = 1)
    {
        $query = $this->getEntityManager() 
            ->createQuery(
                    'select u from UserManagementBundle:User u order by u.id ASC'
                    );
        $paginator = $this->paginate($query, $currentPage);
        return $paginator;
    }
    
    public function paginate($dql, $page = 1, $limit = 5)
    {
        $paginator = new Paginator($dql);
        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1)) // Offset
            ->setMaxResults($limit); // Limit

        return $paginator;
    }
}
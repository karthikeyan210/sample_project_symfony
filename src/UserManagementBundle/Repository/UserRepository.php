<?php

namespace UserManagementBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class UserRepository extends EntityRepository
{
//    public function findAllUsers()
//    {
//        return $this->getEntityManager()
//            ->createQuery(
//                'SELECT p FROM AppBundle:Product p ORDER BY p.name ASC'
//            )
//            ->getResult();
//    }
    public function getAllUsers($currentPage = 1)
    {
//        $em = $this->getDoctrine()->getManager();
//        $repo = $em->getRepository('UserManagementBundle:User');
        $query = $this->getEntityManager() 
            ->createQuery(
                    'select u from UserManagementBundle:User u order by u.id ASC'
                    );
//            ->orderBy('u.id', 'ASC')
//            ->getQuery();

       // No need to manually get get the result ($query->getResult())
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
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
    
    public function filterByDate($start, $end, $currentPage)
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('u')
            ->from('UserManagementBundle:User', 'u')
            ->where('u.createdAt BETWEEN :start AND :end')
            ->setParameter('start', $start)
            ->setParameter('end', $end);
        
        $paginator = $this->paginate($query, $currentPage);
        return $paginator;
    }
    
    public function filterByEduType($type, $page)
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('u')
            ->from('UserManagementBundle:User', 'u')
            ->innerJoin('u.education', 'ue')
            ->where('ue.user = u.id')
            ->innerJoin('ue.eduType', 'e')
            ->where('ue.eduType = e.id')
            ->where('e.id >= :edutype')
            ->setParameter('edutype', $type);
        
        $paginator = $this->paginate($query, $page);
        return $paginator;
    }
    
    public function filterByInterest()
    {
        $query = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('i.name, count(ui.interest) as interested_users')
            ->from('UserManagementBundle:User', 'u')
            ->innerJoin('u.interests', 'ui')
            ->where('ui.user = u.id')
            ->innerJoin('ui.interest', 'i')
            ->where('ui.interest = i.id')
            ->groupBy('ui.interest')
            ->getQuery();
        return $query->getResult();
    }
    
    public function paginate($dql, $page = 1, $limit = 5)
    {
        $paginator = new Paginator($dql);
        $paginator->getQuery()
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit);

        return $paginator;
    }
}
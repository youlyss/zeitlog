<?php

namespace App\Repository;

use App\Entity\Worktime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Worktime|null find($id, $lockMode = null, $lockVersion = null)
 * @method Worktime|null findOneBy(array $criteria, array $orderBy = null)
 * @method Worktime[]    findAll()
 * @method Worktime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorktimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Worktime::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Worktime $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Worktime $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    public function findAllUsersWorktimes()
    {
        $query = $this->createQueryBuilder('wk')
            ->select('wk,fruser.email,fruser.id')
            ->innerJoin( 'App\Entity\User', 'fruser', 'WITH', 'fruser.id = wk.user')
            ->getQuery()
            ->getResult();

        return $query;
    }


    public function findUserWorktime($id)
    {
        $query = $this->createQueryBuilder('wk')
            ->select('wk, u.email, u.id As userId, wk.id, wk.startTime, wk.endTime')
            ->innerJoin( 'App\Entity\User', 'u', 'WITH', 'wk.user = u.id')
            ->where('wk.id = :id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getOneOrNullResult();

        return $query;
    }


    public function findByWorktimesByUser($id)
    {
        $query = $this->createQueryBuilder('wk')
            ->select('wk.id, wk.startTime, wk.endTime, user.email, pr.name')
            ->innerJoin('App\Entity\User', 'user', 'WITH', 'user.id = wk.user')
            ->innerJoin('App\Entity\UserProject', 'up','WITH','up.user = user.id')
            ->innerJoin( 'App\Entity\Project', 'pr', 'WITH', 'pr.id = up.project')
            ->where('user.id = :id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getResult();

        return $query;
    }

    public function findByWorktimesByProject($id)
    {
        $query = $this->createQueryBuilder('wk')
            ->select('wk.id, wk.startTime, wk.endTime, user.email, pr.name')
            ->innerJoin('App\Entity\User', 'user', 'WITH', 'user.id = wk.user')
            ->innerJoin('App\Entity\UserProject', 'up','WITH','up.user = user.id')
            ->innerJoin( 'App\Entity\Project', 'pr', 'WITH', 'pr.id = up.project')
            ->where('pr.id = :id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getResult();

        return $query;
    }

    public function findBylastUserWorktime($id)
    {
        $query = $this->createQueryBuilder('wk')
            ->select('wk.id, wk.startTime, wk.endTime')
            ->innerJoin('App\Entity\User', 'user', 'WITH', 'user.id = wk.user')
            ->where('wk.endTime is null')
            ->andwhere('user.id = :id')
            ->setParameter('id',$id)
            ->getQuery()
            ->getOneOrNullResult();

        return $query;



    }



}

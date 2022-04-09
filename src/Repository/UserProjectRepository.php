<?php

namespace App\Repository;

use App\Entity\UserProject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserProject|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserProject|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserProject[]    findAll()
 * @method UserProject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserProject::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(UserProject $entity, bool $flush = true): void
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
    public function remove(UserProject $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    public function findAllProjectsUsersWorktimes()
    {
        $query = $this->createQueryBuilder('up')
            ->select('user.email,user.id as userId, wk.id as workId, pr.id as projectId, pr.name, wk.startTime, wk.endTime')
            ->innerJoin('App\Entity\Project', 'pr','WITH','pr.id = up.project')
            ->innerJoin( 'App\Entity\User', 'user', 'WITH', 'user.id = up.user')
            ->innerJoin('App\Entity\Worktime', 'wk','WITH','user.id = wk.user')
            ->getQuery()
            ->getResult();

        return $query;
    }


}

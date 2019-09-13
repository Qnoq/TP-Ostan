<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function searchHome($criterias)
    {
        return $this->createQueryBuilder('u')
            ->innerJoin('u.jobs', 'j')
            ->innerJoin('u.tags', 't')
            ->andWhere('j IN (:jobs)')
            ->andWhere('t IN (:tags)')
            ->setParameters(array(
                'jobs' => $criterias['jobs'],
                'tags' => $criterias['tags']
            ))
            ->getQuery()
            ->getResult();
    }


    public function findByPage($page = 1, $max = 4)
    {
        if (!is_numeric($page)) {
            throw new \InvalidArgumentException(
                '$page must be an integer (' . gettype($page) . ' : ' . $page . ')'
            );
        }

        if (!is_numeric($page)) {
            throw new \InvalidArgumentException(
                '$max must be an integer (' . gettype($max) . ' : ' . $max . ')'
            );
        }

        $dql = $this->createQueryBuilder('user');
        $dql->orderBy('user.username', 'ASC');

        $firstResult = ($page - 1) * $max;

        $query = $dql->getQuery();
        $query->setFirstResult($firstResult);
        $query->setMaxResults($max);

        $paginator = new Paginator($query);

        if (($paginator->count() <=  $firstResult) && $page != 1) {
            throw new NotFoundHttpException('Page not found');
        }

        return $paginator;
    }


    public function findAllExceptUser($user)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.hidden = user')
            ->setParameter('user', $user)
            ->orderBy('m.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // public function findAllExceptEditor()
    // {
    //     $query = $this->getEntityManager()->createQuery("
    //         SELECT u
    //         FROM App\Entity\User u
    //         INNER JOIN Job ON job.id = user.
    //         WHERE u.jobs.name ='Illustrateur' AND u.jobs.name ='Auteur'
    //     ");

    //     return $query->getResult(); 
    // }

    // public function findAllExceptEditor()
    // {
    //     return $this->createQueryBuilder('u')
    //         ->innerJoin('u.jobs', 'j')
    //         ->andWhere('j.id = u.id ')
    //         ->getQuery()
    //         ->getResult();
    // }

    public function findAllExceptEditor()
    {
        // $query = $this->getEntityManager()
        // ->createQuery('
        //     SELECT *
        //     FROM user_job
        //     INNER JOIN user ON user_job.user_id = user.id
        //     INNER JOIN job ON user_job.job_id = job.id
        //     WHERE job.name = "Illustrateur" OR job.name = "Auteur"
        //  ')

        // $query = $this->getEntityManager()
        // ->createQuery('
        //     SELECT u
        //     FROM App\Entity\User u
        //     JOIN App\Entity\Job j ON u = j.id
        //     JOIN App\Entity\User u ON j = u.id
        //     WHERE j.name = "Illustrateur" OR j.name = "Auteur"
        //  ')

        //  ->getResult();
        // return $this->createQueryBuilder('u')
        // // p.category refers to the "category" property on product
        // ->innerJoin('u.jobs', 'j')
        // // selects all the category data to avoid the query
        // ->addSelect('j')
        // ->andWhere('u.id = 20')
        
        // ->getQuery()
        // ->getOneOrNullResult();
    }
}
// An exception has been thrown during the rendering of a template ("[Semantical Error] line 0, col 43 near 'Job j ON u.id': Error: Class 'Job' is not defined.").
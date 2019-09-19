<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    
    public function findAllAdvicePost()
    {
        $query = $this->getEntityManager()->createQuery("
            SELECT p
            FROM App\Entity\Post p            
            WHERE p.type = 'Article'
            ORDER BY p.createdAt DESC
        ");
        

        return $query->getResult(); 
    }

    public function findAllAdPost()
    {
        $query = $this->getEntityManager()->createQuery("
            SELECT p
            FROM App\Entity\Post p
            WHERE p.type = 'Annonce'
            ORDER BY p.createdAt DESC         
        ");

        return $query->getResult(); 
    }

    /**
     * @return Post[] Returns an array of Post objects
     */
    public function searchAdList($criterias)
    {
            //return $this->createQueryBuilder('p')
            // relier les tables job et user, dans lesquelles on va plonger
            // ->innerJoin('p.jobs', 'j')
            // ->innerJoin('p.users', 'u')

            // ->andWhere('j IN (:jobs)')
            // ->andWhere('u IN (:users)')
            // ->setParameters(array(
            //     'jobs' => $criterias['jobs'],
            //     'users' => $criterias['users']
            // ));
            // ->getQuery()
            // ->getResult();


            $query = $this->getEntityManager()->createQuery("
            SELECT * 
            FROM post 
            INNER JOIN job 
            WHERE post.type = 'Annonce' AND job.name = 'Auteur'         
        ");

        return $query->getResult(); 
            
    }

    
}

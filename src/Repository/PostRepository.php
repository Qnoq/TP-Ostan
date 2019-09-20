<?php

namespace App\Repository;

use App\Entity\Job;
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
    public function searchAdList($name)
    {
        //     $query = $this->getEntityManager()
        //     ->createQuery("
        //     SELECT p 
        //     FROM App\Entity\Post p
        //     LEFT JOIN App\Entity\Job j 
        //     WHERE j.name = :val
        //     SET PARAMETER 'val'= $name
        //     ORDER BY p.createdAt DESC   
        // ");
        // return $query->getResult(); 
            

        // return $this->createQueryBuilder('p')
        // ->innerJoin('j')
        // ->andWhere('j.name = :val')
        // ->setParameter('val', $name)
        // ->orderBy('p.createdAt', 'DESC')
        // ->getQuery()
        // ->getResult();

        $query = $this->getEntityManager()
                      ->createQuery("
                SELECT p
                FROM App\Entity\Post p 
                JOIN App\Entity\Job j 
                ");
        return $query->getResult(); 
    }

    
}

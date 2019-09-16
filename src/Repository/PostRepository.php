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
        ");
        

        return $query->getResult(); 
    }


    public function findAllAdPost()
    {
        $query = $this->getEntityManager()->createQuery("
            SELECT p
            FROM App\Entity\Post p            
            WHERE p.type = 'Annonce'
        ");
        
        return $query->getResult(); 
    }

    public function findOneByCode()
    {
        $query = $this->getEntityManager()->createQuery("
            SELECT p
            FROM App\Entity\Post p
            JOIN App\Entity\Status s ON p = s.code
        ");
        
        return $query->getResult(); 
    }

    public function findByPage($page = 1, $max = 4)
    {
        if(!is_numeric($page)) {
            throw new \InvalidArgumentException(
                '$page must be an integer ('.gettype($page).' : '.$page.')'
            );
        }

        if(!is_numeric($page)) {
            throw new \InvalidArgumentException(
                '$max must be an integer ('.gettype($max).' : '.$max.')'
            );
        }

        $dql = $this->createQueryBuilder('post');
        $dql->orderBy('post.createdAt', 'DESC');

        $firstResult = ($page - 1) * $max;

        $query = $dql->getQuery();
        $query->setFirstResult($firstResult);
        $query->setMaxResults($max);

        $paginator = new Paginator($query);

        if(($paginator->count() <=  $firstResult) && $page != 1) {
            throw new NotFoundHttpException('Page not found');
        }

        return $paginator;
    }

    
}

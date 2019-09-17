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

    
    // retourne la liste des posts filtrés par titre
    public function findByTitle($title){
        $query = $this->createQueryBuilder('p')
                      ->where('p.title LIKE :searchTitle')
                      ->setParameter('searchTitle', '%' . $title . '%')
                      ->orderBy('p.title', 'ASC'); 
        return $query->getQuery()->getResult();
    }

    
}

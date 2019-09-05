<?php

namespace App\DataFixtures;

use Nelmio\Alice\Loader\NativeLoader;
use App\DataFixtures\MyCustomNativeLoader;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
      $this->encoder = $encoder;   
   
    }
    public function load(ObjectManager $em)
    {
        

        $loader = new MyCustomNativeLoader();
        //importe le fichier de fixtures et récupère les entités générés
        $entities = $loader->loadFile(__DIR__ . '/fixtures.yml')->getObjects();
        foreach ($entities as $entity) {
            
            $em->persist($entity);
            
        };
        


        $em->flush();
    }
}

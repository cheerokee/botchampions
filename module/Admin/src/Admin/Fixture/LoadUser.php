<?php
namespace Admin\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture,
    Doctrine\Common\Persistence\ObjectManager;

use SONUser\Entity\User;

class LoadUser extends AbstractFixture{
    public function load(ObjectManager $manager){
        $user = new User();
        $user->setNome("Jonas")
            ->setEmail("jonasmweb@hotmail.com")
            ->setPassword(123456)
            ->setActive(true);
        //Persistindo a entidade criada.
        $manager->persist($user);
        //O flush permite a inser��o no banco de dados.
        $manager->flush();
        
        $user = new User();
        $user->setNome("João")
        ->setEmail("joaomweb@hotmail.com")
        ->setPassword(123456)
        ->setActive(true);
        //Persistindo a entidade criada.
        $manager->persist($user);
        //O flush permite a inser��o no banco de dados.
        $manager->flush();
    }
    
}
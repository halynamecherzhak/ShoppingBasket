<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
    }

    private  function loadUsers(ObjectManager $manager){
        $user = new User();
        $user->setUserName('Halyna');
        $user->setAddress('Doroshenka');
        $user->setRole('User');
        $user->setEmail('galya.mech@gmail.com');
        $user->setPhone('12345');
        $user->setPassword($this->passwordEncoder->encodePassword($user,'qwerty'));

        $manager->persist($user);
        $manager->flush();
    }
}

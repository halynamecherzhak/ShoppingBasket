<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixture extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
      $user = new User();
      $user->setUserName('Oksana');
      $user->setEmail('oksana.osmak@gmail.com');
      $user->setPhone('345');
      $user->setAddress('bla');
      $user->setRole('user');
      $user->setPassword($this->passwordEncoder->encodePassword($user,'qwerty'));

      $manager->persist($user);
      $manager->flush();
    }
}

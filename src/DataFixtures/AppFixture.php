<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
      $user = new User();
      $user->setUserName('Oksana');
      $user->setEmail('oksana.osmak@gmail.com');
      $user->setPhone('345');
      $user->setAddress('bla');
      $user->setRole('user');
      $user->setPassword('a');
      $manager->persist($user);

      $manager->flush();
    }
}

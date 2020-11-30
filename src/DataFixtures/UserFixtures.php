<?php
declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $admin = new User();
        $admin->setNickname('admin')
              ->setEmail('admin@email.com')
              ->setPlainPassword('password')
              ->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $user = new User();
        $user->setNickname('user')
              ->setEmail('user@email.com')
              ->setPlainPassword('password')
              ->setRoles([]);
        $manager->persist($user);

        $user2 = new User();
        $user2->setNickname('user2')
              ->setEmail('user2@email.com')
              ->setPlainPassword('password')
              ->setSuspendAt(new DateTimeImmutable())
              ->setRoles([]);
        $manager->persist($user2);
        $manager->flush();
    }
}

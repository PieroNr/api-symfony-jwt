<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\PostFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public $pwdHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->pwdHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {

        $userAdmin = new User();
        $userAdmin
            ->setEmail('admin@admin.fr')
            ->setFirstname('Admin')
            ->setLastname('Boy')
            ->setUsername('AdminBoy')
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN']);

        $pwd = "admin";

        $hashPwd = $this->pwdHasher->hashPassword(
            $userAdmin,
            $pwd
        );
        $userAdmin->setPassword($hashPwd);

        $manager->persist($userAdmin);
        $manager->flush();



        UserFactory::createMany(10);
        PostFactory::createMany(10, function () {
            return [
                "author" => UserFactory::random(),
            ];
        });
    }
}

<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    /**
     * @Route("/api/register", name="register", methods={"POST"})
     */
    public function register(Request $request, EntityManagerInterface $manager,UserPasswordHasherInterface $encoder)
    {
        $password = $request->get('password');
        $email = $request->get('email');
        $firstname = $request->get('firstname');
        $lastname = $request->get('lastname');
        $username = $request->get('username');
        $user = new User();
        $user->setPassword($encoder->hashPassword($user, $password));
        $user->setEmail($email);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setUsername($username);
        $manager->persist($user);
        try {
            $manager->persist($user);
            $manager->flush();
        } catch (UniqueConstraintViolationException $e) {
            return $this->json([
                'code' => $e->getCode(),
                'message' => $user->getEmail() . ' ou ' . $user->getUsername() . ' sont déjà utilisés !'
            ]);
        }

        return $this->json($user);
    }
}

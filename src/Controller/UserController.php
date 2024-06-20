<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    #[Route('/user/register', name: 'app_user_register')]

    public function register(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em)
    {
        // ... e.g. get the admin data from a registration form
        $user = new User();
        $user->setEmail("admin@gmail.com");
        $role = ['ROLE_ADMIN'];
        $user->setRoles($role);
        $plaintextPassword = "admin";

        // hash the password (based on the security.yaml config for the $user class)
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);
        $em->persist($user);
        //=====
        $user = new User();
        $user->setEmail("user@gmail.com");
        //$role=['ROLE_ADMIN'];
        //$user->setRoles($role);
        $plaintextPassword = "user";

        // hash the password (based on the security.yaml config for the $user class)
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);
        $em->persist($user);
        //=====
        //=====
        $user = new User();
        $user->setEmail("super_admin@gmail.com");
        $role = ['ROLE_SUPER_ADMIN'];
        $user->setRoles($role);
        $plaintextPassword = "superadmin";

        // hash the password (based on the security.yaml config for the $user class)
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);
        $em->persist($user);
        //=====
        $em->flush();
        return $this->redirectToRoute('app_home');


        // ...
    }

    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $form = $this->createForm(
            LoginType::class,
            ['action' => $this->generateUrl('app_login')]
        );

        return $this->render('user/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
            'form' => $form->createView()
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout()
    {
        // controller can be blank: it will never be called!
        return $this->redirectToRoute('app_home');
    }
}

<?php

namespace App\Controller;

use App\Form\LoginForm;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="security_login")
     */
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginForm::class, [
            '_username' => $lastUsername,
        ]);

        return $this->render(
            'security/login.html.twig',
            array(
                'form' => $form->createView(),
                'error' => $error,
            )
        );
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function welcome(UserRepository $userRepository)
    {
        $usersCount = $userRepository->getUsersCount();
        return new Response('Count of already registered users:' . $usersCount);
    }

    /**
     * @Route("/check_login", name="check_login")
     */
    public function checkLogin(Request $request)
    {
    }

    /**
    * @Route("/logout", name="security_logout")
    */
    public function logoutAction()
    {
    }
}
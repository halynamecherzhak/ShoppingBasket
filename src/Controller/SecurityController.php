<?php

namespace App\Controller;

use App\Form\LoginForm;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\BrowserKit\Request;
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
    public function welcome()
    {
        return new Response('<html><body>Admin page!</body></html>');
    }

    /**
     * @Route("/check_login", name="check_login")
     */
    public function checkLogin( UserRepository $userRepository,Request $request)
    {
        $username = $request->get('_username');
        $user = $userRepository->findOneByUsernameOrEmail($username);
    }

    /**
    * @Route("/logout", name="security_logout")
    */
    public function logoutAction()
    {
        throw new \Exception('this should not be reached!');
    }
}
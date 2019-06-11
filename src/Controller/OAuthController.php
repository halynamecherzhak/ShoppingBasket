<?php
/**
 * Created by PhpStorm.
 * User: Halyna_Mecherzhak
 * Date: 6/7/2019
 * Time: 2:29 PM
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class OAuthController extends  AbstractController
{
    /**
     * @Route("/connect/token")
     */
    public function connectAction(ClientRegistry $clientRegistry)
    {
        $clientRegistry
            ->getClient('auth0')
        ->redirect(
        'connect_auth0_check"');
    }

    /**
     * Facebook redirects to back here afterwards
     *
     * @Route("/connect/check", name="connect_auth0_check")
     */
    public function connectCheckAction(Request $request)
    {
        $client = $this->get('oauth2.registry')
            ->getClient('auth0');

        $user = $client->fetchUser();
        // do something with all this new power!
        $user->getFirstName();
    }
}
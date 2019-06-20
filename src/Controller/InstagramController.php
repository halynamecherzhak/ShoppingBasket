<?php
/**
 * Created by PhpStorm.
 * User: Halyna_Mecherzhak
 * Date: 6/20/2019
 * Time: 10:59 AM
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Flex\Response;

class InstagramController extends  AbstractController
{
    public $settings = array(
        "clientID" => "6b41b72b035b4e948a733b0af32a2968",
        "clientSecret" => "b285d827e83c4dad9e6a58ac5f06668d",
        "redirectURI" => "http://127.0.0.1:8001/callback"
        );

    /**
     * @Route("/loginInstagram", name="loginInstagram")
     */
    public function loginInstagram(){
        return $this->render('security/login.php');
    }

    /**
     * @Route("/getLoginURL")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public  function  getLoginURL(){
         return $this->redirect( "https://api.instagram.com/oauth/authorize/?client_id=".$this->settings['clientID']."&redirect_uri=".$this->settings['redirectURI']."&response_type=code");
    }

    /**
     * @return string
     * @Route("/callback")
     */
    public function callback(){
        $code = $_GET['code'];
        $postFileds = array(
            "client_id" => $this->settings['clientID'],
            "client_secret" => $this->settings['clientSecret'],
            "grant_type" => "authorization_code",
            "redirect_uri" => $this->settings['redirectURI'],
            "code" => $code
        );

        dd($postFileds);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://api.instagram.com/oauth/access_token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($ch, CURLOPT_PORT,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFileds);
        $response = curl_exec($ch);
        curl_close($ch);
        //$data = json_decode($response, true);

        dd(json_decode($response,true));

    }
}
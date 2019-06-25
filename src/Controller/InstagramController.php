<?php
/**
 * Created by PhpStorm.
 * User: Halyna_Mecherzhak
 * Date: 6/20/2019
 * Time: 10:59 AM
 */

namespace App\Controller;

///use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\Exception\RedirectionException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Flex\Response;

class InstagramController extends  AbstractController
{
    public $settings = array(
        "clientID" => "6b41b72b035b4e948a733b0af32a2968",
        "clientSecret" => "b285d827e83c4dad9e6a58ac5f06668d",
        "redirectURI" => "http://127.0.0.1:8001/callback"
        );

    /**
     * @Route("/getLoginURL")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public  function  getLoginURL(){
         return $this->redirect( "https://api.instagram.com/oauth/authorize/?client_id=".$this->settings['clientID']."&redirect_uri=".$this->settings['redirectURI']."&response_type=code");
    }

    public  function  getAccessTokenAndUserDetails($code){
        $postFileds = array(
            "client_id" => $this->settings['clientID'],
            "client_secret" => $this->settings['clientSecret'],
            "grant_type" => "authorization_code",
            "redirect_uri" => $this->settings['redirectURI'],
            "code" => $code
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.instagram.com/oauth/access_token");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFileds);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, true);

        return $data;
    }

    /**
     * @Route("/callback")
     */
    public function callback(){
        $data = $this->getAccessTokenAndUserDetails($_GET['code']);

        return $this->redirectToRoute('getPosts' , ['access_token' => $data['access_token']]);
    }

//    /**
//     * @Route("/getPosts", name="getPosts")
//     */
//    public  function  getData(){
//        $access_token=$_GET['access_token'];
//        $photo_count=5;
//        $json_link="https://api.instagram.com/v1/users/self/media/recent/?";
//        $json_link.="access_token={$access_token}&count={$photo_count}";
//        $json = file_get_contents($json_link);
//        $obj = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);
//
//       foreach ($obj['data'] as $post) {
//
//            $pic_text = $post['caption']['text'];
//            $pic_link = $post['link'];
//            $pic_src = str_replace("http://", "https://", $post['images']['standard_resolution']['url']);
//
//            echo "<div class='col-md-4 col-sm-6 col-xs-12 item_box'>";
//            echo "<a href='{$pic_link}' target='_blank'>";
//            echo "<img class='img-responsive photo-thumb' src='{$pic_src}' alt='{$pic_text}'>";
//            echo "</a>";
//            echo "<p>";
//            echo "<p>";
//            echo "</div>";
//            echo "</p>";
//            echo "<p>{$pic_text}</p>";
//            echo "</p>";
//            echo "</div>";
//        }
//        return new Response();
//    }
    public function InstagramApiCurlConnect($api_url ){
        $connection_c = curl_init(); // initializing
        curl_setopt( $connection_c, CURLOPT_URL, $api_url ); // API URL to connect
        curl_setopt( $connection_c, CURLOPT_RETURNTRANSFER, 1 ); // return the result, do not print
        curl_setopt( $connection_c, CURLOPT_TIMEOUT, 20 );
        $json_return = curl_exec( $connection_c ); // connect and get json data
        curl_close( $connection_c ); // close connection
        return json_decode( $json_return ); // decode and return
    }

    /**
     * @Route("/getPosts", name="getPosts")
     */
    public  function  getParticularUserData(){
        $access_token = $_GET['access_token'];
        $username = 'galyna';
        $user_search = $this->InstagramApiCurlConnect("https://www.instagram.com/web/search/topsearch/?context=blended&query=" . $username . "&rank_token=" . $access_token);

        $user_name = $user_search->users[0]->user->username;

        $return = $this->InstagramApiCurlConnect("https://www.instagram.com/" . $user_name . "/?__a=1");

        $array = $return->graphql->user->edge_owner_to_timeline_media->edges;
        echo '<img src="'.$array[1]->node->display_url.'" /></a>';

        foreach ($return->graphql->user->edge_owner_to_timeline_media->edges as $array) {
            $array = get_object_vars($array);
            echo "<pre>";
            print_r($array);
            echo PHP_EOL;
//            foreach ($array->node as $nodes)
//                echo $nodes;
        }
        return new Response();
    }
}
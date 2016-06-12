<?php
namespace TwitterApp\DefaultBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use TwitterApp\DefaultBundle\Repository\Tweet;
use TwitterAPIExchange;

/**
 * Tweet controller.
 *
 * @Route("/twitter")
 */
class TweetController extends Controller
{

    private $settings = array( //Private class property containing our app authentication info
          'oauth_access_token' => "", // ;)
          'oauth_access_token_secret' => "", // ;)
          'consumer_key' => "", // ;)
          'consumer_secret' => "" // ;)
      );

    public $url = 'https://api.twitter.com/1.1/search/tweets.json'; //For the purposes of this demo we're always going to use the same URL from which to search for tweets

    /**
     * Our index function that listens for an AJAX call containing the search string and grabs the tweets. Otherwise defaults to rendering the search form. 
     *
     * @Route("/")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
      if( $request->isXMLHttpRequest() ) {  //Checking to make sure everything that was sent is actually an AJAX request 
        $tweetRepo = $this->getDoctrine()->getManager()->getRepository('TwitterAppDefaultBundle:Tweet');

        $searchStr = $request->request->get('searchStr'); //Grabs the search string from the request

        $twitter = new TwitterAPIExchange($this->settings); //Create our twitter API object by passing in our array of authentication info 
        $twitter = $twitter->setGetfield("?q=" . $searchStr) //Passing the appropriate search query
                           ->buildOauth($this->url, 'GET')
                           ->performRequest();

        $result = $tweetRepo->getReleventInfo($twitter); //Get our final result of an array of Tweet objects (src/Repository/TweetRepository.php)

        $response = new Response($result); //Builds a Response object from our results array

        return $response;
      }
      else
        return $this->render("TwitterAppDefaultBundle:Tweet:index.html.twig"); //If no AJAX call was heard we just simply render the form
    }
}

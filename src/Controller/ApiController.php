<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Entity\WishMovie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Doctrine\Persistence\ManagerRegistry;

class ApiController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }


    /**
     * @Route("/", name="homepage")
     */
    public function homepage(RequestStack $requestStack): Response
    {

        return $this->render('api/index.html.twig', []);


    }


    /**
     * @Route("/search", name="search")
     */
    public function search(RequestStack $requestStack): Response
    {
        $url = "https://api.themoviedb.org/3/search/";
        $keyAPI = "5ebe0843b2e373ffa159f5683b21b7de";


        $request = $requestStack->getMainRequest();
        $cat = $request->query->get("category");
        $value = $request->query->get("value");

        $page = "1";
        $lang = "fr-FR";

        $newUrl = $url . $cat . "?api_key=" . $keyAPI . "&language=" . $lang . "&query=" . $value . "&page=" . $page;


        $response = $this->client->request(
            'GET',
            $newUrl
        );

        $array = json_decode($response->getContent(), true);
        $results = $array['results'];

        return $this->render('api/result.html.twig', [
            'results' => $results
        ]);

    }

    /**
     * @Route("/movie/{id}", name="one_movie")
     */
    public function OneMovie($id, RequestStack $requestStack)
    {
        $request = $requestStack->getMainRequest();
        $url = "https://api.themoviedb.org/3/";
        $api = "5ebe0843b2e373ffa159f5683b21b7de";


        $lang = "fr-FR";


        $url = $url ."movie/" . $id . "?api_key=" .$api. "&language=". $lang;
        $response = $this->client->request(
            'GET',
            $url
        );
        $result = json_decode($response->getContent(), true);

        return $this->render('api/one_result.html.twig', [
            "result" => $result
        ]);
    }
    /**
     * @Route("/list-movies", name="list_movies")
     */
    public function listMovies( ManagerRegistry $doctrine)
    {

        $wishMovies = $doctrine->getRepository(WishMovie::class)->findAll();
        $actors = $doctrine->getRepository(Actor::class)->findAll();

        return $this->render('api/wish_movies.html.twig', [
            "wish_movies" => $wishMovies,
            "actors" => $actors
        ]);


    }
}

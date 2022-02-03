<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

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



}

<?php

namespace App\Controller;

use App\Entity\Actor;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ActorsController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    /**
     * @Route("/add-actor/{id}", name="add_actor")
     */
    public function AddtoWishActors($id, ManagerRegistry $doctrine, RequestStack $requestStack)
    {
        $request = $requestStack->getMainRequest();
        $url = "https://api.themoviedb.org/3/";
        $api = "5ebe0843b2e373ffa159f5683b21b7de";


        $lang = "fr-FR";


        $url = $url ."person/" . $id . "?api_key=" .$api. "&language=". $lang;
        $response = $this->client->request(
            'GET',
            $url
        );
        $result = json_decode($response->getContent(), true);
        $resultName = $result['name'];
        $entityManager = $doctrine->getManager();
        $actor = new Actor();
        $actor->setName($resultName);
        $actor->setIdTheMovieDb($result['id']);
        $actor->setDate(new \DateTime());
        $entityManager->persist($actor);

        $entityManager->flush();

        return $this->redirectToRoute('list_movies');


    }
    /**
     * @Route("/person/{id}", name="one_celeb")
     */
    public function Onecelebrity($id, RequestStack $requestStack)
    {
        $request = $requestStack->getMainRequest();
        $url = "https://api.themoviedb.org/3/";
        $api = "5ebe0843b2e373ffa159f5683b21b7de";


        $lang = "fr-FR";


        $url = $url ."person/" . $id . "?api_key=" .$api. "&language=". $lang;
        $response = $this->client->request(
            'GET',
            $url
        );
        $result = json_decode($response->getContent(), true);

        return $this->render('api/one_celeb.html.twig', [
            "result" => $result
        ]);
    }

}

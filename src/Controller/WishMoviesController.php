<?php

namespace App\Controller;

use App\Entity\WishMovie;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class WishMoviesController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @Route("/add-movie/{id}", name="add_movie")
     */
    public function AddtoWishMovies($id, ManagerRegistry $doctrine, RequestStack $requestStack)
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
        $resultName = $result['title'];
        $entityManager = $doctrine->getManager();
        $wishMovie = new WishMovie();
        $wishMovie->setDateAdd(New \DateTime());
        $wishMovie->setIdTheMovieDb($id);
        $wishMovie->setName($resultName);
        $entityManager->persist($wishMovie);

        $entityManager->flush();

        return $this->redirectToRoute('list_movies');


    }
    /**
     * @Route("/delete-movie/{id}", name="delete_movie")
     */
    public function deleteProduct(int $id, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $wishMovie = $entityManager->getRepository(WishMovie::class)->find($id);
        $entityManager->remove($wishMovie);
        $entityManager->flush();

        return $this->redirectToRoute("list_movies");
    }

}

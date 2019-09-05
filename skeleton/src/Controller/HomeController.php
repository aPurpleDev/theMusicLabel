<?php

namespace App\Controller;

use App\Repository\AlbumRepository;
use App\Repository\EventRepository;
use App\Repository\NewsRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     * @return Response
     */
    public function index(NewsRepository $newsRepository, AlbumRepository $albumRepository, EventRepository $eventRepository, UserRepository $userRepository): Response
    {
        //displays last 5 of our relevant objects, except users (the last 5 are kept there for admin view purposes, but not displayed yet)
        $newsListing = $newsRepository->findBy(array(), array('id' => 'DESC'), 5, 1);
        $albumListing = $albumRepository->findBy(array(), array('id' => 'DESC'), 5, 1);
        $eventListing = $eventRepository->findBy(array(), array('id' => 'DESC'), 5, 1);
        $userListing = $userRepository->findBy(array(), array('id' => 'DESC'), 5, 1);

        $shoppingCart = null;

        if (isset($_SESSION['shoppingCart'])) {
            $shoppingCart = $_SESSION['shoppingCart'];
        }

        return $this->render('home/index.html.twig', ['newslisting' => $newsListing, 'albumlisting' => $albumListing, 'userlisting' => $userListing, 'eventlisting' => $eventListing, 'shoppingcart' => $shoppingCart]);
    }
}
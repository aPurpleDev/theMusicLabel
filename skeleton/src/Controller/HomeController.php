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
     * @param NewsRepository $newsRepository
     * @param AlbumRepository $albumRepository
     * @param EventRepository $eventRepository
     * @param UserRepository $userRepository
     * @return Response
     */
    public function index(NewsRepository $newsRepository, AlbumRepository $albumRepository, EventRepository $eventRepository ,UserRepository $userRepository): Response
    {
        $newsListing = $newsRepository->findBy(array(),array('id'=>'DESC'),5,1);
        $albumListing = $albumRepository->findBy(array(),array('id'=>'DESC'),5,1);
        $eventListing = $eventRepository->findBy(array(),array('id'=>'DESC'),5,1);
        $userListing = $userRepository->findBy(array(),array('id'=>'DESC'),5,1);

        $shoppingCart = null;

        if(isset($_SESSION['shoppingCart']))
        {
        $shoppingCart = $_SESSION['shoppingCart'];
        }

        return $this->render('home/index.html.twig',['newslisting' => $newsListing, 'albumlisting' => $albumListing, 'userlisting' => $userListing, 'eventlisting' => $eventListing, 'shoppingcart' => $shoppingCart]);
    }
}
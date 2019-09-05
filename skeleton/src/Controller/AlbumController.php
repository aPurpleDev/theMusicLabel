<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\OrderLog;
use App\Entity\User;
use App\Form\AlbumType;
use App\Repository\AlbumRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/album")
 */
class AlbumController extends AbstractController
{
    /**
     * @Route("/", name="album_index", methods={"GET"})
     * @param AlbumRepository $albumRepository
     * @return Response
     */
    public function index(AlbumRepository $albumRepository): Response
    {
        return $this->render('album/index.html.twig', [
            'albums' => $albumRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="album_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $album = new Album();
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($album);
            $entityManager->flush();

            return $this->redirectToRoute('album_index');
        }

        return $this->render('album/new.html.twig', [
            'album' => $album,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="album_show", methods={"GET"})
     * @param Album $album
     * @return Response
     */
    public function show(Album $album): Response
    {
        return $this->render('album/show.html.twig', [
            'album' => $album,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="album_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Album $album
     * @return Response
     */
    public function edit(Request $request, Album $album): Response
    {
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('album_index');
        }

        return $this->render('album/edit.html.twig', [
            'album' => $album,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="album_delete", methods={"DELETE"})
     * @param Request $request
     * @param Album $album
     * @return Response
     */
    public function delete(Request $request, Album $album): Response
    {
        if ($this->isCsrfTokenValid('delete' . $album->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($album);
            $entityManager->flush();
        }

        return $this->redirectToRoute('album_index');
    }

    /**
     * @Route("/{id}/buy", name="album_buy", methods={"GET","POST"})
     * @param Album $album
     * @param ObjectManager $manager
     * @param AlbumRepository $albumRepository
     * @return Response
     */
    public function buy(Album $album, ObjectManager $manager, AlbumRepository $albumRepository): Response
    {

        if ($this->getUser() instanceof User) {

            $orderLog = new OrderLog();
            $orderLog->setAlbum($album);

            $manager->persist($orderLog);
            $manager->flush();

            if(isset($_SESSION["shoppingCart"]))
            {
            $shoppingCart = $_SESSION["shoppingCart"];
            $shoppingCart[] = $orderLog;
            $_SESSION["shoppingCart"] = $shoppingCart;
            }
            else{
            $shoppingCart = [];
            $shoppingCart[] = $orderLog;
            $_SESSION["shoppingCart"] = $shoppingCart;
            }


            return $this->render('album/index.html.twig', [
                'album' => $album, 'orders' => $this->getUser()->getOrders(), 'shoppingcart' => $_SESSION["shoppingCart"], 'albums' => $albumRepository->findAll()
            ]);
        }

        return $this->redirectToRoute('app_login');
    }
}

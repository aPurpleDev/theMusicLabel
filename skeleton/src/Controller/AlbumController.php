<?php

namespace App\Controller;

use App\Entity\Album;
use App\Entity\Event;
use App\Entity\OrderLog;
use App\Entity\Orders;
use App\Entity\User;
use App\Form\AlbumType;
use App\Interfaces\BuyableInterface;
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
     */
    public function index(AlbumRepository $albumRepository): Response
    {
        return $this->render('album/index.html.twig', [
            'albums' => $albumRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="album_new", methods={"GET","POST"})
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
     */
    public function show(Album $album): Response
    {
        return $this->render('album/show.html.twig', [
            'album' => $album,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="album_edit", methods={"GET","POST"})
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
     */
    public function buy(Album $album, ObjectManager $manager): Response
    {

        if ($this->getUser() instanceof User) {
            $orderlog = new OrderLog();
            $order = new Orders();

            $orderlog->setAlbum($album);
            $orderlog->setOrdernumber($order);
            $order->setOrderDate(new \DateTime());
            $order->setTotalPrice($album->getPrice());
            $order->setUser($this->getUser());

            $manager->persist($orderlog);
            $manager->persist($order);
            $manager->flush();

            $order->setOrderNumber($orderlog->getId());
            $manager->flush();

            return $this->render('home/index.html.twig', [
                'album' => $album
            ]);
        }

        return $this->redirectToRoute('app_login');
    }
}

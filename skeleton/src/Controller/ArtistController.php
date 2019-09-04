<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Event\SubEvent;
use App\Event\UnsubEvent;
use App\Form\ArtistType;
use App\Form\SubType;
use App\Form\UnsubType;
use App\Repository\ArtistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/artist")
 */
class ArtistController extends AbstractController
{
    /**
     * @Route("/", name="artist_index", methods={"GET"})
     */
    public function index(ArtistRepository $artistRepository): Response
    {
        return $this->render('artist/index.html.twig', [
            'artists' => $artistRepository->findAll(),
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/new", name="artist_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $artist = new Artist();
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($artist);
            $entityManager->flush();

            return $this->redirectToRoute('artist_index');
        }

        return $this->render('artist/new.html.twig', [
            'artist' => $artist,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="artist_show", methods={"GET", "POST"})
     */
    public function show(Request $request, Artist $artist, EventDispatcherInterface $dispatcher, ArtistRepository $artistRepository): Response
    {

        $form = $this->createForm(SubType::class);
        $form->handleRequest($request);
        $formUnsub = $this->createForm(UnsubType::class);
        $formUnsub->handleRequest($request);
        $user = null;


        if ($this->getUser()) {
            $user = $artistRepository->findSubby($this->getUser()->getId());

            if($form->get('sub')->isClicked()) {
                $e = new SubEvent($artist, $this->getUser());
                $dispatcher->dispatch($e, SubEvent::NAME);
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('artist_show', [
                    'id' => $artist->getId(),
                    'artist' => $artist,
                    'subForm' => ($user) ? $formUnsub->createView() : $form->createView()
                ]);
            }

            if($formUnsub->get('unsub')->isClicked()) {
                $e = new UnsubEvent($artist, $this->getUser());
                $dispatcher->dispatch($e, UnsubEvent::NAME);
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('artist_show', [
                    'id' => $artist->getId(),
                    'artist' => $artist,
                    'subForm' => ($user) ? $formUnsub->createView() : $form->createView()
                ]);
            }

            return $this->render('artist/show.html.twig', [
                'artist' => $artist,
                'user' => $this->getUser(),
                'subForm' => ($user) ? $formUnsub->createView() : $form->createView()
            ]);
        }


        return $this->render('artist/show.html.twig', [
            'artist' => $artist,
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="artist_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Artist $artist): Response
    {
        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('artist_index');
        }

        return $this->render('artist/edit.html.twig', [
            'artist' => $artist,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="artist_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Artist $artist): Response
    {
        if ($this->isCsrfTokenValid('delete'.$artist->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($artist);
            $entityManager->flush();
        }

        return $this->redirectToRoute('artist_index');
    }
}

<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\OrderLog;
use App\Entity\User;
use App\Form\EventType;
use App\Repository\EventRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/event")
 */
class EventController extends AbstractController
{
    /**
     * @Route("/", name="event_index", methods={"GET"})
     */
    public function index(EventRepository $eventRepository): Response
    {
        return $this->render('event/index.html.twig', [
            'events' => $eventRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="event_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/new.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_show", methods={"GET"})
     */
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="event_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Event $event): Response
    {
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_index');
        }

        return $this->render('event/edit.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Event $event): Response
    {
        if ($this->isCsrfTokenValid('delete' . $event->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_index');
    }

    /**
     * @Route("/{id}/buy", name="event_buy", methods={"GET","POST"})
     */
    public function buy(Event $event, ObjectManager $manager, EventRepository $eventRepository): Response
    {
        //add an orderlog (command line) containing an instance of the event object bought
        if ($this->getUser() instanceof User) {
            $orderlog = new OrderLog();

            $orderlog->setEvent($event);

            $manager->persist($orderlog);
            $manager->flush();

            if (isset($_SESSION["shoppingCart"])) {
                $shoppingCart = $_SESSION["shoppingCart"];
                $shoppingCart[] = $orderlog;
                $_SESSION["shoppingCart"] = $shoppingCart;
            } else {
                $shoppingCart = [];
                $shoppingCart[] = $orderlog;
                $_SESSION["shoppingCart"] = $shoppingCart;
            }

            return $this->render('event/index.html.twig', [
                'event' => $event, 'shoppingcart' => $_SESSION["shoppingCart"], 'events' => $eventRepository->findAll()
            ]);
        }

        return $this->redirectToRoute('app_login');
    }
}

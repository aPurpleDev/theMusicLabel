<?php

namespace App\Controller;

use App\Entity\OrderLog;
use App\Form\OrderLogType;
use App\Repository\OrderLogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/orders/log")
 */
class OrderLogController extends AbstractController
{
    /**
     * @Route("/", name="order_log_index", methods={"GET"})
     */
    public function index(OrderLogRepository $orderLogRepository): Response
    {
        return $this->render('order_log/index.html.twig', [
            'order_logs' => $orderLogRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="order_log_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $orderLog = new OrderLog();
        $form = $this->createForm(OrderLogType::class, $orderLog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($orderLog);
            $entityManager->flush();

            return $this->redirectToRoute('order_log_index');
        }

        return $this->render('order_log/new.html.twig', [
            'order_log' => $orderLog,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="order_log_show", methods={"GET"})
     */
    public function show(OrderLog $orderLog): Response
    {
        return $this->render('order_log/show.html.twig', [
            'order_log' => $orderLog,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="order_log_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, OrderLog $orderLog): Response
    {
        $form = $this->createForm(OrderLogType::class, $orderLog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('order_log_index');
        }

        return $this->render('order_log/edit.html.twig', [
            'order_log' => $orderLog,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="order_log_delete", methods={"DELETE"})
     */
    public function delete(Request $request, OrderLog $orderLog): Response
    {
        if ($this->isCsrfTokenValid('delete'.$orderLog->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($orderLog);
            $entityManager->flush();
        }

        return $this->redirectToRoute('order_log_index');
    }
}

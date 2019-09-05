<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Entity\User;
use App\Event\OrderEvent;
use App\Form\UserType;
use App\Repository\AlbumRepository;
use App\Repository\EventRepository;
use App\Repository\NewsRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/myorders", name="user_orders", methods={"GET"})
     */
    public function myOrders(): Response
    {

        if ($this->getUser()) {
            $user = $this->getUser();
            return $this->render('user/user_orders.html.twig', [
                'orders' => $user->getOrders()
            ]);
        }

        return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/myshoppingcart", name="user_cart", methods={"GET"})
     */
    public function myShoppingCart(): Response
    {
        //dedicated view for user's shoppingCart: orderlog created by user not persisted as order yet
        if (isset($_SESSION["shoppingCart"])) {
            return $this->render('user/user_shoppingcart.html.twig', [
                'shoppingcart' => $_SESSION["shoppingCart"]
            ]);
        }

        echo '<script type="text/javascript">window.alert("Cart is Empty. Returning to Homepage")</script>';

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/myshoppingcart/pay", name="user_pay", methods={"GET"})
     * @param ObjectManager $manager
     * @param NewsRepository $newsRepository
     * @param EventDispatcherInterface $dispatcher
     * @param AlbumRepository $albumRepository
     * @param EventRepository $eventRepository
     * @param UserRepository $userRepository
     * @return Response
     * @throws \Exception
     */
    public function payShoppingCart(ObjectManager $manager, NewsRepository $newsRepository, EventDispatcherInterface $dispatcher, AlbumRepository $albumRepository, EventRepository $eventRepository, UserRepository $userRepository): Response
    {
        //persists user's orderlog as an order object, and populate it in the database after clearing user's shoppingcart
        if (isset($_SESSION["shoppingCart"])) {
            $order = new Orders();
            $order->setUser($this->getUser());
            $order->setOrderDate(new DateTime());
            $order->setOrderNumber($order->getId() + rand(100, 1000000));
            $manager->persist($order);
            $manager->flush();

            $shoppingCart = $_SESSION["shoppingCart"];
            $totalPrice = 0;

            foreach ($shoppingCart as $value) {
                if ($value->getAlbum() != null) {
                    $a = $albumRepository->find($value->getAlbum()->getId());
                    $value->setAlbum($a);
                    $order->addOrderLog($value);
                    $manager->flush();
                    $totalPrice += $a->getPrice();
                }

                if ($value->getEvent() != null) {
                    $e = $eventRepository->find($value->getEvent()->getId());
                    $value->setEvent($e);
                    $order->addOrderLog($value);
                    $manager->flush();
                    $totalPrice += $e->getPrice();
                }
            }

            $order->setTotalPrice((int)$totalPrice);
            $manager->persist($order);
            $manager->flush();
            $e = new OrderEvent($order, $this->getUser());
            $dispatcher->dispatch($e, OrderEvent::NAME);
            $shoppingCart = null;
            unset($_SESSION["shoppingCart"]);

            $newsListing = $newsRepository->findBy(array(), array('id' => 'DESC'), 5, 1);
            $albumListing = $albumRepository->findBy(array(), array('id' => 'DESC'), 5, 1);
            $eventListing = $eventRepository->findBy(array(), array('id' => 'DESC'), 5, 1);
            $userListing = $userRepository->findBy(array(), array('id' => 'DESC'), 5, 1);

            $message = 'Your order has been paid. Total: ' . $order->getTotalPrice() . ' €. An email confirmation has been sent to ' . $this->getUser()->getEmail() . ". Thank you! 💜";

            echo '<div class = "alert alert-success"><script class = type="text/javascript">window.alert("' . $message . '");</script></div>';

            return $this->render('home/index.html.twig', ['newslisting' => $newsListing, 'albumlisting' => $albumListing, 'userlisting' => $userListing, 'eventlisting' => $eventListing, 'shoppingcart' => $shoppingCart, 'order' => $order]);
        }

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/", name="user_index", methods={"GET"})
     * @param UserRepository $userRepository
     * @return Response
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     * @param User $user
     * @return Response
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}

<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\OrderType;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/commande', name: 'order')]
    public function index(Cart $cart,Request $request): Response
    {
        if(!$this->getUser()->getAddresses()->getValues())
        {
            return $this->redirectToRoute('account_address_add');
        }

        $form = $this->createForm(OrderType::class,null,[
            'user' => $this->getUser(),
        ]);

        return $this->render('order/index.html.twig',[
            'form' => $form->createView(),
            'cart' => $cart->getfull()
        ]);
    }

    #[Route('/commande/recapitulatif', name: 'order_recap')]
    public function add(Cart $cart,Request $request): Response
    {
        $form = $this->createForm(OrderType::class,null,[
            'user' => $this->getUser(),
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $order = new Order();
            $carrier = $form->get('transporteur')->getData();
           
            $delivery = $form->get('adresses')->getData();
            
            $delivery_content = $delivery->getFirstname().' '.$delivery->getLastname();
            $delivery_content .= '</br>'.$delivery->getPhone();

            if($delivery->getCompany())
            {
                $delivery_content .= '</br>'.$delivery->getCompany();
            }

            $delivery_content .= '</br>'.$delivery->getAddress();
            $delivery_content .= '</br>'.$delivery->getPostal().' '.$delivery->getCity();;
            $delivery_content .= '</br>'.$delivery->getCountry();

            // dd( $delivery_content);
            $order->setUser($this->getUser());
            $order->setCreatedAt(new \DateTimeImmutable('now'));
            $order->setCarriername($carrier->getName());
            $order->setCarrierprice($carrier->getPrice());
            $order->setDelivery($delivery_content);
            $order->setIsPaid(false);
            
            $this->entityManager->persist($order);

            foreach ($cart->getfull() as $product)
            {
                $orderDetails = new OrderDetails();
                $orderDetails->setMyorder($order);
                $orderDetails->setProduct($product['product']->getName());
                $orderDetails->setQuantity($product['quantity']);
                $orderDetails->setPrice($product['product']->getPrice());
                $orderDetails->setTotal($product['product']->getPrice() * $product['quantity']);
            }

            $this->entityManager->flush();
        }

        return $this->render('order/index.html.twig',[
            'form' => $form->createView(),
            'cart' => $cart->getfull()
        ]);
    }
}

<?php

namespace App\Controller;
use App\Classe\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private $entitymanager;

    public function __construct(EntityManagerInterface $entityManage){
        $this->entityManager = $entityManage;
    }

    #[Route('/mon-panier', name: 'cart')]
    public function index(Cart $cart): Response
    {
        
        return $this->render('cart/index.html.twig',[
            'cart' => $cart->getfull()
        ]);
    }

    #[Route('/cart/add/{id}', name:'add-to-cart')]
    public function add(Cart $cart,$id): Response
    {
        $cart->add($id);
        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/remove', name:'remove-my-cart')]
    public function remove(Cart $cart): Response
    {
        $cart->remove();

        return $this->redirectToRoute('product');
    }

    
    #[Route('/cart/delete/{id}', name:'delete-to-cart')]
    public function delete(Cart $cart,$id): Response
    {
        $cart->delete($id);

        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/decrase/{id}', name:'decrase-to-cart')]
    public function decrase(Cart $cart,$id): Response
    {
        $cart->decrase($id);

        return $this->redirectToRoute('cart');
    }
}

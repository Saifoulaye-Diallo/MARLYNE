<?php

namespace App\Controller;

use App\Classe\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Address;
use App\Form\AdressType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class AccountAddressController extends AbstractController
{
    private $entitymanager;

    public function __construct(EntityManagerInterface $entityManage){
        $this->entityManager = $entityManage;
    }


    #[Route('/compte/adresse', name: 'account_address')]
    public function index(): Response
    {
        return $this->render('accounte/adress.html.twig');
    }

    #[Route('/compte/ajouter-une-adresse', name: 'account_address_add')]
    public function add(Cart $cart,Request $request): Response
    {
        $adresse = new Address();

        $form = $this->createForm(AdressType::class, $adresse);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $adresse->setUser($this->getUser());
            $this->entityManager->persist($adresse);
            $this->entityManager->flush();

            if($cart->get()){
                return $this->redirectToRoute('order');
            }else{
                return $this->redirectToRoute('account_address');
            }

        }
        return $this->render('accounte/adress_add.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    #[Route('/compte/modifier-une-adresse/{id}', name: 'account_address_update')]
    public function update(Request $request,$id): Response
    {
        $adresse = $this->entityManager->getRepository(Address::class)->findOneById($id);
        if(!$adresse || $adresse->getUser()  != $this->getUser() ){
            return $this->redirectToRoute('account_address');
        }
        $form = $this->createForm(AdressType::class, $adresse);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->flush();
           return  $this->redirectToRoute('account_address');
        }
        return $this->render('accounte/adress_add.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    #[Route('/compte/supprimer-une-adresse/{id}', name: 'account_address_delete')]
    public function delete($id): Response
    {
        $adresse = $this->entityManager->getRepository(Address::class)->findOneById($id);
        if(!$adresse || $adresse->getUser() != $this->getUser() ){
           
            return $this->redirectToRoute('account_address');
        }
        $this->entityManager->remove($adresse);
        $this->entityManager->flush();
        return  $this->redirectToRoute('account_address');
    }
}

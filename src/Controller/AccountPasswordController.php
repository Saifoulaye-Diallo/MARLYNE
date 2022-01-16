<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountPasswordController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){

        $this->entityManager = $entityManager;

    }
    #[Route('/compte/mot_de_passe', name: 'account_password')]
    public function index(Request $request,UserPasswordEncoderInterface $encoder): Response
    {
      $notifiacation = null;
       $user = $this->getUser();
       $form = $this->createForm(ChangePasswordType::class,$user);

       $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) { 
           $hold_password = $form->get('hold_password')->getData();
           if($encoder->isPasswordValid($user,$hold_password)){

                $new_pwd = $form->get('new_password')->getData();
                $password = $encoder->encodePassword($user,$new_pwd);

                $user->setPassword($password);

                $this->entityManager->flush(); 

                $notifiacation = 'Votre mot de passe à bien été mis à jour !!';
           }else{
            $notifiacation = "Votre mot de passe actuel n'est pas le bon !!";
           }
       }
        return $this->render('accounte/password.html.twig',[
           'form' => $form->createView(),
           'notifiacation' => $notifiacation
        ]);
    }
}

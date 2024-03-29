<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RegisterType;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    private $EntityManager;

    public function __construct(EntityManagerInterface $entityManager){

        $this->entityManager = $entityManager;

    }

    #[Route('/inscription', name: 'registration')]
    public function index(Request $request,UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form =$this->createForm(RegisterType::class, $user);
      

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();

            $password = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($password);

            $this->entityManager->persist($user);
            $this->entityManager->flush(); 
        }

        return $this->render('registration/index.html.twig', [
            'form'=> $form->createView(),
        ]);
    }
}

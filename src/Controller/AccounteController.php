<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccounteController extends AbstractController
{
    #[Route('/compte', name: 'accounte')]
    public function index(): Response
    {
        return $this->render('accounte/index.html.twig');
    }
}

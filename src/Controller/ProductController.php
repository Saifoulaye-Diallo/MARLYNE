<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Classe\Search;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    private $entitymanager;

    public function __construct(EntityManagerInterface $entityManage){
        $this->entityManager = $entityManage;
    }
    
    #[Route('/nos-produits', name: 'products')]
    public function index(Request $request): Response
    {
        $search = new Search();

        $produits = $this->entityManager->getRepository(Product::class)->findAll();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
             $produits = $this->entityManager->getRepository(Product::class)->findWithSearch($search);
        }
        return $this->render('product/index.html.twig',[
            'products' => $produits,
            'form' => $form->createView()
        ]);
    }

    #[Route('/produit/{slog}', name: 'product')]
    public function show($slog): Response
    {
        $produit = $this->entityManager->getRepository(Product::class)->findOneBySlog($slog);
        return $this->render('product/show.html.twig',[
            'product' => $produit,
        ]);
    }
}
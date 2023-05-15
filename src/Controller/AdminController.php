<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\UserRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;

#[Route('/admin', name: 'admin_')]
class AdminController extends AbstractController
{
    private UserRepository $userRepository;
    private OrderRepository $orderRepository;
    private ProductRepository $productRepository;
    private Security $security;
    private ManagerRegistry $doctrine;

    public function __construct(OrderRepository $orderRepository, ProductRepository $productRepository,Security $security, ManagerRegistry $doctrine)
    {
        $this->orderRepository = $orderRepository;
        //parent::__construct();
        $this->security = $security;
        $this->doctrine = $doctrine;
        $this->productRepository = $productRepository;
    }

    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    
    #[Route('/login', name: 'app_login')]
    public function login(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/listing', name: 'app_listing')]
    public function listing(): Response
    {

        $orderList = $this->orderRepository->findAll();

        return $this->render('admin/listing.html.twig', [
            'controller_name' => 'AdminController',
            'list' => $orderList
        ]);
    }

}

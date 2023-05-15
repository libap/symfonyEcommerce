<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\User;
use App\Entity\Order;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Repository\ProductRepository;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\Persistence\ManagerRegistry;

class PublicController extends AbstractController
{


    private ProductRepository $productRepository;
    private UserPasswordHasherInterface $passwordHasher;
    private Security $security;
    private ManagerRegistry $doctrine;

    public function __construct(UserPasswordHasherInterface $passwordHasher, ProductRepository $productRepository, Security $security, ManagerRegistry $doctrine)
    {
        $this->productRepository = $productRepository;
        //parent::__construct();
        $this->security = $security;
        $this->doctrine = $doctrine;
        $this->passwordHasher = $passwordHasher;

    }

    #[Route('/public', name: 'app_public')]
    public function index(): Response
    {

        $productList = $this->productRepository->findAll();

        $images = array(
            'img/image0.jpg',
            'img/image1.jpg',
            'img/image2.jpg',
            'img/image3.jpg',
            'img/image4.jpg',
            'img/image5.jpg',
            'img/image6.jpg',
            'img/image7.jpg',
            'img/image8.jpg',
            'img/image9.jpg',
            'img/image0.jpg',
            'img/image1.jpg',
            'img/image2.jpg',
            'img/image3.jpg',
            'img/image4.jpg',
            'img/image5.jpg',
            'img/image6.jpg',
            'img/image7.jpg',
            'img/image8.jpg',
            'img/image9.jpg'
        );

        return $this->render('public/index.html.twig', [
            'controller_name' => 'PublicController',
            'list' => $productList,
            'images' => $images
        ]);
    }

    #[Route('/product/{id}', name: 'app_product')]
    public function product($id): Response
    {
        $product = $this->productRepository->findAll(['id'=>$id]);
        return $this->render('public/product.html.twig', [
            'controller_name' => 'PublicController',
            'product' => $product
        ]);
    }

    #[Route('/public', name: 'app_order')]
    public function order($id, Security $security, OrderRepository $orderRepository): Response
    {
        $product = $this->productRepository->find(['id'=>$id]);
        $username = null;
        
        if ($security->isGranted('IS_AUTHENTICATED_FULLY')) {
            $user = $security->getUser();
            $username = $user->getFirstName();
        }

        // Créer une nouvelle commande
        $order = new Order();
        $order->setDate(new \DateTime());
        $order->setStatus('en cours');
        $order->setUser($user);
        $order->addProduct($product);

        // Sauvegarder la commande en base de données
        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($order);
        $entityManager->flush();
        
        return $this->render('public/order.html.twig', [
            'controller_name' => 'PublicController',
            'product' => $product,
            'username' => $username
        ]);
    }




/*
    #[Route('/order/{id}', name: 'app_order')]
    public function order($id): Response
    {
        $product = $this->productRepository->find(['id'=>$id]);
        $product = $this->productRepository->find(['id'=>$id]);
        return $this->render('public/order.html.twig', [
            'controller_name' => 'PublicController',
            'product' => $product
        ]);
    }*/

    #[Route('/login/check', name: 'app_check')]
    public function check(): Response
    {
        #Si on arrive pas à recuperer l'utilisateur, on est envoyé vers le login
        $user = $this->security->getUser();

        #Si tout se passe bien on est renvoyé à la base du site mais loggé
        return $this->redirectToRoute('/');
    }

    #[Route('/login/form', name : 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response 
    {
        //Recupere l'erreur d'auth
        $error = $authenticationUtils->getLastAuthenticationError();

        #Recupere le dernier login d'utilisateur donné
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('public/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): Response
    {
        //On demande à la sécurité de se déloguer
        $this->security->logout();

        //Si tout se passe bien on est renvoyé à l abase du site, délogué
        return new RedirectResponse('/');
    }


    #[Route("/user/create", name:"user_create")]
    public function createUserAction(Request $request): Response
    {
    $user = new User(); // ATTENTION mettre VOTRE classe user
    $form = $this->createFormBuilder($user)
        ->add('login', TextType::class) // On ajoute les champs adresse, cp, ville, etc…
        ->add('password', TextType::class)
        ->add('adress', TextType::class)
        ->add('postalCode', TextType::class)
        ->add('firstName', TextType::class)
        ->add('lastName', TextType::class)
        ->add('save', SubmitType::class, ['label' => 'Sauvegarder'])
        ->getForm();

        $form->handleRequest($request);
    
        //A ajouter avant le render
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData(); //On récupère l’objet
            $user->setRoles(['ROLE_USER']); //On force l’utilisateur à être un ROLE_USER normal

            $plainTextPassword = $user->getPassword(); //Get password
            $hashedPassword = $this->passwordHasher->hashPassword( // Crytpting password
                $user,
                $plainTextPassword
            );
            $user->setPassword($hashedPassword);

            $em = $this->doctrine->getManager();    
                    try {
            $em->persist($user); //La Sauvegarde
            $em->flush();  	 
            return new RedirectResponse('/');
                    } catch (UniqueConstraintViolationException $e){
                        $form->get('login')->addError(new FormError('Identifiant déjà utilisé')); //Mettre le bon champ identifiant
                    }
            }
            
    
    return $this->render('public/createUser.html.twig', array(
                'form' => $form->createView(), // on le passe au template
    
    ));
    }

}

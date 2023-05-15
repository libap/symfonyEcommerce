<?php

namespace App\Command;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    // ./symfony console create-product   
    name: 'create-product',
    description: 'Add a short description for your command',
)]
class AddTenProductCommand extends Command
{

    private ManagerRegistry $doctrine;

    protected function configure(): void
    {
        /*$this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;*/
    }

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        parent::__construct();
    }



    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        

        $entityManager = $this->doctrine->getManager();

        $moto1 = new Product;
        $moto1->setName('Honda CB650R');
        $moto1->setPrice(8699.99);
        $moto1->setPlatforms('Route');
        $moto1->setDescription('Moto sportive, design moderne et agressif.');
        $moto1->setReleaseDate(new \DateTime('2022-03-01'));
        //$moto1->setPhotoPath('moto1.jpg');
        $entityManager->persist($moto1);
        
        $moto2 = new Product;
        $moto2->setName('BMW R 1250 GS');
        $moto2->setPrice(19045.99);
        $moto2->setPlatforms('Route, piste');
        $moto2->setDescription('Moto adventure-touring performante.');
        $moto2->setReleaseDate(new \DateTime('2022-05-01'));
        //$moto2->setPhotoPath('moto2.jpg');
        $entityManager->persist($moto2);
        
        $moto3 = new Product;
        $moto3->setName('Harley Davidson Softail');
        $moto3->setPrice(18999.99);
        $moto3->setPlatforms('Route');
        $moto3->setDescription('Moto de cruiser avec un style emblématique.');
        $moto3->setReleaseDate(new \DateTime('2022-02-01'));
        //$moto3->setPhotoPath('moto3.jpg');
        $entityManager->persist($moto3);
        
        $moto4 = new Product;
        $moto4->setName('Kawasaki Ninja H2');
        $moto4->setPrice(29999.99);
        $moto4->setPlatforms('Route');
        $moto4->setDescription('Moto sportive avec un design aérodynamique.');
        $moto4->setReleaseDate(new \DateTime('2022-04-01'));
        //$moto4->setPhotoPath('moto4.jpg');
        $entityManager->persist($moto4);
        
        $moto5 = new Product;
        $moto5->setName('Ducati Panigale V4');
        $moto5->setPrice(25995.99);
        $moto5->setPlatforms('Route');
        $moto5->setDescription('Moto sportive avec un design italien élégant.');
        $moto5->setReleaseDate(new \DateTime('2022-03-01'));
        //$moto5->setPhotoPath('moto5.jpg');
        $entityManager->persist($moto5);
        
        $moto6 = new Product;
        $moto6->setName('Triumph Tiger 900');
        $moto6->setPrice(12000.99);
        $moto6->setPlatforms('Route, hors route');
        $moto6->setDescription('Moto adventure-touring avec une grande polyvalence.');
        $moto6->setReleaseDate(new \DateTime('2022-06-01'));
        //$moto6->setPhotoPath('moto6.jpg');
        $entityManager->persist($moto6);
        
        $moto7 = new Product;
        $moto7->setName('Suzuki GSX-R1000R');
        $moto7->setPrice(18199.99);
        $moto7->setPlatforms('Route');
        $moto7->setDescription('Moto sportive avec une grande puissance et maniabilité.');
        $moto7->setReleaseDate(new \DateTime('2022-07-01'));
        //$moto7->setPhotoPath('moto7.jpg');
        $entityManager->persist($moto7);
        
        $moto8 = new Product;
        $moto8->setName('Yamaha YZF-R1M');
        $moto8->setPrice(26499.99);
        $moto8->setPlatforms('Route');
        $moto8->setDescription('Une sportive de haute performance avec un design épuré et agressif.');
        $moto8->setReleaseDate(new \DateTime('2022-05-15'));
        //$moto8->setPhotoPath('moto8.jpg');
        $entityManager->persist($moto8);


        $moto9 = new Product;
        $moto9->setName('Kawasaki Ninja H2R');
        $moto9->setPrice(54999.99);
        $moto9->setPlatforms('Circuit');
        $moto9->setDescription('La moto la plus puissante du marché, destinée à la piste.');
        $moto9->setReleaseDate(new \DateTime('2022-06-01'));
        //$moto9->setPhotoPath('moto9.jpg');
        $entityManager->persist($moto9);

        $moto10 = new Product;
        $moto10->setName('BMW S 1000 RR');
        $moto10->setPrice(18495.99);
        $moto10->setPlatforms('Route');
        $moto10->setDescription('Une sportive allemande ultra-performante et confortable.');
        $moto10->setReleaseDate(new \DateTime('2022-09-01'));
        //$moto10->setPhotoPath('moto10.jpg');
        $entityManager->persist($moto10);




        $entityManager->flush();
        return Command::SUCCESS;
    }
}

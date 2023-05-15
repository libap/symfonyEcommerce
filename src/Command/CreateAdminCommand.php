<?php

namespace App\Command;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface; //Rajout de la définition

use App\Entity\User;

#[AsCommand(
    name: 'create-admin',
    description: 'Add a short description for your command',
)]
class CreateAdminCommand extends Command
{

    private UserPasswordHasherInterface $passwordHasher; // New property
    private ManagerRegistry $doctrine;

    protected function configure(): void
    {
        $this->addArgument('login', InputArgument::REQUIRED, 'Use of params');
        $this->addArgument('password', InputArgument::REQUIRED, 'Use of params');
        
    }

    public function __construct(UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine) // Mdofiy to autowire
    {
        $this->passwordHasher = $passwordHasher; // Link property to wiring class
        $this->doctrine = $doctrine;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /*$io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;*/

        $output->writeln([
            'Creating admin',
            '==============',
            '',
        ]);

        $login = $input->getArgument('login');
        $admin = new User();
        $admin->setLogin($login);
        $admin->setRoles(['ROLE_ADMIN']);

        $plainTextPassword = $input->getArgument('password'); //Get password
        $hashedPassword = $this->passwordHasher->hashPassword( // Crytpting password
            $admin,
            $plainTextPassword
        );
        $admin->setPassword($hashedPassword);

        //Get doctrine entity manager
        $entityManager = $this->doctrine->getManager();

        //Tell doctrine to maker entity as persistent
        $entityManager->persist($admin);

        //Tell doctrine to flush
        //Write all persistent entity into database
        $entityManager->flush();


        return Command::SUCCESS;

    }
    
}

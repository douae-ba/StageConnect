<?php

namespace App\Command;

use App\Entity\User;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
//pour l'utiliser taper dans terminal : php bin/console app:encode-password monmotdepasse

#[AsCommand(
    name: 'app:encode-password',
    description: 'Encode a password for a User entity',
)]
class EncodePasswordCommand extends Command
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('password', InputArgument::REQUIRED, 'Plain password to encode');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = new User();
        $plainPassword = $input->getArgument('password');
        $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);

        $output->writeln("Mot de passe encodé :");
        $output->writeln($hashedPassword);

        return Command::SUCCESS;
    }
}

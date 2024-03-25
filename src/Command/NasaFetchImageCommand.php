<?php

namespace App\Command;

use App\Repository\ImageRepository;
use App\Services\NasaImageHandler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;

#[AsCommand(
    name: 'nasa:fetch-image',
    description: "Fetch today's image.",
    aliases: ['nasa:fetch-image'],
    hidden: false
)]
class NasaFetchImageCommand extends Command
{

    public function __construct(
        private readonly NasaImageHandler $nasaImageHandler,
        private readonly ImageRepository $imageRepository
    )
    {
        parent::__construct();
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $today = new \DateTime();

        if (empty($this->imageRepository->findByDate($today))) {
            $this->nasaImageHandler->nasaData($this->nasaImageHandler->fetchData());
            $output->writeln('Today\'s image has been saved');
            return Command::SUCCESS;
        }

        $output->writeln('Nothing to fetch :)');
        return Command::SUCCESS;
    }

}
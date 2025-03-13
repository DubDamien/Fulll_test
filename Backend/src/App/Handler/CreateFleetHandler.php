<?php

namespace Fulll\App\Handler;

use Fulll\App\Command\CreateFleetCommand;
use Fulll\Infra\Repository\FleetRepository;
use Symfony\Component\Console\Output\OutputInterface;

class CreateFleetHandler {
    private FleetRepository $fleetRepository;
    private OutputInterface $output;

    public function __construct(FleetRepository $fleetRepository, OutputInterface $output)
    {
        $this->fleetRepository = $fleetRepository;
        $this->output = $output;
    }

    public function handle(CreateFleetCommand $command): void 
    {
        $fleet = $this->fleetRepository->create($command->getUserId());

        $this->output->writeln(sprintf('<info>Fleet created with ID: %s</info>', $fleet->getId()));
    }
}
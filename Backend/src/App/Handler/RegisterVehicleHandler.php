<?php

namespace Fulll\App\Handler;

use Fulll\App\Command\RegisterVehicleCommand;
use Fulll\Infra\Repository\FleetRepository;
use Fulll\Infra\Repository\VehicleRepository;
use Symfony\Component\Console\Output\OutputInterface;

class RegisterVehicleHandler {
    private FleetRepository $fleetRepository;
    private VehicleRepository $vehicleRepository;
    private OutputInterface $output;

    public function __construct(FleetRepository $fleetRepository, VehicleRepository $vehicleRepository, OutputInterface $output)
    {
        $this->fleetRepository = $fleetRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->output = $output;
    }

    public function handle(RegisterVehicleCommand $command): void 
    {
        $fleet = $this->fleetRepository->findById($command->getFleetId());
        if (!$fleet) {
            $this->output->writeln(sprintf('<comment>Fleet with ID %s not found.</comment>', $command->getFleetId()));
            return;
        }

        if(!$this->vehicleRepository->findByPlateNumber($command->getPlateNumber())) {
            $vehicle = $this->vehicleRepository->create($command->getPlateNumber());
        } else {
            $vehicle = $this->vehicleRepository->findByPlateNumber($command->getPlateNumber());
            $this->output->writeln(sprintf('<error>Vehicle with plate number %s already exist</error>', $vehicle->getPlateNumber()));
            return;
        }

        $this->fleetRepository->addVehicle($vehicle, $fleet);

        $this->output->writeln(sprintf('<info>Vehicle with plate number %s registered to fleet %s</info>', 
            $command->getPlateNumber(), 
            $command->getFleetId()
        ));
    }
}
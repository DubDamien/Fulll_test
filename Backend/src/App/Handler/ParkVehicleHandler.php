<?php

namespace Fulll\App\Handler;

use Fulll\App\Command\ParkVehicleCommand;
use Fulll\Infra\Repository\LocationRepository;
use Fulll\Infra\Repository\VehicleRepository;
use Symfony\Component\Console\Output\OutputInterface;

class ParkVehicleHandler {
    private LocationRepository $locationRepository;
    private VehicleRepository $vehicleRepository;
    private OutputInterface $output;

    public function __construct(LocationRepository $locationRepository,VehicleRepository $vehicleRepository, OutputInterface $output)
    {
        $this->locationRepository = $locationRepository;
        $this->vehicleRepository = $vehicleRepository;
        $this->output = $output;
    }

    public function handle(ParkVehicleCommand $command): void
    {
        $vehicle = $this->vehicleRepository->findByPlateNumber($command->getPlateNumber());
        $commandLocation = $command->getLocation();

        if ($vehicle->getLocation() && $vehicle->getLocation()->sameThanPreviousLocation($commandLocation)) {
            $this->output->writeln(sprintf(
                '<error>Vehicle with plate number %s is already parked at this location: Lat %s, Lng %s, Alt %s</error>',
                $command->getPlateNumber(),
                $commandLocation->getLat(),
                $commandLocation->getLng(),
                $commandLocation->getAlt() ?? 'N/A'
            ));
            return;
        }

        $location = $this->locationRepository->create($commandLocation->getLat(), $commandLocation->getLng(), $commandLocation->Getalt());

        $this->vehicleRepository->updateLocation($vehicle->getId(), $location->getId());

        $this->output->writeln(sprintf(
            '<info>Vehicle with plate number %s parked at location: Lat %s, Lng %s, Alt %s</info>',
            $command->getPlateNumber(),
            $location->getLat(),
            $location->getLng(),
            $location->getAlt() ?? 'N/A'
            ));    
    }
}
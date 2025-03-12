<?php

namespace Fulll\App\Handler;

use Fulll\App\Command\ParkVehicleCommand;
use Fulll\Infra\Repository\FleetRepository;

class ParkVehicleHandler {
    private FleetRepository $fleetRepository;

    public function __construct(FleetRepository $fleetRepository) 
    {
        $this->fleetRepository = $fleetRepository;
    }

    public function handle(ParkVehicleCommand $command): void
    {
        $fleet = $this->fleetRepository->findById($command->getFleetId());
        $vehicle = $fleet->getVehicleByPlateNumber($command->getPlateNumber());

        $vehicle->parkVehicle($command->getLocation());
        $this->fleetRepository->save($fleet);
    }
}
<?php

namespace Fulll\App\Handler;

use Fulll\App\Command\RegisterVehicleCommand;
use Fulll\Domain\Entity\Vehicle;
use Fulll\Infra\Repository\FleetRepository;

class RegisterVehicleHandler {
    private FleetRepository $fleetRepository;

    public function __construct(FleetRepository $fleetRepository)
    {
        $this->fleetRepository = $fleetRepository;
    }

    public function handle(RegisterVehicleCommand $command): void 
    {
        $fleet = $this->fleetRepository->findById($command->getFleetId());
        $vehicle = new Vehicle($command->getPlateNumber());

        $fleet->registerVehicle($vehicle);
        $this->fleetRepository->save($fleet);
    }
}
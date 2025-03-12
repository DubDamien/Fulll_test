<?php

namespace Fulll\App\Command;

class RegisterVehicleCommand {
    private $fleetId;
    private $plateNumber;

    public function __construct(string $fleetId, string $plateNumber) 
    {
        $this->fleetId = $fleetId;
        $this->plateNumber = $plateNumber;
    }

    public function getFleetId(): string 
    {
        return $this->fleetId;
    }

    public function getPlateNumber(): string 
    {
        return $this->plateNumber;
    }
}
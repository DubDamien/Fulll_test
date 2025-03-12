<?php

namespace Fulll\App\Command;

use Fulll\Domain\Entity\Location;

class ParkVehicleCommand {
    private $fleetId;
    private $plateNumber;
    private Location $location;

    public function __construct(string $fleetId, string $plateNumber, float $lat, float $long, ?float $alt) 
    {
        $this->fleetId = $fleetId;
        $this->plateNumber = $plateNumber;
        $this->location = new Location($lat, $long, $alt);
    }

    public function getFleetId(): string
    {
        return $this->fleetId;
    }

    public function getPlateNumber(): string
    {
        return $this->plateNumber;
    }

    public function getLocation(): Location
    {
        return $this->location;
    }
}
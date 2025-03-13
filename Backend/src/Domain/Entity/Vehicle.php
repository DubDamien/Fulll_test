<?php

namespace Fulll\Domain\Entity;

Class Vehicle {
    private $id;
    private $plateNumber;
    private ?Location $location = null;

    public function __construct(string $plateNumber, ?string $id = null) 
    {
        $this->id = $id ?? uniqid();
        $this->plateNumber = $plateNumber;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getPlateNumber(): string 
    {
        return $this->plateNumber;
    }

    public function getLocation(): Location 
    {
        return $this->location;
    }

    public function setLocation(Location $location): void
    {
        $this->location = $location;
    }

    public function parkVehicle(Location $location): void
    {
        if ($this->location && $this->location->sameThanPreviousLocation($location)) {
            throw new \Exception("Vehicle is already parked at this location.");
        }

        $this->location = $location;
    }
}
<?php

namespace Fulll\Domain\Entity;

Class Fleet {
    private $id;
    private $userId;
    private $vehicles = [];

    public function __construct(string $userId, ?string $id = null) {
        $this->id = $id ?? uniqid();
        $this->userId = $userId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function isVehicleRegistered(Vehicle $vehicle): bool
    {
        return in_array($vehicle, $this->vehicles, true);
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function registerVehicle(Vehicle $vehicle) {
        foreach ($this->vehicles as $existingVehicle) {
            if ($existingVehicle->getPlateNumber() === $vehicle->getPlateNumber()) {
                throw new \Exception('Vehicle already exist in the fleet');
            }
        }
    
        $this->vehicles[] = $vehicle;
    }

}
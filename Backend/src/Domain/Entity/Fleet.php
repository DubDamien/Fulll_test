<?php

namespace Fulll\Domain\Entity;

Class Fleet {
    private $id;
    private $userId;
    private $vehicles = [];

    public function __construct(string $userId) {
        $this->id = uniqid();
        $this->userId = $userId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function registerVehicle(Vehicle $vehicle): void 
    {
        if ($this->isVehicleRegistered($vehicle)) {
            throw new \Exception("Vehicle already exist in the fleet");
        }
        $this->vehicles[] = $vehicle;
    }

    public function isVehicleRegistered(Vehicle $vehicle): bool
    {
        return in_array($vehicle, $this->vehicles, true);
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getVehicleByPlateNumber(string $plateNumber): Vehicle
    {
        foreach ($this->vehicles as $vehicle) {
            if ($vehicle->getPlateNumber() === $plateNumber) {
                return $vehicle;
            }
        }

        throw new \Exception("Vehicle with plate number $plateNumber not found in this fleet.");
    }
}
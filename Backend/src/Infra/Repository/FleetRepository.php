<?php

namespace Fulll\Infra\Repository;

use Fulll\Domain\Entity\Fleet;
use Fulll\Domain\Entity\Vehicle;
use Fulll\Infra\Database\DatabaseConnection;
use PDO;

class FleetRepository
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = DatabaseConnection::getInstance(true);
    }

    public function findById(string $fleetId): ?Fleet
    {
        $stmt = $this->connection->prepare("SELECT * FROM fleets WHERE id = :id");
        $stmt->execute(['id' => $fleetId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        $fleet = new Fleet($data['user_id']);
        $fleet->setId($data['id']);
        return $fleet;
    }

    public function create(string $userId): Fleet
    {
        $fleet = new Fleet($userId);
        $stmt = $this->connection->prepare("INSERT INTO fleets (id, user_id) VALUES (:id, :user_id)");
        $stmt->execute([
            'id' => $fleet->getId(),
            'user_id' => $fleet->getUserId()
        ]);

        return $fleet;
    }

    public function save(Fleet $fleet): void
    {
        $stmt = $this->connection->prepare("UPDATE fleets SET user_id = :user_id WHERE id = :id");
        $stmt->execute([
            'user_id' => $fleet->getUserId()
        ]);
    }

    public function addVehicle(Vehicle $vehicle, Fleet $fleet): void
    {
        $stmt = $this->connection->prepare("INSERT INTO fleets_vehicles (vehicle_id, fleet_id) VALUES (:vehicle_id, :fleet_id)");
        $stmt->execute([
        'vehicle_id' => $vehicle->getId(),
        'fleet_id' => $fleet->getId()
        ]);
    }
}
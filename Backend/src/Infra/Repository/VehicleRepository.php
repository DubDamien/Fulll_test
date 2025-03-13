<?php

namespace Fulll\Infra\Repository;

use Fulll\Domain\Entity\Vehicle;
use Fulll\Domain\Entity\Location;
use Fulll\Infra\Database\DatabaseConnection;
use PDO;

class VehicleRepository
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = DatabaseConnection::getInstance(true);
    }

    public function findById(string $vehicleId): ?Vehicle
    {
        $stmt = $this->connection->prepare("
            SELECT v.id, v.plate_number, v.location_id, l.lat, l.lng, l.alt 
            FROM vehicles v
            LEFT JOIN locations l ON v.location_id = l.id
            WHERE v.id = :id
        ");
        $stmt->execute(['id' => $vehicleId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$data) {
            return null;
        }
    
        $vehicle = new Vehicle($data['plate_number']);
        $vehicle->setId($data['id']);
    
        if (isset($data['lat'], $data['lng'])) {
            $location = new Location(
                (float) $data['lat'],
                (float) $data['lng'],
                isset($data['alt']) ? (float) $data['alt'] : null,
                $data['location_id'] ?? null
            );
            $vehicle->setLocation($location);
        }
    
        return $vehicle;
    }

    public function findByPlateNumber(string $plateNumber): ?Vehicle
    {
        $stmt = $this->connection->prepare("
            SELECT v.id, v.plate_number, v.location_id, l.lat, l.lng, l.alt 
            FROM vehicles v
            LEFT JOIN locations l ON v.location_id = l.id
            WHERE v.plate_number = :plate_number
        ");
        $stmt->execute(['plate_number' => $plateNumber]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        $vehicle = new Vehicle($data['plate_number']);
        $vehicle->setId($data['id']);

        if (isset($data['lat'], $data['lng'])) {
            $location = new Location(
                (float) $data['lat'],
                (float) $data['lng'],
                isset($data['alt']) ? (float) $data['alt'] : null,
                $data['location_id'] ?? null,
            );
            $vehicle->setLocation($location);
        }

        return $vehicle;
    }

    public function create(string $plate_number): Vehicle
    {
        $vehicle = new Vehicle($plate_number);
        $stmt = $this->connection->prepare("INSERT INTO vehicles (id, plate_number) VALUES (:id, :plate_number)");
        $stmt->execute([
            'id' => $vehicle->getId(),
            'plate_number' => $vehicle->getPlateNumber()
        ]);

        return $vehicle;
    }

    public function save(Vehicle $vehicle): void
    {
        $stmt = $this->connection->prepare("UPDATE vehicles SET (id, plate_number) WHERE id = :id");
        $stmt->execute([
            'plate_number' => $vehicle->getPlateNumber(),
            'location_id' => $vehicle->getLocation()
        ]);
    }

    public function updateLocation(string $vehicleId, string $locationId): void
    {
        $stmt = $this->connection->prepare("
            UPDATE vehicles 
            SET location_id = :location_id
            WHERE id = :id
        ");
        $stmt->execute([
            'location_id' => $locationId,
            'id' => $vehicleId
        ]);
    }
}
<?php

namespace Fulll\Infra\Repository;

use Fulll\Domain\Entity\Location;
use Fulll\Domain\Entity\Vehicle;
use Fulll\Infra\Database\DatabaseConnection;
use PDO;

class LocationRepository
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = DatabaseConnection::getInstance(true);
    }

    public function findById(string $locationId): ?Location
    {
        $stmt = $this->connection->prepare("SELECT * FROM locations WHERE id = :id");
        $stmt->execute(['id' => $locationId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        $location = new Location($data['lat'], $data['lng'], $data['alt']);
        $location->setId($data['id']);
        return $location;
    }

    public function create(float $lat, float $lng, ?float $alt): Location
    {
        $location = new Location($lat, $lng, $alt);
        $stmt = $this->connection->prepare("INSERT INTO locations (id, lat, lng, alt) VALUES (:id, :lat, :lng, :alt)");
        $stmt->execute([
            'id' => $location->getId(),
            'lat' => $location->getlat(),
            'lng' => $location->getLng(),
            'alt' => $location->getAlt()
        ]);

        return $location;
    }

    public function save(Location $location): void
    {
        $stmt = $this->connection->prepare("UPDATE locations SET (id, lat, lng, alt) WHERE (:lat, :lng, :alt)");
        $stmt->execute([
            'lat' => $location->getlat(),
            'lng' => $location->getLng(),
            'alt' => $location->getAlt()
        ]);
    }
}
<?php

namespace Fulll\Infra\Repository;

use Fulll\Domain\Entity\Fleet;

class FleetRepository
{
    private array $fleets = [];

    public function findById(string $fleetId): ?Fleet
    {
        return $this->fleets[$fleetId] ?? null;
    }

    public function save(Fleet $fleet): void
    {
        $this->fleets[$fleet->getUserId()] = $fleet;
    }
}
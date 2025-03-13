<?php

namespace Fulll\Domain\Entity;

Class Location {
    private $id;
    private $lat;
    private $lng;
    private $alt;

    public function __construct(float $lat, float $lng, ?float $alt = null, ?string $id = null) {
        $this->id = $id ?? uniqid();
        $this->lat = $lat;
        $this->lng = $lng;
        $this->alt = $alt;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getlat(): float
    {
        return $this->lat;
    }

    public function getLng(): float
    {
        return $this->lng;
    }

    public function getAlt(): ?float
    {
        return $this->alt;
    }

    public function sameThanPreviousLocation(Location $previousLocation)
    {
        return $this->lat === $previousLocation->lat &&
        $this->lng === $previousLocation->lng &&
        $this->alt === $previousLocation->alt;
    }
}
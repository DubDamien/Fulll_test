<?php

namespace Fulll\Domain\Entity;

Class Location {
    private $id;
    private $lat;
    private $long;
    private $alt;

    public function __construct(float $lat, float $long, ?float $alt = null) {
        $this->id = uniqid();
        $this->lat = $lat;
        $this->long = $long;
        $this->alt = $alt;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getlat(): float
    {
        return $this->lat;
    }

    public function getLong(): float
    {
        return $this->long;
    }

    public function getAlt(): float
    {
        return $this->alt;
    }

    public function sameThanPreviousLocation(Location $previousLocation)
    {
        return $this->lat === $previousLocation->lat &&
        $this->long === $previousLocation->long &&
        $this->alt === $previousLocation->alt;
    }
}
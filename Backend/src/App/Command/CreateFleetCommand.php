<?php

namespace Fulll\App\Command;

class CreateFleetCommand {
    private $userId;

    public function __construct(string $userId) 
    {
        $this->userId = $userId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
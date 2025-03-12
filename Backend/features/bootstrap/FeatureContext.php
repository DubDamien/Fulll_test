<?php

use Fulll\Domain\Entity\Fleet;
use Fulll\Domain\Entity\Location;
use Fulll\Domain\Entity\Vehicle;
use Behat\Behat\Context\Context;
use Behat\Step\Given;
use Behat\Step\When;
use Behat\Step\Then;

class FeatureContext implements Context
{
    private Fleet $myFleet;
    private Fleet $anotherFleet;
    private Vehicle $vehicle;
    private Location $location;
    private ?\Exception $exception = null;

    #[Given('my fleet')]
    public function myFleet()
    {
        $this->myFleet = new Fleet('user1');
    }

    #[Given('a vehicle')]
    public function aVehicle()
    {
        $this->vehicle = new Vehicle('ABC123');
    }

    #[When('I register this vehicle into my fleet')]
    public function iRegisterThisVehicleIntoMyFleet()
    {
        $this->myFleet->registerVehicle($this->vehicle);
    }

    #[Then('this vehicle should be part of my vehicle fleet')]
    public function thisVehicleShouldBePartOfMyVehicleFleet()
    {
        return $this->myFleet->isVehicleRegistered($this->vehicle);
    }

    #[Given('I have registered this vehicle into my fleet')]
    public function iHaveRegisteredThisVehicleIntoMyFleet()
    {
        $this->myFleet->registerVehicle($this->vehicle);
    }

    #[When('I try to register this vehicle into my fleet')]
    public function iTryToRegisterThisVehicleIntoMyFleet()
    {
        try {
            $this->myFleet->registerVehicle($this->vehicle);
        } catch (\Exception $e) {
            $this->exception = $e;
        }
    }

    #[Then('I should be informed this this vehicle has already been registered into my fleet')]
    public function iShouldBeInformedThatThisVehicleHasAlreadyBeenRegisteredIntoMyFleet()
    {
        if ($this->exception === null) {
            throw new \Exception('Expected an exception to be thrown, but none was thrown.');
        }
    
        if ($this->exception->getMessage() !== 'Vehicle already exist in the fleet') {
            throw new \Exception('Expected exception message: "Vehicle already exist in the fleet", but got: "' . $this->exception->getMessage() . '"');
        }
    }

    #[Given('the fleet of another user')]
    public function theFleetOfAnotherUser()
    {
        $this->anotherFleet = new Fleet('user2');
    }

    #[Given('this vehicle has been registered into the other user\'s fleet')]
    public function thisVehicleHasBeenRegisteredIntoTheOtherUsersFleet()
    {
        $this->anotherFleet->registerVehicle($this->vehicle);
    }

    #[Given('a location')]
    public function aLocation(): void
    {
        $this->location = new Location(-56.23410, 130.86201, 3.24);
    }

    #[When('I park my vehicle at this location')]
    public function iParkMyVehicleAtThisLocation(): void
    {
        $this->vehicle->parkVehicle($this->location);
    }

    #[Then('the known location of my vehicle should verify this location')]
    public function theKnownLocationOfMyVehicleShouldVerifyThisLocation(): void
    {
        $this->vehicle->getLocation() === $this->location;
    }

    #[Given('my vehicle has been parked into this location')]
    public function myVehicleHasBeenParkedIntoThisLocation(): void
    {
        $this->vehicle->parkVehicle($this->location);
    }

    #[When('I try to park my vehicle at this location')]
    public function iTryToParkMyVehicleAtThisLocation(): void
    {
        try {
            $this->vehicle->parkVehicle($this->location);
        } catch (\Exception $e) {
            $this->exception = $e;
        }
    }

    #[Then('I should be informed that my vehicle is already parked at this location')]
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation(): void
    {
        if ($this->exception === null) {
            throw new \Exception('Expected an exception to be thrown, but none was thrown.');
        }
    
        if ($this->exception->getMessage() !== 'Vehicle is already parked at this location.') {
            throw new \Exception('Expected exception message: "Vehicle is already parked at this location.", but got: "' . $this->exception->getMessage() . '"');
        }
    }
}
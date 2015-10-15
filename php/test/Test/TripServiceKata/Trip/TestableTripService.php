<?php

namespace Test\TripServiceKata\Trip;

use TripServiceKata\Trip\Trip;
use TripServiceKata\Trip\TripService;
use TripServiceKata\User\User;

class TestableTripService extends TripService
{
    private $loggedUser;

    /**
     * TestableTripService constructor.
     */
    public function __construct()
    {
        $this->loggedUser = new User('Luis');
    }

    public function getLoggedUser()
    {
        return $this->loggedUser;
    }

    public function tripListOf(User $user)
    {
        return [new Trip()];
    }

}
<?php

namespace Test\TripServiceKata\Trip;

use TripServiceKata\Trip\TripService;
use TripServiceKata\User\User;

class TestableTripService extends TripService
{
    private $loggedUser;

    /**
     * TestableTripService constructor.
     * @param $loggedUser
     */
    public function __construct($loggedUser)
    {
        $this->loggedUser = $loggedUser;
    }

    protected function loggedUser()
    {
        return $this->loggedUser;
    }

    protected function tripsOf(User $user)
    {
        return $user->getTrips();
    }

}
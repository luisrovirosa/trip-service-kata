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
     * @param $loggedUser
     */
    public function __construct($loggedUser)
    {
        $this->loggedUser = $loggedUser;
    }

    protected function getLoggedUser()
    {
        return $this->loggedUser;
    }

    protected function tripListOf(User $user)
    {
        return [new Trip()];
    }

}
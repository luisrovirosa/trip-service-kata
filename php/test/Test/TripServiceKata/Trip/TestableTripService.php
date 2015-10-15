<?php

namespace Test\TripServiceKata\Trip;

use TripServiceKata\Trip\TripService;

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
        $this->loggedUser;
    }

}
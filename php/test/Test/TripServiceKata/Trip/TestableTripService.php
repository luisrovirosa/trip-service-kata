<?php

namespace Test\TripServiceKata\Trip;

use TripServiceKata\Trip\TripService;
use TripServiceKata\User\User;

class TestableTripService extends TripService
{
    protected function getLoggedUser()
    {
        return new User('Luis');
    }

}
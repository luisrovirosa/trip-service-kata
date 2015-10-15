<?php

namespace Test\TripServiceKata\Trip;

use TripServiceKata\Trip\TripService;
use TripServiceKata\User\User;

class TestableTripService extends TripService
{
    protected function tripsOf(User $user)
    {
        return $user->getTrips();
    }

}
<?php

namespace Test\TripServiceKata\Trip;

use TripServiceKata\Trip\TripService;

class TestableTripService extends TripService
{
    protected function getLoggedUser()
    {
        return null;
    }

}
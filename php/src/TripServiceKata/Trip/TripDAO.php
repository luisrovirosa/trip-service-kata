<?php

namespace TripServiceKata\Trip;

use TripServiceKata\User\User;
use TripServiceKata\Exception\DependentClassCalledDuringUnitTestException;

class TripDAO
{
    /**
     * @param User $user
     * @return Trip[]
     */
    public function findTripsOf(User $user)
    {
        return static::findTripsByUser($user);
    }

    /**
     * @param User $user
     * @return Trip[]
     */
    public static function findTripsByUser(User $user)
    {
        throw new DependentClassCalledDuringUnitTestException(
            'TripDAO should not be invoked on an unit test.'
        );
    }
}

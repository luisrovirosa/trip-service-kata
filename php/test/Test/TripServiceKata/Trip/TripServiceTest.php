<?php

namespace Test\TripServiceKata\Trip;

use PHPUnit_Framework_TestCase;
use TripServiceKata\User\User;

class TripServiceTest extends PHPUnit_Framework_TestCase
{
    const UNUSED_USER = null;
    const GUEST_USER = null;

    /** @test */
    public function should_throw_an_exception_when_the_user_is_not_logged()
    {
        $this->setExpectedException('TripServiceKata\Exception\UserNotLoggedInException');
        $tripService = new TestableTripService(self::GUEST_USER);
        $luis = new User('Luis');
        $tripService->getTripsByUser($luis);
    }

    /** @test */
    public function should_retrieve_an_empty_list_when_users_are_not_friends()
    {
        $luis = new User('Luis');
        $loggedUser = new User('Concha');
        $tripService = new TestableTripService($loggedUser);

        $trips = $tripService->getTripsByUser($luis);

        $this->assertEquals([], $trips);
    }
}

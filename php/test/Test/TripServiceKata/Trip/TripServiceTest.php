<?php

namespace Test\TripServiceKata\Trip;

use PHPUnit_Framework_TestCase;
use TripServiceKata\Trip\Trip;
use TripServiceKata\User\User;

class TripServiceTest extends PHPUnit_Framework_TestCase
{
    const UNUSED_USER = null;
    const GUEST_USER = null;
    private $nonFriend;
    private $friend;

    /** @var  User */
    private $loggedUser;

    protected function setUp()
    {
        parent::setUp();
        $this->loggedUser = new User('Luis');
        $this->nonFriend = new User('Luis');
        $this->nonFriend->addTrip(new Trip('Secret trip'));
        $this->friend = new User('Luis');
        $this->friend->addFriend($this->loggedUser());
        $this->friend->addTrip(new Trip('Barcelona'));
    }

    /** @test */
    public function should_throw_an_exception_when_the_user_is_not_logged()
    {
        $this->setExpectedException('TripServiceKata\Exception\UserNotLoggedInException');
        $tripService = new TestableTripService(self::GUEST_USER);
        $tripService->getTripsByUser($this->anyUser());
    }

    /** @test */
    public function should_retrieve_an_empty_list_when_users_are_not_friends()
    {
        $this->assertEquals([], $this->trips($this->nonFriend()));
    }

    /** @test */
    public function should_retrieve_the_lists_of_trips_of_a_friend()
    {
        $friend = $this->friend();
        $this->assertEquals($friend->getTrips(), $this->trips($friend));
    }

    // Helpers

    /**
     * @return User
     */
    private function anyUser()
    {
        return new User('John Doe');
    }

    /**
     * @return User
     */
    private function loggedUser()
    {
        return $this->loggedUser;
    }

    /**
     * @return User
     */
    private function nonFriend()
    {
        return $this->nonFriend;
    }

    /**
     * @return User
     */
    private function friend()
    {
        return $this->friend;
    }

    /**
     * @param $user
     * @return array|\TripServiceKata\Trip\Trip[]
     * @throws \TripServiceKata\Exception\UserNotLoggedInException
     */
    private function trips($user)
    {
        $tripService = new TestableTripService($this->loggedUser());

        $trips = $tripService->getTripsByUser($user);

        return $trips;
    }
}

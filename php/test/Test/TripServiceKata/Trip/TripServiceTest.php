<?php

namespace Test\TripServiceKata\Trip;

use Prophecy\PhpUnit\ProphecyTestCase;
use TripServiceKata\Trip\TripService;
use TripServiceKata\User\User;

class TripServiceTest extends ProphecyTestCase
{
    /**
     * @var TripService
     */
    private $tripService;

    protected function setUp()
    {
        $this->tripService = new TestableTripService();
    }

    /** @test */
    public function it_returns_the_trips_of_a_friend()
    {
        $userProphecy = $this->prophesize('TripServiceKata\User\User');
        $userProphecy->getFriends()->willReturn([]);
        /** @var User $user */
        $user = $userProphecy->reveal();

        $this->tripService->getTripsByUser($user);
    }
}

<?php

namespace Test\TripServiceKata\Trip;

use Prophecy\PhpUnit\ProphecyTestCase;
use TripServiceKata\Trip\TripService;
use TripServiceKata\User\User;

class TripServiceTest extends ProphecyTestCase
{
    /**
     * @var TestableTripService
     */
    private $tripService;

    protected function setUp()
    {
        $this->tripService = new TestableTripService();
    }

    /** @test */
    public function it_returns_an_empty_list_when_is_not_a_friend()
    {
        $userProphecy = $this->prophesize('TripServiceKata\User\User');
        $userProphecy->getFriends()->willReturn([]);
        /** @var User $user */
        $user = $userProphecy->reveal();

        $trips = $this->tripService->getTripsByUser($user);
        $this->assertEquals([], $trips);
    }

    /** @test */
    public function it_returns_the_trips_of_a_friend()
    {
        $userProphecy = $this->prophesize('TripServiceKata\User\User');
        $userProphecy->getFriends()->willReturn([$this->tripService->getLoggedUser()]);
        /** @var User $user */
        $user = $userProphecy->reveal();

        $trips = $this->tripService->getTripsByUser($user);
        $this->assertGreaterThan(0, count($trips));
    }
}

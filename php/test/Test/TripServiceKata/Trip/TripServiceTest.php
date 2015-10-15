<?php

namespace Test\TripServiceKata\Trip;

use Prophecy\PhpUnit\ProphecyTestCase;
use TripServiceKata\Trip\TripService;
use TripServiceKata\User\User;

class TripServiceTest extends ProphecyTestCase
{
    private $loggedUser;
    /**
     * @var TestableTripService
     */
    private $tripService;

    protected function setUp()
    {
        $this->loggedUser = new User('Luis');
        $this->tripService = new TestableTripService($this->loggedUser);
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
        $userProphecy->getFriends()->willReturn([$this->loggedUser]);
        /** @var User $user */
        $user = $userProphecy->reveal();

        $trips = $this->tripService->getTripsByUser($user);
        $this->assertGreaterThan(0, count($trips));
    }

    /** @test */
    public function it_throws_an_exception_when_the_user_is_lot_logged_in()
    {
        $this->setExpectedException('TripServiceKata\Exception\UserNotLoggedInException');
        $tripService = new TestableTripService(null);
        $userProphecy = $this->prophesize('TripServiceKata\User\User');
        /** @var User $user */
        $user = $userProphecy->reveal();

        $tripService->getTripsByUser($user);
    }
}

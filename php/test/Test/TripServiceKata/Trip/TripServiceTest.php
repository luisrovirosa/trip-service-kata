<?php

namespace Test\TripServiceKata\Trip;

use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use TripServiceKata\Trip\TripService;
use TripServiceKata\User\User;

class TripServiceTest extends ProphecyTestCase
{
    /** @var  User */
    private $loggedUser;

    /** @var  ObjectProphecy */
    private $userProphecy;
    /**
     * @var TestableTripService
     */
    private $tripService;

    protected function setUp()
    {
        $this->loggedUser = new User('Luis');
        $this->tripService = new TestableTripService($this->loggedUser);
        $this->userProphecy = $this->prophesize('TripServiceKata\User\User');
    }

    /** @test */
    public function it_returns_an_empty_list_when_is_not_a_friend()
    {
        $this->userProphecy->getFriends()->willReturn([]);

        $trips = $this->tripService->getTripsByUser($this->getUser());

        $this->assertEquals([], $trips);
    }

    /** @test */
    public function it_returns_the_trips_of_a_friend()
    {
        $this->userProphecy->getFriends()->willReturn([$this->loggedUser]);

        $trips = $this->tripService->getTripsByUser($this->getUser());
        $this->assertGreaterThan(0, count($trips));
    }

    /** @test */
    public function it_throws_an_exception_when_the_user_is_lot_logged_in()
    {
        $this->setExpectedException('TripServiceKata\Exception\UserNotLoggedInException');
        $tripService = new TestableTripService(null);

        $tripService->getTripsByUser($this->getUser());
    }

    /**
     * @return User
     */
    private function getUser()
    {
        return $this->userProphecy->reveal();
    }
}

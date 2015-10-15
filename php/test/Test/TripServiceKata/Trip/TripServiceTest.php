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
    public function  it_does_something()
    {
        /** @var User $user */
        $user = $this->prophesize('TripServiceKata\User\User')->reveal();

        $this->tripService->getTripsByUser($user);
    }
}

<?php

namespace Test\TripServiceKata\Trip;

use PHPUnit_Framework_TestCase;
use TripServiceKata\Trip\TripService;
use TripServiceKata\User\User;

class TripServiceTest extends PHPUnit_Framework_TestCase
{
    const UNUSED_USER = null;
    const GUEST_USER = null;
    /**
     * @var TripService
     */
    private $tripService;

    protected function setUp()
    {
        $this->tripService = new TestableTripService(self::GUEST_USER);
    }

    /** @test */
    public function should_throw_an_exception_when_the_user_is_not_logged()
    {
        $this->setExpectedException('TripServiceKata\Exception\UserNotLoggedInException');
        $luis = new User('Luis');
        $this->tripService->getTripsByUser($luis);
    }
}

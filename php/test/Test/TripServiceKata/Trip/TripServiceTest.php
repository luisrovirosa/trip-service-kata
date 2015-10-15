<?php

namespace Test\TripServiceKata\Trip;

use PHPUnit_Framework_TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use TripServiceKata\Trip\Trip;
use TripServiceKata\Trip\TripDAO;
use TripServiceKata\Trip\TripService;
use TripServiceKata\User\User;
use TripServiceKata\User\UserSession;

class TripServiceTest extends PHPUnit_Framework_TestCase
{
    const UNUSED_USER = null;

    const GUEST_USER = null;

    /** @var  User */
    private $nonFriend;

    /** @var  User */
    private $friend;

    /** @var  TripService */
    private $tripService;

    /** @var  User */
    private $loggedUser;

    protected function setUp()
    {
        parent::setUp();
        $this->loggedUser = new User('Luis');
        $this->nonFriend = $this->createNonFriend();
        $this->friend = $this->createFriend();
        $this->tripService = new TripService(
            $this->userSessionMock($this->loggedUser),
            $this->tripDaoMock()
        );
    }

    /** @test */
    public function should_throw_an_exception_when_the_user_is_not_logged()
    {
        $this->setExpectedException('TripServiceKata\Exception\UserNotLoggedInException');
        $tripService = new TripService(
            $this->userSessionMock(self::GUEST_USER),
            new TripDAO()
        );
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
        return $this->tripService->getTripsByUser($user);
    }

    /**
     * @return User
     */
    protected function createFriend()
    {
        $user = new User('Luis');
        $user->addFriend($this->loggedUser());
        $user->addTrip(new Trip('Barcelona'));

        return $user;
    }

    /**
     * @return User
     */
    protected function createNonFriend()
    {
        $user = new User('Luis');
        $user->addTrip(new Trip('Secret trip'));

        return $user;
    }

    /**
     * @param User $loggedUser
     * @return UserSession
     */
    protected function userSessionMock(User $loggedUser = null)
    {
        /** @var ObjectProphecy $userSessionProphecy */
        $userSessionProphecy = $this->prophesize('TripServiceKata\User\UserSession');
        $userSessionProphecy->getLoggedUser()->willReturn($loggedUser);
        $userSession = $userSessionProphecy->reveal();

        return $userSession;
    }

    private function tripDaoMock()
    {
        /** @var ObjectProphecy $userSessionProphecy */
        $tripDaoProphecy = $this->prophesize('TripServiceKata\Trip\TripDAO');

        $tripDaoProphecy->findTripsOf(Argument::type('TripServiceKata\User\User'))
            ->will(
                function ($args) {
                    /** @var User $user */
                    $user = $args[0];

                    return $user->getTrips();
                }
            );

        return $tripDaoProphecy->reveal();
    }
}

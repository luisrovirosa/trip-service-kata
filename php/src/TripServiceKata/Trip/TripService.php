<?php

namespace TripServiceKata\Trip;

use TripServiceKata\User\User;
use TripServiceKata\User\UserSession;
use TripServiceKata\Exception\UserNotLoggedInException;

class TripService
{
    /** @var  UserSession */
    private $userSession;

    /** @var TripDAO */
    private $tripDAO;

    /**
     * TripService constructor.
     * @param UserSession $userSession
     * @param TripDAO $tripDAO
     */
    public function __construct(UserSession $userSession, TripDAO $tripDAO)
    {
        $this->userSession = $userSession;
        $this->tripDAO = $tripDAO;
    }

    public function getTripsByUser(User $user)
    {
        $this->assertUserLogged();

        return $this->areFriends($user) ? $this->tripsOf($user) : [];
    }

    /**
     * Throws an exception when the user is not logged in
     * @throws UserNotLoggedInException
     */
    private function assertUserLogged()
    {
        if ($this->loggedUser() === null) {
            throw new UserNotLoggedInException();
        }
    }

    /**
     * @param User $user
     * @return bool
     */
    private function areFriends(User $user)
    {
        return $user->isFriendOf($this->loggedUser());
    }

    /**
     * @return User
     */
    protected function loggedUser()
    {
        return $this->userSession->getLoggedUser();
    }

    /**
     * @param User $user
     * @return Trip[]
     * @throws \TripServiceKata\Exception\DependentClassCalledDuringUnitTestException
     */
    protected function tripsOf(User $user)
    {
        return $this->tripDAO->findTripsOf($user);
    }

}

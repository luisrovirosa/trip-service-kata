<?php

namespace TripServiceKata\Trip;

use TripServiceKata\User\User;
use TripServiceKata\User\UserSession;
use TripServiceKata\Exception\UserNotLoggedInException;

class TripService
{
    public function getTripsByUser(User $user)
    {
        $this->assertUserLogged();
        $tripList = array();
        $isFriend = false;
        $loggedUser = $this->loggedUser();
        foreach ($user->getFriends() as $friend) {
            if ($friend == $loggedUser) {
                $isFriend = true;
                break;
            }
        }
        if ($isFriend) {
            $tripList = $this->tripsOf($user);
        }

        return $tripList;
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
     * @return User
     */
    protected function loggedUser()
    {
        return UserSession::getInstance()->getLoggedUser();
    }

    /**
     * @param User $user
     * @return Trip[]
     * @throws \TripServiceKata\Exception\DependentClassCalledDuringUnitTestException
     */
    protected function tripsOf(User $user)
    {
        return TripDAO::findTripsByUser($user);
    }

}

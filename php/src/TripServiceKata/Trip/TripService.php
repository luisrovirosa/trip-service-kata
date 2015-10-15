<?php

namespace TripServiceKata\Trip;

use TripServiceKata\User\User;
use TripServiceKata\User\UserSession;
use TripServiceKata\Exception\UserNotLoggedInException;

class TripService
{
    public function getTripsByUser(User $user)
    {
        $tripList = array();
        $loggedUser = $this->loggedUser();
        $isFriend = false;
        if ($loggedUser != null) {
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
        } else {
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

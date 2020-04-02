<?php

namespace App\Security;

use App\Model\DTO\Network\NetworkRequest;
use App\Model\DTO\Network\NetworkResponse;
use App\NetworkHelper\DataStore\DataStoreHelper;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface, PasswordUpgraderInterface
{
    /**
     * Symfony calls this method if you use features like switch_user
     * or remember_me.
     *
     * If you're not using these features, you do not need to implement
     * this method.
     *
     * @param string $username
     * @return UserInterface
     */
    public function loadUserByUsername(string $username)
    {
        return $this->getUser($username);
    }

    /**
     * Refreshes the user after being reloaded from the session.
     *
     * When a user is logged in, at the beginning of each request, the
     * User object is loaded from the session and then this method is
     * called. Your job is to make sure the user's data is still fresh by,
     * for example, re-querying for fresh User data.
     *
     * If your firewall is "stateless: true" (for a pure API), this
     * method is not called.
     *
     * @param UserInterface $user
     * @return UserInterface
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', get_class($user)));
        }

        return $this->getUser($user->getUsername());
    }

    /**
     * Tells Symfony to use this provider for this User class.
     * @param $class
     * @return bool
     */
    public function supportsClass($class): bool
    {
        return User::class === $class;
    }

    /**
     * Upgrades the encoded password of a user, typically for using a better hash algorithm.
     * @param UserInterface $user
     * @param string $newEncodedPassword
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        // TODO: when encoded passwords are in use, this method should:
        // 1. persist the new password in the user storage
        // 2. update the $user object with $user->setPassword($newEncodedPassword);
    }

    /**
     * @param $username
     * @return User
     */
    private function getUser($username): ?User
    {
        $dataStoreHelper = new DataStoreHelper();

        /** @var NetworkResponse $networkResponse */
        $networkResponse = $dataStoreHelper->fetchUser(new NetworkRequest(
            '/members?email=' . $username,
            'GET',
            'asdsad',
            [
                'email' => $username
            ]
        ));

        if (0 === count($networkResponse->getBody())) {
            return null;
        }

        return $this->createUser($networkResponse->getBody()[0]);
    }

    /**
     * @param array $data
     * @return User|null
     */
    private function createUser(array $data): ?User
    {
        if (!$data['id']) {
            return null;
        }

        $user = new User();
        $user->initialize($data['id'], $data['email'], $data['password']);
        return $user;
    }
}

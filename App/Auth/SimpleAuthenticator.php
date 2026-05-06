<?php
namespace App\Auth;
use App\Models\users;
use Framework\Auth\DummyAuthenticator;
use Framework\Auth\SessionAuthenticator;
use Framework\Core\IIdentity;

class SimpleAuthenticator extends SessionAuthenticator {

    public function login($username, $password): bool
    {


        foreach (users::getAll() as $user) {
            if ($user->getMeno() === $username || $user->getEmail() === $username) {
                if (password_verify($password, $user->getHeslo())) {
                    $_SESSION['user'] = $username;
                    return true;
                }
            }
        }
        return false;
    }


    protected function authenticate(string $username, string $password): ?IIdentity
    {
        foreach (users::getAll() as $user) {
            if ($user->getMeno() === $username || $user->getEmail() === $username) {
                if (password_verify($password, $user->getHeslo())) {
                    return $user; // vráť users objekt, nie true
                }
            }
        }
        return null; // nie false, ale null
    }
}
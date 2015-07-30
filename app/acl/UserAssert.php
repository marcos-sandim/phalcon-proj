<?php
namespace App\Acl;

class UserAssert
{
    public function editAssert($parameters)
    {
        $userId = array_shift($parameters);
        $user = \App\Models\User::findFirstById($userId);
        return (bool) $user;
    }

    public function deactivateAssert($parameters)
    {
        $userId = array_shift($parameters);
        $user = \App\Models\User::findFirstById($userId);
        return $user && $user->active;
    }

    public function reactivateAssert($parameters)
    {
        $userId = array_shift($parameters);
        $user = \App\Models\User::findFirstById($userId);
        return $user && !$user->active;
    }
}
<?php

namespace App\Helpers;
use App\Models\User;

class UserHelper
{
    public static function attachRecruiterPermissions($userId)
    {
        $user = User::find($userId);

        if ($user->type === 'seeker') {
            $user->permissions()->sync([1, 2, 3, 4, 5, 6]);
        }

        if ($user->type === 'recruiter') {
            $user->permissions()->sync([1, 2, 3, 4, 5, 6, 7, 8, 9]);
        }

        if ($user->type === 'moderator') {
            $user->permissions()->sync([10,11,12,13,14,15,16,17]);
        }

        if ($user->type === 'admin') {
            $user->permissions()->sync([1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13,14,15,16,17,18,19,20,21,22,23,24,25]);
        }
    }
}
<?php namespace App\Repositories;

use App\Models\User;

class UserRepository
{

    function model()
    {
        return User::class;
    }

    //get users by role
    public function findByRole($role)
    {
        $users = User::whereHas('roles', function ($q) use ($role) {
            $q->where('name', $role);
        })->get();

        return $users;
    }
}

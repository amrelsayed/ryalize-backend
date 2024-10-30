<?php

namespace App\Actions\User;

use App\Models\User;

class UpdateUserAction
{
    public function execute(User $user, array $inputData): User
    {
        $user->name = $inputData["name"];
        $user->email = $inputData["email"];

        if (isset($inputData["password"])) {
            $user->password = bcrypt($inputData["password"]);
        }

        $user->save();

        return $user;
    }
}
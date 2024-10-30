<?php

namespace App\Actions\User;

use App\Models\User;

class CreateUserAction
{
    public function execute(array $inputData): User
    {
        $user = new User();
        $user->name = $inputData["name"];
        $user->email = $inputData["email"];
        $user->password = bcrypt($inputData["password"]);
        $user->save();

        return $user;
    }
}